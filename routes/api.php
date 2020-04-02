<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('token', 'TokenController@getToken');

Route::group([

    'middleware' => ['jwt.auth'],
    'prefix' => ''

], function ($router) {

    //Courses
    Route::get('courses','CourseController@index')->name("getCourseByPagination");
    Route::get('courses/all','CourseController@getAll')->name("getAllCourse");
    Route::get('courses/{id}','CourseController@show')->name("showCourse");
    Route::post('courses','CourseController@store')->name("addCourse");
    Route::put('courses/{id}','CourseController@update')->name("updateCourse");
    Route::delete('courses/{id}','CourseController@destroy')->name("deleteCourse");


    //Students
    Route::get('students','StudentController@index')->name("getStudentByPagination");
    Route::get('students/all','StudentController@getAll')->name("getAllStudent");
    Route::get('students/{id}','StudentController@show')->name("showStudent");
    Route::post('students','StudentController@store')->name("addStudent");
    Route::put('students/{id}','StudentController@update')->name("updateStudent");
    Route::delete('students/{id}','StudentController@destroy')->name("deleteStudent");

});