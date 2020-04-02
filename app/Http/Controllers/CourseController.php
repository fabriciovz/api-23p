<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Persistent Models
use App\Course;
use App\Student;

//Non Persistent Models
use App\Util;


//Class to manage endpoints of Course 
class CourseController extends Controller
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
             
            //Get the data with pagination - (paginate comes from Eloquent Model - 5 is the page size)
            $data = Course::paginate(5);
                    
            //If the total is minor than 1 then....
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
     * Display a listing of all courses.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        DB::beginTransaction();

        try {
                
            //Get all records from course
            $data = Course::all();  
            
            //If the total is minor than 1 then....
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
     * Store a created course.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        DB::beginTransaction();

        try{                     
        
            //First of all it needs to check if the data from request is valid
            $validate = Util::validate($request->all(), Util::getCourseRules());

            //If the data is not valid then...
            if($validate['valid']){

                return response()->json(['success'=> 'false' ,'msg' => $validate['str']], 400);
            } 
            
            //If the data is valid it can be saved
            $data = new Course($request->all());                   
            $data->save();  
          
            
        }catch (\Exception $e){
            DB::rollback();
            return response()->json(['success'=> 'false' ,'msg' => 'Error: '.$e->getMessage()], 400);
        }
        DB::commit();
        return response()->json(['success'=> 'true' ,'msg' => 'Created Successfully ','items' =>$data ], 201);
    
    
    }

    /**
     * Display the specified course.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        DB::beginTransaction();

        try {

            //Check if the course exists
            $check = Course::where('id', '=', $id)->count(); 

            //If the query has more than 0 records, it can be displayed
            if($check>0){
                $data = Course::find($id);
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
        return response()->json(['success'=> 'true' ,'msg' => 'Record Found', 'items' =>$data], 200);     
    }

     /**
     * Update the specified course.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
        DB::beginTransaction();

        try {

            //Check if the course exists
            $check = Course::where('id', '=', $id)->count(); 

            //If the query has more than 0 records, it can be saved
            if($check>0){

                //It needs to check if the data from request is valid
                $validate = Util::validate($request->all(), Util::getCourseRules());

                //If the data is not valid then...
                if($validate['valid']){

                    return response()->json(['success'=> 'false' ,'msg' => $validate['str']], 400);
                } 

                $data = Course::find($id);
                $data->fill($request->all());
                $data->save();
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
     * Remove the specified course.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    
        DB::beginTransaction();

        try {     
            
            $check = Course::where('id', '=', $id)->count(); 

            if($check>0){

                $data = Course::find($id);
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
