<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::resource('courses','CourseController');
//Courses
Route::get('courses','CourseController@index');
Route::get('courses/all','CourseController@getAll');
Route::get('courses/{id}','CourseController@show');
Route::post('courses','CourseController@store')->name("addCourse");
Route::put('courses/{id}','CourseController@update')->name("updateCourse");
Route::delete('courses/{id}','CourseController@destroy')->name("deleteCourse");


//Students
Route::get('students','StudentController@index');
Route::get('students/all','StudentController@getAll');
Route::get('students/{id}','StudentController@show');
Route::post('students','StudentController@store');

