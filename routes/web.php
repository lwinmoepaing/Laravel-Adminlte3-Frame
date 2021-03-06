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

// Appointment For Uabpay
Route::name('client.')->prefix('/client')->group(function () {
    Route::get('dashboard', 'ClientView\ClientMobileController@showDashboard')->name('dashboard');
    Route::get('join-appointment', 'ClientView\ClientMobileController@showJoinAppointment')->name('join-appointment');
    Route::post('join-appointment', 'ClientView\ClientMobileController@submitJoinAppointment')->name('join-appointment-submit');

    Route::get('make-appointment', 'ClientView\ClientMobileController@showMakeAppointment')->name('make-appointment');
    Route::post('make-appointment', 'ClientView\ClientMobileController@appointmentSubmitFromUabpay')->name('make-appointment-submit');

    Route::get('appointments-by-status/{status}', 'ClientView\ClientMobileController@showAppointmentByStatus')->name('appointmens-by-status');
    Route::get('appointment-detail/{appointment_id}', 'ClientView\ClientMobileController@showAppointmentDetail')->name('appointmen-detail');
    Route::post('appointment-detail/{appointment_id}', 'ClientView\ClientMobileController@updateAttendanceStatus')->name('appointmen-detail-update-status');
    Route::get('appointment-detail/{appointment_id}/snooze', 'ClientView\ClientMobileController@showSnoozeAppointment')->name('appointmen-snooze');
});

// Appointment for Client View
Route::name('appointment.')->prefix('/appointment')->group(function () {
    Route::get('/', 'ClientView\ClientViewController@index')->name('index');
    Route::get('/request', 'ClientView\ClientViewController@index')->name('view');
    Route::get('/invite-visitor', 'ClientView\ClientViewController@showInviteVisitor')->name('invite-visitor');
    Route::post('/invite-visitor', 'ClientView\ClientViewController@appointSubmitByOfficer')->name('invite-visitor-submit');
    Route::post('/request', 'ClientView\ClientViewController@appointSubmit')->name('submit');
    Route::post('/check-staff-email', 'ClientView\ClientViewController@checkStaffEmail')->name('checkStaffEmail');
    Route::post('/check-visitor', 'ClientView\ClientViewController@checkVisitor')->name('checkVisitor');
    Route::get('/confirm', 'ClientView\ClientViewController@showConfirm')->name('confirm-view');
    Route::get('/confirm/{appointment_id}', 'Appointment\AppointmentController@confirmFromClient')->name('client-confirm');
});

