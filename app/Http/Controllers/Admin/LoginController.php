<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // display login page
    public function login(){
        return view('login.login');
       }
    //    login in user 
       public function loginPost(Request $request){
        // dd($request);
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        // Attempt to log in the user
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            // Authentication successful
            return redirect()->intended('/admin/dashboard'); // Redirect to the dashboard or any desired location
        } else {
            // Authentication failed
            return redirect()->back()->withErrors(['loginError' => 'Invalid email or password'])
                ->withInput();
        }
       }
    //    logout user
       public function logout()
       {
           Auth::logout(); // Log the user out
   
           return redirect('/'); // Redirect to your desired logout page or home page
       }
}
