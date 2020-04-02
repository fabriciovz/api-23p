<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Student extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('rut', 15);
            $table->string('name', 100);
			$table->string('lastName', 100);
            $table->integer('age'); 
            
            $table->unsignedInteger('course')->index('student_course'); 

            $table->foreign('course')->references('id')->on('course')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('evaluaciones');
    }
}
