<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
         /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'student';

    /**
     * @var array
     */
    protected $fillable = ['rut', 'name', 'lastName', 'age',  'course', 'created_at', 'updated_at'];


    public function course()
    {
        return $this->belongsTo('App\Course', 'course');
    }

}
