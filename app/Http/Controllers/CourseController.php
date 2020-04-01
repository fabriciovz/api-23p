<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Course;
use App\Student;

use App\Generic;


use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        DB::beginTransaction();

        try {
                      
            $data = Course::all();//getConocimientos()->where('p_unidades.id',$id)->get();         

        }catch (\Exception $e){
            DB::rollback();
            return response()->json(['success'=> 'false' ,'msg' => 'Error: '.$e->getMessage()], 400);
        }
        
        DB::commit();
        return response()->json(['success'=> 'true' ,'msg' => '', 'items' =>$data], 200);     
    }

    public function getAll()
    {
        DB::beginTransaction();

        try {
                      
            $data = Course::all();  
            
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        DB::beginTransaction();

        try {

            $check = Course::where('id', '=', $id)->count(); 

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

            $check = Course::where('id', '=', $id)->count(); 

            if($check>0){

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
     * Remove the specified resource from storage.
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
