<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class Util extends Model
{

    /**
     * @var array
     */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public static function getMessages(){

        return [
            'code.required' => 'Code is required',
            'name.required' => 'Name is required',
            'name.min' => 'Name has to have at least :min characters',
            
            'rut.required' => 'Rut is required',
            'name.required' => 'Name is required',
            'lastName.required' => 'Last Name is required',
            'age.required' => 'Age is required',
            'age.min' => 'Age should be more than 18',
            'age.numeric' => 'Age should be a numeric value',
            'course.required' => 'Course is required',
        ];

    }

    public static function getCourseRules(){

        return [
            'code' => 'required|size:4',
            'name' => 'required',
        ];
        
    }

    public static function getStudentRules(){

        return [
            'rut' => 'required',
            'name' => 'required',
            'lastName' => 'required',
            'age' => 'required|numeric|min:19',
            'course' => 'required'
        ];
        
    }

    public static function validate($req, $rules){


        $validator = Validator::make($req, $rules,Util::getMessages());


        $strMessage = "";

        if ($validator->fails()) {

            $errors = $validator->errors();

            foreach ($errors->all() as $message) {
                $strMessage.= $message."<\br>";

            }
        
        }

        return [
            'valid' => $validator->fails(),
            'str' => $strMessage
        ];
        
    }

}
