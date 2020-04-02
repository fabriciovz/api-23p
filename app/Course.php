<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
      /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'course';

    /**
     * @var array of elements which can be saved
     */
    protected $fillable = ['code', 'name', 'created_at', 'updated_at'];

    //Method to access from Course to Student - One to Many relation
    public function student()
    {
        return $this->hasMany('App\Student', 'course');
    }


}
