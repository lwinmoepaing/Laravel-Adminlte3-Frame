<?php

namespace App\Http\Controllers\Admin;

use App\Division;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminTownshipRequest;
use App\Township;
use Illuminate\Http\Request;

class AdminTownshipController extends Controller
{
    //

    public function showTownship() {
        $townships = Township::with(['division'])->paginate(20);
        $divisions = Division::all();

        return view('admin.township.township-view', [
            'townships' => $townships,
            'divisions' => $divisions
        ]);
    }

    public function showTownshipEditDetail(Township $id) {
        $township = $id->load(['division']);
        $divisions = Division::all();

        return view('admin.township.township-edit', [
            'township' => $township,
            'divisions' => $divisions,
        ]);
    }

    public function submitEdit(AdminTownshipRequest $request, $id) {
        $validated = $request->validated();
        $township = Township::find($id);
        $township->fill($validated)->save();
        return back()->with('success', 'Successfully Updated');
    }

    public function showCreateForm() {
        $divisions = Division::all();

        return view('admin.township.township-create', [
            'divisions' => $divisions,
        ]);
    }

    public function submitCreate(AdminTownshipRequest $request) {
        $validated = $request->validated();
        $township = new Township();
        $township->fill($validated)->save();
        return redirect()->route('admin.data.township')->with('success', 'Successfully Created');
    }
}
