<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', 'Auth\LoginController@showloginForm')->name('index');

// Appointment for Client View
Route::name('appointment.')->prefix('/appointment')->group(function () {
    Route::get('/', 'ClientView\ClientViewController@index')->name('index');
    Route::get('/request', 'ClientView\ClientViewController@index')->name('view');
    Route::post('/request', 'ClientView\ClientViewController@appointSubmit')->name('submit');
    Route::get('/confirm/{appointment_id}', 'Appointment\AppointmentController@checkConfirm')->name('checkconfirm');
});

// Appoints For AdminDashboard
Route::name('admin.')->middleware(['auth'])->prefix('/admin')->group(function () {
    Route::get('/', 'Admin\AdminController@index')->name('index'); // admin.index
    Route::get('/dashboard', 'Admin\AdminController@index')->name('dashboard'); // admin.dashboard
    Route::get('/rooms', 'Admin\AdminController@showRooms')->name('rooms'); // admin.rooms
    Route::get('/appointment', 'Admin\AdminController@showAppointment')->name('appointment'); // admin.appointment
    Route::get('/appointment/{appintment_id}', 'Admin\AdminController@showAppointmentDetail')->name('appointment.detail');

    /**
     * Routes For Data
     * Data => [ 'data/staffs', 'data/departments', 'data/branches', * ]
     */
    Route::name('data.')->prefix('/data')->group(function () {
        //
    });
});


Auth::routes();
