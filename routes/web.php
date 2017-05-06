<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function(){
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
<<<<<<< HEAD
Route::any('/groups/search',['uses'=>'LA\GroupsController@search']);
Route::any('/groups/searchEmployees',['uses'=>'LA\GroupsController@searchEmployees']);
=======
>>>>>>> 00470bd13a3bedc4d46001d91b28d7d3ec90805a

/* ================== Homepage + Admin Routes ================== */

require __DIR__.'/admin_routes.php';

