<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Course;
use App\Student;
use App\Util;


use Illuminate\Support\Facades\DB;

use Freshwork\ChileanBundle\Rut;


class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

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
     * Store a newly created resource in storage.
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

            if (!Course::where('id', '=', $request->course)->exists()) {
                return response()->json(['success'=> 'false' ,'msg' => 'Course does not exist'], 400);
            }

            $rut = str_replace('.', '', $request->rut);
           
            if(Rut::parse($rut)->validate()){

                $rut = Rut::parse($rut)->format(Rut::FORMAT_WITH_DASH);
                    //$request->rut = $rut;
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        //print_r($id); die();
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
     * Update the specified resource in storage.
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

                if (!Course::where('id', '=', $request->course)->exists()) {
                    return response()->json(['success'=> 'false' ,'msg' => 'Course does not exist'], 404);
                }

                $rut = str_replace('.', '', $request->rut);
           
                if(Rut::parse($rut)->validate()){    
    
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
     * Remove the specified resource from storage.
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
