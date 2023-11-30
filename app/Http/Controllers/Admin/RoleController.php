<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Exports\RoleExport;
use App\Imports\RoleImport;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use PDF;


class RoleController extends Controller
{
    public function index(Request $request){
       
        $permissions=Permission::all();
        $selectedValue = $request->query('perPage', session('pagination_role', 10));
    
        $roles = Role::paginate($selectedValue);
    
        if ($request->ajax()) {
            // If it's an AJAX request, return the updated pagination data as a rendered view
            return view('vendor.pagination.custom', ['roles' => $roles])->render();
        }
    
        // Store the selected value in the session
        session(['pagination_role' => $selectedValue]);
        
        return view('admin.role.index',compact('roles','permissions','selectedValue'));
    }
    public function create(){
        $permissions=Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('admin.role.create',compact('permissions','permission_groups'));
    }
    public function store(Request $request){
        
        $validated=$request->validate(['name'=>['required','min:3','unique:roles']]);
        Role::create($validated);
        $role=Role::where('name',$validated['name'])->first();
        $permissions=$request['permission'];
        $role->syncPermissions($permissions);
        
        return redirect()->route('admin.roles.index')->with('message','Role Created successfully');
    }
    public function edit(Role $role){
        $permissions=Permission::all();
        $permission_groups = User::getpermissionGroups();
        return view('admin.role.edit',compact('role','permissions','permission_groups'));
    }
    public function update(Request $request,Role $role){
        $permissions=$request['permission'];
        $role->syncPermissions($permissions);
        $validated=$request->validate(['name'=>['required','min:3']]);
        $role->update($validated);
       
        
        return redirect()->route('admin.roles.index')->with('message','Role Updated successfully');
    }
    public function destroy(Role $role){
        $role->delete();
        return redirect()->route('admin.roles.index')->with('error','Role Deleted successfully');
    }
    public function show(Role $role){
       
        return view('admin.role.show',compact('role'));
    } 
    // import csv
    public function import(){
        //    dd('hello');
            return view('admin.role.import');
        }
    public function importRole(Request $request){
        
        Excel::import(new RoleImport, $request->file('import_file'));
        return redirect()->route('admin.roles.index')->with('message','Role Imported successfully');
    }
    //    export pdf
        public function exportpdf(Request $request){
            $selectedRowValues = $request->input('selectedRows');
            
            // Convert the comma-separated string into an array
            $selectedRows = explode(',', $selectedRowValues);
           
            if($selectedRowValues==null){
                $roles =Role::get();
                $permissions=Permission::all();
               $data=[
                'title' => 'Roles',
                'date' => date('d/m/Y'),
                'roles' =>$roles,
                'permissions'=>$permissions,
               ];
              
               $pdf = PDF::loadView('admin.role.export-pdf', $data)->setPaper('A4');
              
               return $pdf->stream('Roles.pdf');
            }
            $roles=Role::whereIn('id',$selectedRows)->get();
            $permissions=Permission::all();
            $data=[
                'title' => 'Roles',
                'date' => date('d/m/Y'),
                'roles' =>$roles,
                'permissions'=>$permissions,
               ];
              
               $pdf = PDF::loadView('admin.role.export-pdf', $data)->setPaper('A4');
              
               return $pdf->stream('Roles.pdf');
            
        //    return $pdf->download('roles.pdf');
            
           
        }
        // export csv
        public function exportselectedcsv(Request $request)
        {
            $selectedRowValues = $request->input('selectedRows');
            
            // Convert the comma-separated string into an array
            $selectedRows = explode(',', $selectedRowValues);
            return (new RoleExport($selectedRows))->download('roles.csv') ;
          
        
        }
        public function search(Request $request){
            $search=$request->input('search');
            $selectedValue = $request->query('perPage', session('pagination_role', 10));
            $roles = Role::select()
                            ->where('name', 'LIKE', "%{$search}%")
                            ->paginate($selectedValue);
            

          
        
            if ($request->ajax()) {
                // If it's an AJAX request, return the updated pagination data as a rendered view
                return view('vendor.pagination.custom', ['roles' => $roles])->render();
            }
        
            // Store the selected value in the session
            session(['pagination_role' => $selectedValue]);
            return view ('admin.role.index',compact('roles','selectedValue'));
    
        }
        public function deleteSelected(Request $request)
        {
            $selectedRoles = $request->input('selectedRows'); // Get the selected rows
            $selectedRows = explode(',', $selectedRoles);
            foreach ($selectedRows as $roleId) {
                $role = Role::find($roleId);
                
                if ($role) {
                    // dd($role);
                    $role->delete(); // Delete the role
                }
            }

            return redirect()->route('admin.roles.index')->with('success', 'Selected roles have been deleted.');
        }

}
