<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Validator;


class Util extends Model
{

    /**
     * @var array
     */

    /**
     * @return array of validations
     */
    public static function getMessages(){

        return [
            //associated messages to course
            'code.required' => 'Code is required',
            'name.required' => 'Name is required',
            'name.min' => 'Name has to have at least :min characters',
            
            //associated messages to students
            'rut.required' => 'Rut is required',
            'name.required' => 'Name is required',
            'lastName.required' => 'Last Name is required',
            'age.required' => 'Age is required',
            'age.min' => 'Age should be more than 18',
            'age.numeric' => 'Age should be a numeric value',
            'course.required' => 'Course is required',
        ];

    }

    /**
     * @return array of rules (Course)
     */
    public static function getCourseRules(){

        return [
            'code' => 'required|size:4',
            'name' => 'required',
        ];
        
    }

    /**
     * @return array of rules (Student)
     */
    public static function getStudentRules(){

        return [
            'rut' => 'required',
            'name' => 'required',
            'lastName' => 'required',
            'age' => 'required|numeric|min:19',
            'course' => 'required'
        ];
        
    }

    /**
     * Check if a request is valid.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Request  $rules
     * @return \Illuminate\Http\Response
     */
    public static function validate($req, $rules){

        //Validate if a request is valid
        $validator = Validator::make($req, $rules,Util::getMessages());

        $strMessage = "";

        //If the request is not valid then...
        if ($validator->fails()) {

            //get errors 
            $errors = $validator->errors();

            //iterate  to make a string 
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
