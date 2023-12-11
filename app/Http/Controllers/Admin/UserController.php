<?php

namespace App\Http\Controllers\Admin;


use PDF;
use App\Models\User;
use App\Exports\UserExport;
use App\Imports\UserImport;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {

        $selectedValue = $request->query('perPage', session('pagination_user', 10));

        $users = User::paginate($selectedValue);

        if ($request->ajax()) {
            // If it's an AJAX request, return the updated pagination data as a rendered view
            return view('vendor.pagination.custom', ['users' => $users])->render();
        }
        //Activity Log


        // Store the selected value in the session
        session(['pagination_user' => $selectedValue]);
        return view('admin.user.index', compact('users', 'selectedValue'));
    }
    public function create()
    {
        $roles = Role::all();
        return view('admin.user.create', compact('roles'));
    }
    public function store(Request $request)
    {
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
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $selectedRolesArray = request('selectedRoles')[0];
        $selectedRoles = json_decode($selectedRolesArray, true);
        $user->syncRoles($selectedRoles);
        // Activity Logs
        $ipAddress = request()->getClientIp();
        $location = geoip($ipAddress);

        $locationData = [
            'ip' => $location->ip,
            'iso_code' => $location->iso_code,
            'country' => $location->country,
            'city' => $location->city,
            'state' => $location->state,
            'state_name' => $location->state_name,
            'postal_code' => $location->postal_code,
            'lat' => $location->lat,
            'lon' => $location->lon,
            'timezone' => $location->timezone,
            'continent' => $location->continent,
            'currency' => $location->currency,
            'default' => $location->default,
            'cached' => $location->cached,
        ];
        $locationJson = json_encode($locationData);
        $changed = json_encode($user->id);
        $activity_log = new ActivityLog;
        $activity_log->user_name = auth()->user()->name;
        $activity_log->user_id = auth()->user()->id;
        $activity_log->email = auth()->user()->email;
        $activity_log->changed_id = $changed;
        $activity_log->ip_address =  $ipAddress;
        $activity_log->url = request()->url();
        $activity_log->request_type = request()->method();
        $activity_log->description = "Created the User";
        $activity_log->activity_type = "user";
        $activity_log->data = request()->all();
        $activity_log->geo_location = $locationJson;
        $activity_log->save();

        return redirect()->route('admin.users.index')->with('message', 'User Created successfully');
    }
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.user.edit', compact('roles', 'user'));
    }
    public function update(Request $request, User $user)
    {
        $selectedRolesArray = request('selectedRoles')[0];
        $selectedRoles = json_decode($selectedRolesArray, true);
        $user->syncRoles($selectedRoles);
        $validator = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|max:255|unique:users,email,{$user->id}",
            'password' => 'nullable',
        ]);
        if (empty($validator['password'])) {
            $validator['password'] = $user->password;
        } else {
            $validator['password'] = Hash::make($request->input('password'));
        }
        $user->update($validator);
        // Activity Logs
        $ipAddress = request()->getClientIp();
        $location = geoip($ipAddress);

        $locationData = [
            'ip' => $location->ip,
            'iso_code' => $location->iso_code,
            'country' => $location->country,
            'city' => $location->city,
            'state' => $location->state,
            'state_name' => $location->state_name,
            'postal_code' => $location->postal_code,
            'lat' => $location->lat,
            'lon' => $location->lon,
            'timezone' => $location->timezone,
            'continent' => $location->continent,
            'currency' => $location->currency,
            'default' => $location->default,
            'cached' => $location->cached,
        ];
        $locationJson = json_encode($locationData);
        $changed = json_encode($user->id);

        $activity_log = new ActivityLog;
        $activity_log->user_name = auth()->user()->name;
        $activity_log->user_id = auth()->user()->id;
        $activity_log->email = auth()->user()->email;
        $activity_log->changed_id = $changed;
        $activity_log->ip_address =  $ipAddress;
        $activity_log->url = request()->url();
        $activity_log->request_type = request()->method();
        $activity_log->description = "Edited the User";
        $activity_log->activity_type = "user";
        $activity_log->data = request()->all();
        $activity_log->geo_location = $locationJson;
        $activity_log->save();

        return redirect()->route('admin.users.index')->with('message', 'User Updated successfully');
    }
    public function destroy(User $user)
    {
        if ($user->hasRole('admin')) {
            return back()->with('warning', 'You are admin');
        }
        $user->delete();
        // Activity Logs
        $ipAddress = request()->getClientIp();
        $location = geoip($ipAddress);

        $locationData = [
            'ip' => $location->ip,
            'iso_code' => $location->iso_code,
            'country' => $location->country,
            'city' => $location->city,
            'state' => $location->state,
            'state_name' => $location->state_name,
            'postal_code' => $location->postal_code,
            'lat' => $location->lat,
            'lon' => $location->lon,
            'timezone' => $location->timezone,
            'continent' => $location->continent,
            'currency' => $location->currency,
            'default' => $location->default,
            'cached' => $location->cached,
        ];
        $locationJson = json_encode($locationData);
        $changed = json_encode($user->id);
        $activity_log = new ActivityLog;
        $activity_log->user_name = auth()->user()->name;
        $activity_log->user_id = auth()->user()->id;
        $activity_log->email = auth()->user()->email;
        $activity_log->changed_id = $changed;
        $activity_log->ip_address =  $ipAddress;
        $activity_log->url = request()->url();
        $activity_log->request_type = request()->method();
        $activity_log->description = "Deleted the User";
        $activity_log->activity_type = "user";
        $activity_log->data = null;
        $activity_log->geo_location = $locationJson;
        $activity_log->save();
        return redirect()->route('admin.users.index')->with('error', 'User Deleted successfully');
    }
    public function restore($id)
    {
        User::where('id', $id)->withTrashed()->restore();
        return redirect()->route('users.index', ['status' => 'archived'])
            ->withSuccess(__('User restored successfully.'));
    }

    public function forceDelete($id)
    {
        User::where('id', $id)->withTrashed()->forceDelete();
        return redirect()->route('users.index', ['status' => 'archived'])
            ->withSuccess(__('User force deleted successfully.'));
    }

    public function restoreAll()
    {
        User::onlyTrashed()->restore();
        return redirect()->route('users.index')->withSuccess(__('All users restored successfully.'));
    }
    public function show(User $user)
    {
        $permissions = Permission::all();
        $roles = Role::all();
        // Activity Logs
        $ipAddress = request()->getClientIp();
        $location = geoip($ipAddress);

        $locationData = [
            'ip' => $location->ip,
            'iso_code' => $location->iso_code,
            'country' => $location->country,
            'city' => $location->city,
            'state' => $location->state,
            'state_name' => $location->state_name,
            'postal_code' => $location->postal_code,
            'lat' => $location->lat,
            'lon' => $location->lon,
            'timezone' => $location->timezone,
            'continent' => $location->continent,
            'currency' => $location->currency,
            'default' => $location->default,
            'cached' => $location->cached,
        ];
        $locationJson = json_encode($locationData);
        $changed = json_encode($user->id);
        $activity_log = new ActivityLog;
        $activity_log->user_name = auth()->user()->name;
        $activity_log->user_id = auth()->user()->id;
        $activity_log->email = auth()->user()->email;
        $activity_log->changed_id = $changed;
        $activity_log->ip_address =  $ipAddress;
        $activity_log->url = request()->url();
        $activity_log->request_type = request()->method();
        $activity_log->description = "Viewed the User";
        $activity_log->activity_type = "user";
        $activity_log->data = null;
        $activity_log->geo_location = $locationJson;
        $activity_log->save();
        return view('admin.user.show', compact('user', 'roles', 'permissions'));
    }
    public function import()
    {
        //    dd('hello');
        return view('admin.user.import');
    }
    public function importPermission(Request $request)
    {
        Excel::import(new UserImport, $request->file('import_file'));
        return redirect()->route('admin.users.index')->with('message', 'User Imported successfully');
    }

    //    export pdf
    public function exportpdf(Request $request)
    {
        $selectedRowValues = $request->input('selectedRows');

        // Convert the comma-separated string into an array
        $selectedRows = explode(',', $selectedRowValues);



        if ($selectedRowValues == null) {
            return redirect()->back()->with('error', 'Please select atleast a raw to export');
        }
        // Activity Logs
        $ipAddress = request()->getClientIp();
        $location = geoip($ipAddress);

        $locationData = [
            'ip' => $location->ip,
            'iso_code' => $location->iso_code,
            'country' => $location->country,
            'city' => $location->city,
            'state' => $location->state,
            'state_name' => $location->state_name,
            'postal_code' => $location->postal_code,
            'lat' => $location->lat,
            'lon' => $location->lon,
            'timezone' => $location->timezone,
            'continent' => $location->continent,
            'currency' => $location->currency,
            'default' => $location->default,
            'cached' => $location->cached,
        ];
        $locationJson = json_encode($locationData);
        $changed = json_encode($selectedRows);

        $activity_log = new ActivityLog;
        $activity_log->user_name = auth()->user()->name;
        $activity_log->user_id = auth()->user()->id;
        $activity_log->email = auth()->user()->email;
        $activity_log->changed_id = $changed;
        $activity_log->ip_address =  $ipAddress;
        $activity_log->url = request()->url();
        $activity_log->request_type = request()->method();
        $activity_log->description = "Exported the above users record in pdf";
        $activity_log->activity_type = "user";
        $activity_log->data = null;
        $activity_log->geo_location = $locationJson;
        $activity_log->save();

        $users = User::whereIn('id', $selectedRows)->get();
        $data = [
            'title' => 'Users',
            'date' => date('d/m/Y'),
            'users' => $users,
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
        if ($selectedRowValues == null) {
            return redirect()->back()->with('error', 'Please select atleast a raw to export');
        }
        // Activity Logs
        $ipAddress = request()->getClientIp();
        $location = geoip($ipAddress);

        $locationData = [
            'ip' => $location->ip,
            'iso_code' => $location->iso_code,
            'country' => $location->country,
            'city' => $location->city,
            'state' => $location->state,
            'state_name' => $location->state_name,
            'postal_code' => $location->postal_code,
            'lat' => $location->lat,
            'lon' => $location->lon,
            'timezone' => $location->timezone,
            'continent' => $location->continent,
            'currency' => $location->currency,
            'default' => $location->default,
            'cached' => $location->cached,
        ];
        $locationJson = json_encode($locationData);
        $changed = json_encode($selectedRows);
        $activity_log = new ActivityLog;
        $activity_log->user_name = auth()->user()->name;
        $activity_log->user_id = auth()->user()->id;
        $activity_log->email = auth()->user()->email;
        $activity_log->changed_id = $changed;
        $activity_log->ip_address =  $ipAddress;
        $activity_log->url = request()->url();
        $activity_log->request_type = request()->method();
        $activity_log->description = "Exported the above users record in csv";
        $activity_log->activity_type = "user";
        $activity_log->data = null;
        $activity_log->geo_location = $locationJson;
        $activity_log->save();
        return (new UserExport($selectedRows))->download('Users.csv');
    }
    public function search(Request $request)
    {
        $selectedValue = $request->query('perPage', session('pagination_user', 10));
        $search = $request->input('search');
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
        return view('admin.user.index', compact('users', 'selectedValue'));
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
        // Activity Logs
        $ipAddress = request()->getClientIp();
        $location = geoip($ipAddress);

        $locationData = [
            'ip' => $location->ip,
            'iso_code' => $location->iso_code,
            'country' => $location->country,
            'city' => $location->city,
            'state' => $location->state,
            'state_name' => $location->state_name,
            'postal_code' => $location->postal_code,
            'lat' => $location->lat,
            'lon' => $location->lon,
            'timezone' => $location->timezone,
            'continent' => $location->continent,
            'currency' => $location->currency,
            'default' => $location->default,
            'cached' => $location->cached,
        ];
        $locationJson = json_encode($locationData);
        $changed = json_encode($selectedRows);

        $activity_log = new ActivityLog;
        $activity_log->user_name = auth()->user()->name;
        $activity_log->user_id = auth()->user()->id;
        $activity_log->email = auth()->user()->email;
        $activity_log->changed_id = $changed;
        $activity_log->ip_address =  $ipAddress;
        $activity_log->url = request()->url();
        $activity_log->request_type = request()->method();
        $activity_log->description = "Deleted the above users";
        $activity_log->activity_type = "user";
        $activity_log->data = null;
        $activity_log->geo_location = $locationJson;
        $activity_log->save();

        return redirect()->route('admin.users.index')->with('message', 'Selected users have been deleted.');
    }

    // Profile
    public function profile(Request $request){
        return view('admin.user.profile');
    }
    public function profileUpdate(Request $request){
        $this->validate($request,[
            'password'=>['required','min:8'],
        ]);
        if(!Hash::check($request->old_password,auth()->user()->password)){
            return back()->with('error',"Old password is incorrect");
        }else{
            User::whereId(Auth::User()->id)->update([
                'password'=>bcrypt($request->password),
                ]);
            return redirect()->route('admin.users.index')->with('message',"Password updated successfully");
        }

    }
    public function getUsersByRole(Request $request)
    {
       $role = $request->input('role_name');
       // Retrieve users with the selected role
       $users= User::whereHas('roles', function ($query) use ($role) {
           $query->where('name', $role);
       })->get();
       return response()->json($users);
    }


}
