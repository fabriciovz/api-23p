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
            'course.required' => 'Course is required',
        ];

    }

    public static function getCourseRules(){

        return [
            'code' => 'required|size:4',
            'name' => 'required|min:1',
        ];
        
    }

    public static function validate($req){


        $validator = Validator::make($req, Util::getCourseRules(),Util::getMessages());

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
