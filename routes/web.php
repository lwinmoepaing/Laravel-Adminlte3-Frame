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

Route::get('/', 'Home\HomeController@index')->name('home');
Route::post('/', 'Home\HomeController@postMail')->name('postMail');
Route::get('/appointment-request', 'ClientView\ClientViewController@index')->name('appointment.view');
Route::post('/appointment-request', 'ClientView\ClientViewController@appointSubmit')->name('appointment.submit');
