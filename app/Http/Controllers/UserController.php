<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Http\Controllers\Redirect;
use App\Models\User;
use App\Models\Employeleave;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        Session::put('role', ''); 
        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
       $validator =  $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            Session::put('role', 'user');
            return redirect()->intended('dashboard')
                        ->withSuccess('Signed in');
        }
        $validator['emailPassword'] = 'Email address or password is incorrect.';
        return redirect("user/login")->withErrors($validator);
    }



    public function registration()
    {
        return view('auth.registration');
    }

    public function customRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("dashboard")->withSuccess('You have signed-in');
    }


    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }

    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function applyLeave()
    {
       return view('user.employeeLeave');
    }
    public function leave(Request $request)
    {  
        $request->validate([
            'title' => 'required',
            'date' => 'required',
            'reason' => 'required',
        ]);
           
        $data = $request->all();
        $data['user_id']= Auth::id();
        $leave = Employeleave::create($data);
        redirect()->back()->with('leavemessage',"Leave Apply Successfully");
       }

    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('user/login');
    }
}