// Appoints For AdminDashboard
Route::name('admin.')->middleware(['auth'])->prefix('/admin')->group(function () {
    Route::get('/', 'Admin\AdminAppointmentController@showDashboard')->name('index'); // admin.index
    Route::get('/dashboard', 'Admin\AdminAppointmentController@showDashboard')->name('dashboard'); // admin.dashboard

    Route::name('appointment.')->prefix('/appointment')->group(function () {
        // Appointment
        Route::get('/', 'Admin\AdminAppointmentController@showTodayAppointmentList')->name('appointment-view'); // admin.appointment.appointment-view
        Route::get('/appointment-create', 'Admin\AdminAppointmentController@showCreateForm')->name('appointment-create'); // admin.appointment.appointment-create
        Route::post('/appointment-create', 'Admin\AdminAppointmentController@submitCreate')->name('appointment-create-submit'); // admin.appointment.appointment-create
        Route::get('/{appointment_id}', 'Admin\AdminAppointmentController@showAppointmentDetail')->name('appointment-detail'); // admin.appointment.appointment-detail
        Route::post('/{appointment_id}', 'Admin\AdminAppointmentController@submitUpdateAppointment')->name('appointment-status-update'); // admin.appointment.appointment-status-update
        Route::get('/appointment-edit/{appointment_id}', 'Admin\AdminAppointmentController@showAppointmentEditDetail')->name('appointment-edit'); // admin.appointment.appointment-edit
        Route::post('/appointment-edit/{appointment_id}', 'Admin\AdminAppointmentController@submitEdit')->name('appointment-edit-submit'); // admin.appointment.appointment-edit
    });


    Route::name('rooms.')->prefix('/rooms')->group(function () {
        // Rooms
        Route::get('/', 'Admin\AdminRoomController@showRooms')->name('index'); // admin.rooms.index
        Route::get('/room-edit/{id}', 'Admin\AdminRoomController@showRoomEditDetail')->name('room-edit'); // admin.rooms.room-edit
        Route::post('/room-edit/{id}', 'Admin\AdminRoomController@submitEdit')->name('room-edit-submit'); // admin.rooms.room-edit-submit
        Route::get('/room-create', 'Admin\AdminRoomController@showCreateForm')->name('room-create'); // admin.rooms.room-create
        Route::post('/room-create', 'Admin\AdminRoomController@submitCreate')->name('room-create-submit'); // admin.rooms.room-create-submit
        Route::get('/detail/{id}', 'Admin\AdminRoomController@showRoomDetail')->name('room-detail'); // admin.rooms.room-detail
        Route::delete('/{id}', 'Admin\AdminRoomController@deleteRoom')->name('room-remove');

        Route::get('/appointment-view', 'Admin\AdminRoomController@showAppointmentRooms')->name('appointment-view'); // admin.rooms.appointment
    });

    Route::name('reports.')->prefix('/reports')->group(function () {
        // Reports
        Route::get('/', 'Admin\AdminReportController@showReportDashboard')->name('dashboard');

        // Reports Departments
        Route::get('/departments', 'Admin\AdminReportController@showDepartmentList')->name('departments');
        Route::post('/export-departments', 'Admin\AdminReportController@exportDepartment')->name('export-departments');
        Route::post('/export-departments-pdf', 'Admin\AdminReportController@exportDepartmentPDF')->name('export-departments-pdf');
        Route::get('/departments/{department_id}', 'Admin\AdminReportController@showDepartmentDetail')->name('departments-detail');
        Route::post('/departments/{department_id}', 'Admin\AdminReportController@exportDepartmentDetail')->name('export-departments-detail');
        Route::post('/departments-pdf/{department_id}', 'Admin\AdminReportController@exportDepartmentDetailPDF')->name('export-departments-detail-pdf');

        // Reports Visitors
        Route::get('/visitors', 'Admin\AdminReportController@showVisitorList')->name('visitors');
        Route::post('/export-visitors', 'Admin\AdminReportController@exportVisitor')->name('export-visitors');
        Route::post('/export-visitors-pdf', 'Admin\AdminReportController@exportVisitorPDF')->name('export-visitors-pdf');
        Route::get('/visitors/{visitor_email}', 'Admin\AdminReportController@showVisitorDetail')->name('visitors-detail');
        Route::post('/visitors/{visitor_email}', 'Admin\AdminReportController@exportVisitorDetail')->name('export-visitors-detail');
        Route::post('/visitors-pdf/{visitor_email}', 'Admin\AdminReportController@exportVisitorDetailPDF')->name('export-visitors-detail-pdf');
    });

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

        // Townships????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????????
        Route::get('/township', 'Admin\AdminTownshipController@showTownship')->name('township');
        Route::get('/township-edit/{id}', 'Admin\AdminTownshipController@showTownshipEditDetail')->name('township-edit');
        Route::post('/township-edit/{id}', 'Admin\AdminTownshipController@submitEdit')->name('township-edit-submit');
        Route::get('/township-create', 'Admin\AdminTownshipController@showCreateForm')->name('township-create');
        Route::post('/township-create', 'Admin\AdminTownshipController@submitCreate')->name('township-create-submit');

        // Divisions And Cities
        Route::get('/city', 'Admin\AdminDivisionController@showDivision')->name('division');
        Route::get('/city-edit/{id}', 'Admin\AdminDivisionController@showDivisionEditDetail')->name('division-edit');
        Route::post('/city-edit/{id}', 'Admin\AdminDivisionController@submitEdit')->name('division-edit-submit');
        Route::get('/city-create', 'Admin\AdminDivisionController@showCreateForm')->name('division-create');
        Route::post('/city-create', 'Admin\AdminDivisionController@submitCreate')->name('division-create-submit');
    });


});

Route::name('common.')->prefix('/common')->group(function () {
    Route::post('/check-invite-member', 'ClientView\ClientMobileController@checkInvitorWithPhone')->name('check-invite-member');
});

Auth::routes();
