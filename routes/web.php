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


Route::get("meals","All@show");         //<----- se koristi






//Route::get("/meals?per_page=5" , "All@link");          //->name('per_page'); imenovanje rute


//Route::get("meals","All@index");


//Route::get("mealsCheck","All@dbCheck");

