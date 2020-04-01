<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Course;
use App\Student;

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
                      
            $data = Student::all();//getConocimientos()->where('p_unidades.id',$id)->get();         

        }catch (\Exception $e){
            DB::rollback();
            return response()->json(['success'=> 'false' ,'msg' => 'Error: '.$e->getMessage()], 400);
        }
        
        DB::commit();
        return response()->json($data, 200);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        DB::beginTransaction();

        try {

            $check = Student::where('id', '=', $id)->count(); 

            if($check>0){
                $data = Student::find($id)->get();
            }
            else {
                DB::rollback();
                return response()->json(['success'=> 'false' ,'msg' => 'No records found', 'items' => array()], 400);
            }

        }catch (\Exception $e){
            DB::rollback();
            return response()->json(['success'=> 'false' ,'msg' => 'Error: '.$e->getMessage(), 'items' => array()], 400);
        }
        
        DB::commit();
        return response()->json(['success'=> 'true' ,'msg' => '', 'items' =>$data], 200);  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
