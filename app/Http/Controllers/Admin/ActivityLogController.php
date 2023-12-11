<?php

namespace App\Http\Controllers\Admin;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivityLogController extends Controller
{
    public function index(Request $request,$type)
    {
        $selectedValue = $request->query('perPage', session('pagination_user', 10));
        $logs=ActivityLog::where('activity_type',$type)->paginate($selectedValue);
        return view('admin.activity_log.index',compact('logs','type','selectedValue'));
    }

    public function search(Request $request,$type){
        $search=$request->input('search');
        $selectedValue = $request->query('perPage', session('pagination_permission', 10));
        $logs = ActivityLog::where('activity_type',$type)->paginate($selectedValue);
         // Reset the pagination page when performing a search
        $page = $request->input('page', 1);
            if ($request->ajax()) {
            // If it's an AJAX request, return the updated pagination data as a rendered view
            return view('vendor.pagination.custom', ['logs' => $logs])->render();
        }
        // Store the selected value in the session
        session(['pagination_permission' => $selectedValue]);
        // $logs = ActivityLog::where('activity_type',$type)->select()
        //                 ->where('request_type', 'LIKE', "%{$search}%")
        //                 ->orWhere('description', 'LIKE', "%{$search}%")
        //                 ->paginate($selectedValue);
        $logs = ActivityLog::select()
        ->where(function($query) use ($type, $search) {
            $query->where('activity_type', $type)
                  ->where(function($query) use ($search) {
                     $query->where('request_type', 'LIKE', "%{$search}%")
                           ->orWhere('description', 'LIKE', "%{$search}%");
                  });
        })
        ->paginate($selectedValue);

        return view ('admin.activity_log.index',compact('logs','selectedValue','type'));
    }
}
