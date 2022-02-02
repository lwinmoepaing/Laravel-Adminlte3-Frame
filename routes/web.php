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
    Route::get('/confirm/{appointment_id}', 'Appointment\AppointmentController@confirmFromClient')->name('client-confirm');
});

// Appoints For AdminDashboard
Route::name('admin.')->middleware(['auth'])->prefix('/admin')->group(function () {
    Route::get('/', 'Admin\AdminController@index')->name('index'); // admin.index
    Route::get('/dashboard', 'Admin\AdminController@index')->name('dashboard'); // admin.dashboard
    Route::get('/rooms', 'Admin\AdminController@showRooms')->name('rooms'); // admin.rooms
    Route::get('/appointment', 'Admin\AdminController@showAppointment')->name('appointment'); // admin.appointment
    Route::get('/appointment/{appintment_id}', 'Admin\AdminController@showAppointmentDetail')->name('appointment.detail'); // admin.appointment.detail

    /**
     * Routes For Data
     * Data => [ 'data/staffs', 'data/departments', 'data/branches', * ]
     */
    Route::name('data.')->prefix('/data')->group(function () {
        // Staff Functions
        Route::get('/staff', 'Admin\AdminStaffController@showStaff')->name('staff');
        Route::get('/staff/{id}', 'Admin\AdminStaffController@showStaffDetail')->name('staff-detail');
        Route::delete('/staff/{id}', 'Admin\AdminStaffController@deleteStaff')->name('staff-remove');
        Route::get('/staff-create', 'Admin\AdminStaffController@showCreateForm')->name('staff-create');
        Route::post('/staff-create', 'Admin\AdminStaffController@submitCreate')->name('staff-create-submit');
        Route::post('/staff-recover', 'Admin\AdminStaffController@restoreStaff')->name('staff-recover');
        Route::get('/staff-edit/{id}', 'Admin\AdminStaffController@showStaffEditDetail')->name('staff-edit');
        Route::post('/staff-edit/{id}', 'Admin\AdminStaffController@submitEdit')->name('staff-edit-submit');

        // Departments Functions
        Route::get('/department', 'Admin\AdminDepartmentController@showDepartment')->name('department');
        Route::get('/department-create', 'Admin\AdminDepartmentController@showCreateForm')->name('department-create');
        Route::post('/department-create', 'Admin\AdminDepartmentController@submitCreate')->name('department-create-submit');
        Route::get('/department-edit/{id}', 'Admin\AdminDepartmentController@showDepartmentEditDetail')->name('department-edit');
        Route::post('/department-edit/{id}', 'Admin\AdminDepartmentController@submitEdit')->name('department-edit-submit');

        // Branches
        Route::get('/branch', 'Admin\AdminBranchController@showBranch')->name('branch');
        Route::get('/branch-edit/{id}', 'Admin\AdminBranchController@showStaffEditDetail')->name('branch-edit');
        Route::post('/branch-edit/{id}', 'Admin\AdminBranchController@submitEdit')->name('branch-edit-submit');
        Route::get('/branch-create', 'Admin\AdminBranchController@showCreateForm')->name('branch-create');
        Route::post('/branch-create', 'Admin\AdminBranchController@submitCreate')->name('branch-create-submit');

        // Townships
        Route::get('/township', 'Admin\AdminTownshipController@showTownship')->name('township');
        Route::get('/township-edit/{id}', 'Admin\AdminTownshipController@showTownshipEditDetail')->name('township-edit');
        Route::post('/township-edit/{id}', 'Admin\AdminTownshipController@submitEdit')->name('township-edit-submit');
        Route::get('/township-create', 'Admin\AdminTownshipController@showCreateForm')->name('township-create');
        Route::post('/township-create', 'Admin\AdminTownshipController@submitCreate')->name('township-create-submit');

        // Divisions And Cities
        Route::get('/city', 'Admin\AdminController@showStaff')->name('city');
    });
});


Auth::routes();
