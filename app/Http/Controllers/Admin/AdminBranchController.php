<?php

namespace App\Http\Controllers\Admin;

use App\Branch;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminBranchFormRequest;
use App\Township;
use Illuminate\Http\Request;

class AdminBranchController extends Controller
{
    //
    public function showBranch(){
        $branches = Branch::with(['township'])->paginate(20);

        return view('admin.branch.branch-view', [
            'navTitle' => 'Branch',
            'branches' => $branches,
        ]);
    }

    public function showStaffEditDetail(Branch $id)  {

        $branch = $id->load(['township']);
        $townships = Township::all();

        return view('admin.branch.branch-edit', [
            'navTitle' => 'Branch',
            'branch' => $branch,
            'townships' => $townships,
        ]);
    }

    public function showCreateForm()  {

        $townships = Township::all();
        return view('admin.branch.branch-create', [
            'navTitle' => 'Branch',
            'townships' => $townships,
        ]);
    }

    public function submitEdit(AdminBranchFormRequest $request, $id) {
        $validated = $request->validated();

        $branch = Branch::find($id);

        $branch->fill($validated)->save();

        return back()->with('success', 'Successfully Updated');
    }

    public function submitCreate(AdminBranchFormRequest $request) {
        $validated = $request->validated();
        $branch = new Branch();
        $branch->fill($validated)->save();
        return redirect()->route('admin.data.branch')->with('success', 'Successfully added branch.');
    }

}
