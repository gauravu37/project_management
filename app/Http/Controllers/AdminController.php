<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Employeleave;
class AdminController extends Controller
{
   public function index()
    {
        Session::put('role', ''); 
        return view('admin.login');
    }

    public function customLogin(Request $request)
    {
       $validator =  $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
     $credentials = $request->only('email', 'password');
        $user = Admin::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            $validator['emailPassword'] = 'Email address or password is incorrect.';
        return redirect("admin")->withErrors($validator);
        }else{
            Session::put('role', 'admin');
            return redirect("dashboard")
            ->withSuccess('Signed in');
        }
           
        
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function users()
    {
        $user = User::all();
        return view('user',compact('user'));
    }
    public function requestLeave()
    {
        $user = Employeleave::where('status','0');
        return view('requestLeave',compact('user'));
    }

    public function signOut() {
        Session::flush();
        return Redirect('login');
    }
}
