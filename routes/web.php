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

Route::get('/', "HomeController@index");
Route::post('/', "HomeController@index")->name("GetPatientInformation");
Route::get('/hl7', "HomeController@hl7")->name("GetPatientInformationInText");
Route::post('/hl7', "HomeController@hl7")->name("GetPatientInformationInText");
Route::get('/file', "HomeController@getFile")->name("GetPatientInformationFromFile");
