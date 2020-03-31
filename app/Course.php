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
     * @var array
     */
    protected $fillable = ['code', 'name', 'created_at', 'updated_at'];


    public function student()
    {
        return $this->hasMany('App\Student', 'course');
    }


}
