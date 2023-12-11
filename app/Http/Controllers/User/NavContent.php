<?php

namespace App\Http\Controllers\User;

use App\Models\NavHeading;
use Illuminate\Http\Request;
use App\Models\NavSubHeading;
use App\Http\Controllers\Controller;

class NavContent extends Controller
{
    public function index(Request $request)
    {
        $selectedValue = $request->query('perPage', session('pagination_nav_heading', 10));

        $nav_headings = NavHeading::paginate($selectedValue);

        if ($request->ajax()) {
            // If it's an AJAX request, return the updated pagination data as a rendered view
            return view('vendor.pagination.custom', ['nav_headings' => $nav_headings])->render();
        }

        // Store the selected value in the session
        session(['pagination_nav_heading' => $selectedValue]);

        return view('admin.nav_content.index', compact('nav_headings', 'selectedValue'));
    }


    public function create()
    {

        return view('admin.nav_content.create');
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string',
            'sub_name' => 'required|string',
        ]);

        // Separate sub_name into an array using a delimiter (e.g., comma)
        $subNamesArray = explode(',', $request->input('sub_name'));
        $navHeading = NavHeading::create([
            'name' => $request->input('name'),
        ]);
        // Assuming you have a NavSubHeading model, create and store the records
        foreach ($subNamesArray as $subName) {
            NavSubHeading::create([
                'nav_headings_id' => $navHeading->id, // Set the appropriate nav_headings_id
                'name' => trim($subName), // Trim to remove any leading/trailing spaces
            ]);
        }

        // Redirect or do something else after storing the data

        // For example, redirect back with a success message
        return redirect()->route('admin.nav_contents.index')->with('message', 'Headings created successfully');
    }
    // public function edit(Permission $permission){

    //     return view('admin.permission.edit',compact('permission'));
    // }
    // public function update(Request $request,Permission $permission){
    //     // dd($request);
    //     $validated=$request->validate([
    //         'name'=>"required|max:255|unique:permissions,name,{$permission->id}",
    //         'group_name'=>'required'
    //         ]);
    //     $permission->update($validated);

    //     return redirect()->route('admin.permissions.index')->with('message','Permission Updated successfully');
    // }
    // public function destroy(Permission $permission){
    //     $permission->delete();
    //     return redirect()->route('admin.permissions.index')->with('error','Permission Deleted successfully');
    // }
    // public function show(Permission $permission){

    //     return view('admin.permission.show',compact('permission'));
    // }
}
