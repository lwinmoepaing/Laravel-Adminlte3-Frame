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

    public function showCreateForm() {
        return view('admin.department.department-create');
    }

    public function showDepartmentEditDetail(Department $id)  {
        $department = $id;


        return view('admin.department.department-edit', [
            'department' => $department
        ]);
    }

    public function submitEdit(Request $request, $id) {

        $validatedData = $request->validate([
            'department_name' => 'required|unique:departments,department_name,' . $id . ',id',
        ]);

        $department = Department::find($id);
        $department->fill($validatedData)->save();
        return back()->with('success', 'Successfully Updated');
    }

    public function submitCreate(Request $request) {
        $validatedData = $request->validate([
            'department_name' => 'required|unique:departments,department_name',
        ]);

        $department = new Department();
        $department->fill($validatedData)->save();
        return redirect()->route('admin.data.department')->with('success', 'Successfully Added');
    }

}
