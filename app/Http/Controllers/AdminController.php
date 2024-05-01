<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Employeleave;
use App\Models\employee_attendence_time;
use App\Models\project_management;

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
            Session::put('role', $user->role);
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
        return view('admin.employee',compact('user'));
    }
    public function requestLeave()
    {
        $user = Employeleave::where('status','0')->latest()->get();
        return view('admin.requestLeave',compact('user'));
    }

     public function approvedLeave()
    {
        $user = Employeleave::where('status','1')->latest()->get();
        return view('admin.approvedLeave',compact('user'));
    }

    public function rejectleaveview()
    {
        $user = Employeleave::where('status','2')->latest()->get();
        return view('admin.rejectleaveview',compact('user'));
    }


    public function accept_leave($id)
    {
        $user = Employeleave::find($id);
        $user->status = '1';
        $user->update();
        return redirect()->back()->with('status','Leave Approved Successfully');

    }

    public function rejectleave(Request $request)
    {
        $id = $request->id;
        $user = Employeleave::find($id);
        $user->feedback = $request->rejectreason;
        $user->status = '2';
        $user->update();
        return redirect()->back()->with('status','Revert send Successfully');

    }


    public function employee_time()
    {
        $today = now()->toDateString();
        $employee_time = employee_attendence_time::whereDate('created_at', $today)->get();
        return view('admin.employee_time',compact('employee_time'));
    }

    public function project_management()
    {
      
        $project_management = project_management::all();
        return view('admin.project_management',compact('project_management'));
    }

    public function delete_project($id){
        $delete = project_management::find($id);
        $delete->delete();
        return redirect()->back()->with('success','Delete Project Successfully');
    }

    public function add_project()
    {
        return view('admin.add_project');
    }

    public function addproject(Request $request)
    {
        $validatedData = $request->validate([
            'project_name' => 'required',
            'client_name' => 'required',
            'total_hours' => 'required',
            'payment' => 'required',
            
        ]);

        $add_project = new project_management();
        $add_project->project_name = $request->project_name;
        $add_project->client_name = $request->client_name;
        $add_project->total_hours = $request->total_hours;
        $add_project->payment = $request->payment;
        if($add_project->save()){
            return redirect("project-management")->with('success','Add Project Successfully');
        }

    }

    public function edit_project($id){
        $editproject = project_management::find($id);
        return view('admin.edit_project',compact('editproject'));
    }

    public function updateproject(Request $request)
    {
        $validatedData = $request->validate([
            'project_name' => 'required',
            'client_name' => 'required',
            'total_hours' => 'required',
            'payment' => 'required',
            
        ]);
        $id = $request->id;
        $update = project_management::find($id);
        $update->project_name = $request->project_name;
        $update->client_name = $request->client_name;
        $update->total_hours = $request->total_hours;
        $update->payment = $request->payment;
        if($update->save()){
            return redirect("project-management")->with('success','Update Project Successfully');
        }

    }


    public function add_employee()
    {
        return view('admin.add_employee');
    }

    public function add_employee_detail(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'image' => 'required',
            
        ]);
       
        $imageName="";
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('user_profile'), $imageName);
          }
        $add_employee = new User();
        $add_employee->name = $request->name;
        $add_employee->email = $request->email;
        $add_employee->phone = $request->phone;
        $add_employee->image = $imageName;
        $add_employee->password = Hash::make($request->password);
        if($add_employee->save()){
            return redirect("employees")->with('success','Add Project Successfully');
        }

    }

    public function delete_employee($id){
        $delete = User::find($id);
        $delete->delete();
        return redirect()->back()->with('success','Delete Employee Successfully');
    }

    public function edit_employee($id){
        $employe = User::find($id);
        return view('admin.edit_employee',compact('employe'));
     }

     public function update_employee(Request $request)
     {
         $request->validate([
             'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // adjust max size as neede
         ]);
 
         if ($request->hasFile('image')) {
             $image = $request->file('image');
             $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
             $image->move(public_path('user_profile'), $imageName);
           }
           if ($request->hasFile('image')) {
            $add_employee = User::find($request->id);
            $add_employee->name = $request->name;
            $add_employee->email = $request->email;
            $add_employee->phone = $request->phone;
            $add_employee->image = $imageName;
            $add_employee->update();
           }else{
            $add_employee = User::find($request->id);
            $add_employee->name = $request->name;
            $add_employee->email = $request->email;
            $add_employee->phone = $request->phone;
             $add_employee->update();
           }
           return redirect("employees")->with('success','Update Employee Successfully');
      
     }


    public function signOut() {
        Session::flush();
        return Redirect('admin');
    }
}
