<?php

namespace App\Http\Controllers\Admin;

use App\Division;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDivisionController extends Controller
{
    public function showDivision() {
        $divisions = Division::paginate(10);

        return view('admin.division.division-view', [
            'divisions' => $divisions
        ]);
    }

    public function showDivisionEditDetail(Division $id) {
        $division = $id;

        return view('admin.division.division-edit', [
            'division' => $division,
        ]);
    }

    public function submitEdit(Request $request, $id) {
        $validatedData = $request->validate([
            'division_name' => 'required|unique:divisions,division_name,' . $id . ',id',
        ]);

        $township = Division::find($id);
        $township->fill($validatedData)->save();
        return back()->with('success', 'Successfully Updated');
    }

    public function showCreateForm() {
        $divisions = Division::all();

        return view('admin.division.division-create', [
            'divisions' => $divisions,
        ]);
    }

    public function submitCreate(Request $request) {
        $validatedData = $request->validate([
            'division_name' => 'required|unique:divisions,division_name',
        ]);
        $township = new Division();
        $township->fill($validatedData)->save();
        return redirect()->route('admin.data.division')->with('success', 'Successfully Created');
    }
}
