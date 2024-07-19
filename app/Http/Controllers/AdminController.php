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
use App\Models\client_management;
use App\Models\task_management;
use App\Models\designation;

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

        ///new ///
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
        if (Session::get('role') =='') {
            // Session variable does not exist, redirect to login route
            return redirect()->route('admin');
        }
        return view('dashboard');
    }

    public function users()
    {
        if (Session::get('role') =='') {
            // Session variable does not exist, redirect to login route
            return redirect()->route('admin');
        }
        $user = User::all();
        return view('admin.employee',compact('user'));
    }
    public function requestLeave()
    {
        if (Session::get('role') =='') {
            // Session variable does not exist, redirect to login route
            return redirect()->route('admin');
        }
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
        if (Session::get('role') =='') {
            // Session variable does not exist, redirect to login route
            return redirect()->route('admin');
        }
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
        if (Session::get('role') =='') {
            // Session variable does not exist, redirect to login route
            return redirect()->route('admin');
        }
        $today = now()->toDateString();
        $employee_time = employee_attendence_time::whereDate('created_at', $today)->get();
        return view('admin.employee_time',compact('employee_time'));
    }

    public function project_management()
    {
        if (Session::get('role') =='') {
            // Session variable does not exist, redirect to login route
            return redirect()->route('admin');
        }
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
        if (Session::get('role') =='') {
        // Session variable does not exist, redirect to login route
        return redirect()->route('admin');
    }
        $client = client_management::all();
        $user = User::all();
        return view('admin.add_project',compact('client','user'));
    }

    public function addproject(Request $request)
    {
       
        $validatedData = $request->validate([
            'project_name' => 'required',
            'client_name' => 'required',
            'assign' => 'required',
            'total_hours' => 'required',
            'payment' => 'required',
            'deadline' => 'required'
            
        ]);
        $assign = $request->input('assign');
        $assigns = implode(',', $assign);


        $add_project = new project_management();
        $add_project->project_name = $request->project_name;
        $add_project->client_name = $request->client_name;
        $add_project->total_hours = $request->total_hours;
        $add_project->assign = $assigns;
        $add_project->payment = $request->payment;
        $add_project->deadline = $request->deadline;
        if($add_project->save()){
            return redirect("project-management")->with('success','Add Project Successfully');
        }

    }

    public function edit_project($id){
        if (Session::get('role') =='') {
            // Session variable does not exist, redirect to login route
            return redirect()->route('admin');
        }
        $editproject = project_management::find($id);
        $client = client_management::all();
        $user = User::all();
        return view('admin.edit_project',compact('editproject','client','user'));
    }

    public function updateproject(Request $request)
    {
        $validatedData = $request->validate([
            'project_name' => 'required',
            'client_name' => 'required',
            'assign' => 'required',
            'total_hours' => 'required',
            'payment' => 'required',
             'deadline' => 'required'
            
        ]);
        $id = $request->id;
        $update = project_management::find($id);
        $update->project_name = $request->project_name;
        $update->client_name = $request->client_name;
        $update->assign = $request->assign;
        $update->total_hours = $request->total_hours;
        $update->payment = $request->payment;        
        $update->deadline = $request->deadline;

        if($update->save()){
            return redirect("project-management")->with('success','Update Project Successfully');
        }

    }

    public function view_project($id){
        if (Session::get('role') =='') {
            // Session variable does not exist, redirect to login route
            return redirect()->route('admin');
        }
        $view_project = project_management::find($id);
        $client = client_management::all();
        $user = User::all();
        $task = task_management::where('project_id',$id)->get();
        return view('admin.view_project',compact('view_project','client','user','task'));
    }



    public function add_employee()
    {
        if (Session::get('role') =='') {
            // Session variable does not exist, redirect to login route
            return redirect()->route('admin');
        }
        $designation = designation::all();
        return view('admin.add_employee',compact('designation'));
    }

    public function add_employee_detail(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
           
            
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
        $add_employee->designation = $request->designation;
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
        if (Session::get('role') =='') {
            // Session variable does not exist, redirect to login route
            return redirect()->route('admin');
        }
        $employe = User::find($id);
        $designation = designation::all();
        return view('admin.edit_employee',compact('employe','designation'));
     }

     public function update_employee(Request $request)
     {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
           
            
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
            $add_employee->designation = $request->designation;
            $add_employee->image = $imageName;
            $add_employee->update();
           }else{
            $add_employee = User::find($request->id);
            $add_employee->name = $request->name;
            $add_employee->email = $request->email;
            $add_employee->phone = $request->phone;
            $add_employee->designation = $request->designation;
             $add_employee->update();
           }
           return redirect("employees")->with('success','Update Employee Successfully');
      
     }


     public function client_management()
    {
        if (Session::get('role') =='') {
            // Session variable does not exist, redirect to login route
            return redirect()->route('admin');
        }
        $client_management = client_management::all();
        return view('admin.client_management',compact('client_management'));
    }

    public function add_client()
    {
        if (Session::get('role') =='') {
            // Session variable does not exist, redirect to login route
            return redirect()->route('admin');
        }
        return view('admin.add_client');
    }
    

    public function add_client_detail(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
         ]);
      
        $add_client = new client_management();
        $add_client->name = $request->name;
        $add_client->email = $request->email;
        $add_client->contact = $request->contact;
        $add_client->facebook_id = $request->facebook_id;
        $add_client->instagram_id = $request->instagram_id;
        $add_client->skype_id = $request->skype_id;
        $add_client->telegram_id = $request->telegram_id;
        $add_client->whatsapp = $request->whatsapp;
        $add_client->upwork_id = $request->upwork_id;
        $add_client->project_url = $request->project_url;
        $add_client->assana = $request->assana;
        $add_client->status = '0';
        if($add_client->save()){
            return redirect("admin-client-management")->with('success','Add Client Successfully');
        }

    }

    public function delete_client($id){
        $delete = client_management::find($id);
        $delete->delete();
        return redirect()->back()->with('success','Delete Client Successfully');
    }

    public function edit_client($id){
        if (Session::get('role') =='') {
            // Session variable does not exist, redirect to login route
            return redirect()->route('admin');
        }
        $editclient = client_management::find($id);
        return view('admin.edit_client',compact('editclient'));
    }

    public function update_client_detail(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required',
          ]);

        $id = $request->id;
        $update = client_management::find($id);
        $update->name = $request->name;
        $update->email = $request->email;
        $update->contact = $request->contact;
        $update->facebook_id = $request->facebook_id;
        $update->instagram_id = $request->instagram_id;
        $update->skype_id = $request->skype_id;
        $update->telegram_id = $request->telegram_id;
        $update->whatsapp = $request->whatsapp;
        $update->upwork_id = $request->upwork_id;
        $update->project_url = $request->project_url;
        $update->assana = $request->assana;
        $update->status = '0';
        if($update->save()){
            return redirect("admin-client-management")->with('success','Update Client Successfully');
        }

    }


    public function task_management()
    {
        if (Session::get('role') =='') {
            // Session variable does not exist, redirect to login route
            return redirect()->route('admin');
        }
        $task_management = task_management::all();
        return view('admin.task_management',compact('task_management'));
    }

    public function add_task()
    {
        if (Session::get('role') =='') {
            // Session variable does not exist, redirect to login route
            return redirect()->route('admin');
        }
        $user = User::all();
        $project = project_management::all();

        return view('admin.add_task',compact('project','user'));
    }

    public function signOut() {
        Session::flush();
        return Redirect('admin');
    }

    public function add_task_detail(Request $request)
    {
        
        $validatedData = $request->validate([
            'project_name' => 'required',
            'task_title' => 'required',
            'description' => 'required',
            'total_hours' => 'required',
            'deadline' => 'required',
            'logindetail' => 'required'
            
        ]);
      
        $add_task = new task_management();
        $add_task->project_id = $request->project_name;
        $add_task->assign = $request->assign;
        $add_task->task_title = $request->task_title;
        $add_task->description = $request->description;
        $add_task->total_hours = $request->total_hours;
        $add_task->deadline = $request->deadline;
        $add_task->logindetail = $request->logindetail;

        $add_task->status = '0';
        if($add_task->save()){
            return redirect("task-management")->with('success','Add task Successfully');
        }

    }

    public function delete_task($id){
        $delete = task_management::find($id);
        $delete->delete();
        return redirect()->back()->with('success','Delete Task Successfully');
    }

    public function edit_task($id){
        if (Session::get('role') =='') {
            // Session variable does not exist, redirect to login route
            return redirect()->route('admin');
        }
        $project = project_management::all();
        $edittask = task_management::find($id);
        $user = User::all();
        return view('admin.edit_task',compact('edittask','project','user'));
    }


    public function update_task_detail(Request $request)
    {
        $validatedData = $request->validate([
            'project_name' => 'required',
            'task_title' => 'required',
            'description' => 'required',
            'total_hours' => 'required',
            'deadline' => 'required',
            'logindetail' => 'required'
            
        ]);

        $id = $request->id;
        $update = task_management::find($id);
        $update->project_id = $request->project_name;
        $update->assign = $request->assign;
        $update->task_title = $request->task_title;
        $update->description = $request->description;
        $update->total_hours = $request->total_hours;
        $update->deadline = $request->deadline;
        $update->logindetail = $request->logindetail;
        $update->status = '0';
      
        if($update->save()){
            return redirect("task-management")->with('success','Update task Successfully');
        }

    }

   


}
