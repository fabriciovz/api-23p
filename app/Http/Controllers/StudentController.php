<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Persistent Models
use App\Course;
use App\Student;

//Non Persistent Models
use App\Util;


//I installed "freshwork/chilean-bundle" package to check if a rut is valid and format them
use Freshwork\ChileanBundle\Rut;


//Class to manage endpoints of Student 
class StudentController extends Controller
{
    /**
     * Display a listing of courses with pagination.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        DB::beginTransaction();

        try {
                      
            $data = Student::paginate(5);

            if($data->total()<1){
                DB::rollback();
                return response()->json(['success'=> 'false' ,'msg' => 'No records found'], 404);
            }

        }catch (\Exception $e){
            DB::rollback();
            return response()->json(['success'=> 'false' ,'msg' => 'Error: '.$e->getMessage()], 400);
        }
        
        DB::commit();
        return response()->json(['success'=> 'true' ,'msg' => 'Record(s) Found', 'items' =>$data], 200);     
    }

    /**
     * Display a listing of all students.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        DB::beginTransaction();

        try {
                      
            $data = Student::all(); 
            
            if(count($data)<1){
                DB::rollback();
                return response()->json(['success'=> 'false' ,'msg' => 'No records found'], 404);
            }

        }catch (\Exception $e){
            DB::rollback();
            return response()->json(['success'=> 'false' ,'msg' => 'Error: '.$e->getMessage()], 400);
        }
        
        DB::commit();
        return response()->json(['success'=> 'true' ,'msg' => 'Record(s) Found', 'items' =>$data], 200);     
    }

    /**
     * Store a created student.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try{   
            
            $validate = Util::validate($request->all(),Util::getStudentRules());

            if($validate['valid']){
                return response()->json(['success'=> 'false' ,'msg' => $validate['str']], 400);
            } 

            //Check if the course does not exist
            if (!Course::where('id', '=', $request->course)->exists()) {
                return response()->json(['success'=> 'false' ,'msg' => 'Course does not exist'], 400);
            }

            //Remove all dots from rut
            $rut = str_replace('.', '', $request->rut);
           
            //Check if the rut is valid 
            if(Rut::parse($rut)->validate()){

                //Format the rut (XXXXXXXX-X)
                $rut = Rut::parse($rut)->format(Rut::FORMAT_WITH_DASH);

                $data = new Student($request->all()); 
                $data->rut = $rut;
                $data->save(); 
                
            }
           
        }catch (\Exception $e){
            DB::rollback();
            return response()->json(['success'=> 'false' ,'msg' => 'Error: '.$e->getMessage()], 400);
        }
        DB::commit();
        return response()->json(['success'=> 'true' ,'msg' => 'Created Successfully ','items' =>$data ], 201);
    }

    /**
     * Display the specified student.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        DB::beginTransaction();

        try {

            $check = Student::where('id', '=', $id)->count(); 

            if($check>0){
                $data = Student::find($id);
            }
            else {
                DB::rollback();
                return response()->json(['success'=> 'false' ,'msg' => 'No records found'], 400);
            }

        }catch (\Exception $e){
            DB::rollback();
            return response()->json(['success'=> 'false' ,'msg' => 'Error: '.$e->getMessage()], 400);
        }
        
        DB::commit();
        return response()->json(['success'=> 'true' ,'msg' => 'Record Found', 'items' =>$data], 200);  
    }

    /**
     * Update the specified student.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        DB::beginTransaction();

        try {

            $check = Student::where('id', '=', $id)->count(); 

            if($check>0){

                $validate = Util::validate($request->all(),Util::getStudentRules());

                if($validate['valid']){
                    return response()->json(['success'=> 'false' ,'msg' => $validate['str']], 400);
                } 

                //Check if the course does not exist
                if (!Course::where('id', '=', $request->course)->exists()) {
                    return response()->json(['success'=> 'false' ,'msg' => 'Course does not exist'], 404);
                }

                //Remove all dots from rut
                $rut = str_replace('.', '', $request->rut);
           
                //Check if the rut is valid 
                if(Rut::parse($rut)->validate()){    
    
                    //Format the rut (XXXXXXXX-X)
                    $rut = Rut::parse($rut)->format(Rut::FORMAT_WITH_DASH);

                    $data = Student::find($id);
                    $data->fill($request->all());
                    $data->rut = $rut;
                    $data->save();
                }

            }
            else {
                DB::rollback();
                return response()->json(['success'=> 'false' ,'msg' => 'No records found'], 404);
            }
            
        }catch (\Exception $e){
            DB::rollback();
            return response()->json(['success'=> 'false' ,'msg' => 'Error: '.$e->getMessage()], 400);
        }
        DB::commit();
        return response()->json(['success'=> 'true' ,'msg' => 'Updated Successfully', 'items' =>$data], 200);    

    }

    /**
     * Remove the specified student.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {     
            
            $check = Student::where('id', '=', $id)->count(); 

            if($check>0){

                $data = Student::find($id);
                $data->delete();  
            }
            else {
                DB::rollback();
                return response()->json(['success'=> 'false' ,'msg' => 'No records found'], 404);
            }    

        }catch (\Exception $e){
            DB::rollback();
            return response()->json(['success'=> 'false'  ,'msg' => 'Error: '.$e->getMessage()], 400);
        }
        DB::commit();
        return response()->json(['success'=> 'true' ,'msg' => 'Deleted Successfully', 'items' =>$data], 200); 
    }
}
