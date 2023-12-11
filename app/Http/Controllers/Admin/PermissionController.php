<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Exports\PermissionExport;
use App\Http\Controllers\Controller;
use App\Imports\PermissionImport;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use PDF;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        $selectedValue = $request->query('perPage', session('pagination_permissions', 10));

        $permissions = Permission::paginate($selectedValue);

        if ($request->ajax()) {
            // If it's an AJAX request, return the updated pagination data as a rendered view
            return view('vendor.pagination.custom', ['permissions' => $permissions])->render();
        }

        // Store the selected value in the session
        session(['pagination_permissions' => $selectedValue]);

        return view('admin.permission.index', compact('permissions', 'selectedValue'));
    }

    public function create(){

        return view('admin.permission.create');
    }

    public function store(Request $request){
        $validated=$request->validate([
                'name'=>['required','unique:permissions'],
                'group_name'=>'required'
        ]);
        Permission::create($validated);

        return redirect()->route('admin.permissions.index')->with('message','Permission Created successfully');
    }
    public function edit(Permission $permission){

        return view('admin.permission.edit',compact('permission'));
    }
    public function update(Request $request,Permission $permission){
        // dd($request);
        $validated=$request->validate([
            'name'=>"required|max:255|unique:permissions,name,{$permission->id}",
            'group_name'=>'required'
            ]);
        $permission->update($validated);

        return redirect()->route('admin.permissions.index')->with('message','Permission Updated successfully');
    }
    public function destroy(Permission $permission){
        $permission->delete();
        return redirect()->route('admin.permissions.index')->with('error','Permission Deleted successfully');
    }
    public function show(Permission $permission){

        return view('admin.permission.show',compact('permission'));
    }
    public function import(){
    //    dd('hello');
        return view('admin.permission.import');
    }
    public function importPermission(Request $request){
        Excel::import(new PermissionImport, $request->file('import_file'));
        return redirect()->route('admin.permissions.index')->with('message','Permission Imported successfully');
    }

     //    export pdf
     public function exportpdf(Request $request){
        $selectedRowValues = $request->input('selectedRows');

        // Convert the comma-separated string into an array
        $selectedRows = explode(',', $selectedRowValues);

        if($selectedRowValues==null){

            $permissions=Permission::all();
           $data=[
            'title' => 'Permissions',
            'date' => date('d/m/Y'),

            'permissions'=>$permissions,
           ];

           $pdf = PDF::loadView('admin.permission.export-pdf', $data)->setPaper('A4');

           return $pdf->stream('Permissions.pdf');
        }

        $permissions=Permission::whereIn('id',$selectedRows)->get();
        $data=[
            'title' => 'Permissions',
            'date' => date('d/m/Y'),
            'permissions'=>$permissions,
           ];

           $pdf = PDF::loadView('admin.permission.export-pdf', $data)->setPaper('A4');

           return $pdf->stream('Permissions.pdf');




    }
    // export csv
    public function exportselectedcsv(Request $request)
    {
        $selectedRowValues = $request->input('selectedRows');

        // Convert the comma-separated string into an array
        $selectedRows = explode(',', $selectedRowValues);
        return (new PermissionExport($selectedRows))->download('permissions.csv') ;


    }

    public function search(Request $request){
        $search=$request->input('search');

        $selectedValue = $request->query('perPage', session('pagination_permission', 10));

        $permissions = Permission::paginate($selectedValue);

        if ($request->ajax()) {
            // If it's an AJAX request, return the updated pagination data as a rendered view
            return view('vendor.pagination.custom', ['permissions' => $permissions])->render();
        }

        // Store the selected value in the session
        session(['pagination_permission' => $selectedValue]);

        $permissions = Permission::select()
                        ->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('group_name', 'LIKE', "%{$search}%")
                        ->paginate($selectedValue);
        return view ('admin.permission.index',compact('permissions','selectedValue'));

    }

    public function deleteSelected(Request $request)
    {
        $selectedpermissions = $request->input('selectedRows'); // Get the selected rows
        $selectedRows = explode(',', $selectedpermissions);
        foreach ($selectedRows as $permissionId) {
            $permission = Permission::find($permissionId);

            if ($permission) {
                // dd($permission);
                $permission->delete(); // Delete the permission
            }
        }

        return redirect()->route('admin.permissions.index')->with('success', 'Selected permissions have been deleted.');
    }
}
