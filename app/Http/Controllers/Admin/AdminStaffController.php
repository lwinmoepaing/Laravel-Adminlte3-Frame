<?php

namespace App\Http\Controllers\Admin;

use App\Branch;
use App\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminStaffFormRequest;
use App\Staff;
use App\StaffRole;
use Illuminate\Http\Request;

class AdminStaffController extends Controller
{
    //

    public function showStaff(Request $request) {

        $staffQuery = Staff::with(['role', 'branch']);
        $queryEmail = $request->query('email');
        $queryPhone = $request->query('phone');
        $queryName = $request->query('name');

        if ($queryEmail) {
            $staffQuery->where('email', $queryEmail);
        }

        if ($queryPhone) {
            $staffQuery->where('phone', $queryPhone);
        }

        if ($queryName) {
            $staffQuery->where('name', 'LIKE', "%{$queryName}%");
        }

        $staffs = $staffQuery->orderBy('id', 'DESC')->paginate(10);

        return view('admin.staff.staff-view', [
            'navTitle' => 'Staff',
            'staffs' => $staffs,
            'queryEmail' => $queryEmail,
            'queryPhone' => $queryPhone,
            'queryName' => $queryName,
        ]);
    }

    public function showStaffDetail(Staff $id)  {

        $staffs = $id->load(['role', 'branch', 'department']);

        // return response()->json($staffs);

        return view('admin.staff.staff-detail', [
            'navTitle' => 'Staff',
            'staff' => $staffs
        ]);
    }

    public function showStaffEditDetail(Staff $id)  {

        $staff = $id->load(['role', 'branch', 'department']);

        $branches = Branch::with('township')->get();
        $departments = Department::all();
        $staffRoles = StaffRole::all();

        // return response()->json($staffRoles);

        return view('admin.staff.staff-edit', [
            'navTitle' => 'Staff',
            'staff' => $staff,
            'branches' => $branches,
            'departments' => $departments,
            'staffRoles' => $staffRoles,
        ]);
    }

    public function showCreateForm() {
        $branches = Branch::with('township')->get();
        $departments = Department::all();
        $staffRoles = StaffRole::all();

        return view('admin.staff.staff-create', [
            'navTitle' => 'Staff',
            'branches' => $branches,
            'departments' => $departments,
            'staffRoles' => $staffRoles,
        ]);
    }

    public function submitCreate(AdminStaffFormRequest $request) {
        $validated = $request->validated();

        $existingStaff = Staff::withTrashed()->where('email', $request->email)->first();

        if ($existingStaff) {
            if ($existingStaff->trashed()) {
                return back()
                    ->with('already-email', 'This email user is deleted !!')
                    ->with('restore', 'Do you want to recover this account ??')
                    ->withInput();
            }

            return back()
                ->with('already-email', 'Email is Already Used')
                ->withInput();
        }

        $newStaff = new Staff();
        $newStaff->fill($validated);
        $newStaff->save();

        return redirect()->route('admin.data.staff')->with('success', 'Successfully Created ' . $newStaff->name . ' (' . $newStaff->email . ')');
    }

    public function submitEdit(AdminStaffFormRequest $request, $id) {
        $validated = $request->validated();

        $staff = Staff::find($id);
        $compareStaff = Staff::where('email', $request->email)->first();

        if ($compareStaff && $compareStaff->id !== $staff->id) {
            return back()
                ->with('already-email', 'Email is Already Used')
                ->withInput();
        }

        $staff->fill($validated)->save();

        return back()->with('success', 'Successfully Updated');
    }

    public function deleteStaff(Staff $id) {
        $staff = $id;
        $staff->delete();
        return back()->with('success', 'Successfully Deleted ' . $staff->name . ' (' . $staff->email . ')');
    }

    public function restoreStaff(Request $request) {
        $staff = Staff::withTrashed()->where('email', $request->email)->first();
        $staff->restore();
        return redirect()->route('admin.data.staff', ['email' => $request->email ])->with('success', 'Successfully Restore ' . $staff->name . ' (' . $staff->email . ')');
    }
}
