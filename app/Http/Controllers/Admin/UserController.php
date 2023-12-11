<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Exports\UserExport;
use App\Imports\UserImport;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use PDF;

class UserController extends Controller
{
    public function index(Request $request){

        $selectedValue = $request->query('perPage', session('pagination_user', 10));

        $users = User::paginate($selectedValue);

        if ($request->ajax()) {
            // If it's an AJAX request, return the updated pagination data as a rendered view
            return view('vendor.pagination.custom', ['users' => $users])->render();
        }

        // Store the selected value in the session
        session(['pagination_user' => $selectedValue]);
        return view('admin.user.index',compact('users','selectedValue'));
    }
    public function create(){
        $roles=Role::all();
        return view('admin.user.create',compact('roles'));
    }
    public function store(Request $request){
        // dd($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create a new user
        $user=User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $selectedRolesArray = request('selectedRoles')[0];
        $selectedRoles = json_decode($selectedRolesArray, true);
        $user->syncRoles($selectedRoles);


        return redirect()->route('admin.users.index')->with('message','User Created successfully');
    }
    public function edit(User $user){
        $roles=Role::all();
        return view('admin.user.edit',compact('roles','user'));
    }
    public function update(Request $request,User $user){
        $selectedRolesArray = request('selectedRoles')[0];
        $selectedRoles = json_decode($selectedRolesArray, true);
        $user->syncRoles($selectedRoles);
        $validator = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|max:255|unique:users,email,{$user->id}",
            'password' => 'nullable',
        ]);
        if (empty($validator['password'])) {
            $validator['password']=$user->password;
        }
        else{
            $validator['password']=Hash::make($request->input('password'));
        }
        $user->update($validator);


        return redirect()->route('admin.users.index')->with('message','User Updated successfully');
    }
    public function destroy(User $user){
        if($user->hasRole('admin')){
            return back()->with('warning','You are admin');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('error','User Deleted successfully');
    }
    public function show(User $user){
        $permissions= Permission::all();
        $roles = Role::all();
        return view('admin.user.show',compact('user','roles','permissions'));
    }
    public function import(){
        //    dd('hello');
            return view('admin.user.import');
        }
        public function importPermission(Request $request){
            Excel::import(new UserImport, $request->file('import_file'));
            return redirect()->route('admin.users.index')->with('message','User Imported successfully');
        }

          //    export pdf
     public function exportpdf(Request $request){
        $selectedRowValues = $request->input('selectedRows');

        // Convert the comma-separated string into an array
        $selectedRows = explode(',', $selectedRowValues);

        if($selectedRowValues==null){

            $users=User::all();
           $data=[
            'title' => 'Users',
            'date' => date('d/m/Y'),

            'users'=>$users,
           ];

           $pdf = PDF::loadView('admin.user.export-pdf', $data)->setPaper('A4');

           return $pdf->stream('Users.pdf');
        }

        $users=User::whereIn('id',$selectedRows)->get();
        $data=[
            'title' => 'Users',
            'date' => date('d/m/Y'),
            'users'=>$users,
           ];

           $pdf = PDF::loadView('admin.user.export-pdf', $data)->setPaper('A4');

           return $pdf->stream('Users.pdf');




    }
    // export csv
    public function exportselectedcsv(Request $request)
    {
        $selectedRowValues = $request->input('selectedRows');

        // Convert the comma-separated string into an array
        $selectedRows = explode(',', $selectedRowValues);
        return (new UserExport($selectedRows))->download('Users.csv') ;


    }
    public function search(Request $request){
        $selectedValue = $request->query('perPage', session('pagination_user', 10));
        $search=$request->input('search');
        $users = User::select()
                        ->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%")
                        ->paginate($selectedValue);
        if ($request->ajax()) {
            // If it's an AJAX request, return the updated pagination data as a rendered view
            return view('vendor.pagination.custom', ['users' => $users])->render();
        }

        // Store the selected value in the session
        session(['pagination_permission' => $selectedValue]);
        return view ('admin.user.index',compact('users','selectedValue'));

    }

    public function deleteSelected(Request $request)
    {
        $selectedusers = $request->input('selectedRows'); // Get the selected rows
        $selectedRows = explode(',', $selectedusers);
        foreach ($selectedRows as $userId) {
            $user = User::find($userId);

            if ($user) {
                // dd($user);
                $user->delete(); // Delete the user
            }
        }

        return redirect()->route('admin.users.index')->with('success', 'Selected users have been deleted.');
    }
}
