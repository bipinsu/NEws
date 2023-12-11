<?php

namespace App\Http\Controllers\Admin;

use App\Models\Logo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LogoController extends Controller
{
    // public function create()
    // {
    //     return view('admin.logos.create');
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image file
    //     ]);

    //     $imageName = $request->file('image')->getClientOriginalName();
    //     $imagePath = $request->file('image')->storeAs('public/logos', $imageName);
    //     $imagePath = str_replace('public/', '', $imagePath);

    //     Logo::create([

    //         'path' => $imagePath,
    //     ]);

    //     return redirect()->route('admin.logos.index')->with('success', 'Logo created successfully.');
    // }

    public function edit(Logo $logo)
    {
        return view('admin.logos.edit', compact('logo'));
    }

    public function update(Request $request, Logo $logo)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image file
        ]);

        if ($request->hasFile('image')) {
            unlink(public_path($logo->path));
            $imageName = $request->file('image')->getClientOriginalName();
            $imagePath = $request->file('image')->storeAs('public/logos', $imageName);
            $imagePath = str_replace('public/', 'storage/', $imagePath);
        } else {
            $imagePath = $logo->path;
        }

        $logo->update([
            'path' => $imagePath,
        ]);

        return view('admin.dashboard.dashboard')->with('message', 'Logo updated successfully.');
    }

    // public function destroy(Logo $logo)
    // {
    //     Storage::delete('public/' . $logo->path);
    //     $logo->delete();
    //     return redirect()->route('admin.logos.index')->with('success', 'Logo deleted successfully.');
    // }
}
