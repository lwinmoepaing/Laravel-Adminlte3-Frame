<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDepartmentController extends Controller
{
    //

    public function showDepartment()
    {
        $departments = Department::paginate(20);

        return view('admin.department.department-view', [
            'departments' => $departments,
        ]);
    }
}
