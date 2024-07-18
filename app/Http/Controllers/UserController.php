<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Http\Controllers\Redirect;
use App\Models\User;
use App\Models\Employeleave;
use Illuminate\Support\Facades\Auth;
use App\Models\employee_attendence_time;
use Illuminate\Support\Facades\Date;
use App\Models\project_management;
use App\Models\task_time;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        Session::put('role', '');
        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
 $validator = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        //--//
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            Session::put('role', 'user');
            return redirect()->intended('dashboard')
                ->withSuccess('Signed in');
        }
        $validator['emailPassword'] = 'Email address or password is incorrect.';
        return redirect("/")->withErrors($validator);
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
        if (Auth::check()) {
            return view('dashboard');
        }

        return redirect("/")->withSuccess('You are not allowed to access');
    }

    public function applyLeave()
    {
        if (Auth::check()) {
        return view('user.employeeLeave');
        }
        return redirect("/")->withSuccess('You are not allowed to access');
    }

    public function attendence_time()
    {
        $userId = Auth::id();
        $today = now()->toDateString();

        // Retrieve the latest attendance time record for the current user
        $time = employee_attendence_time::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->latest()
            ->first();
            if (Auth::check()) {
        return view('user.attendenceTime',compact('time'));
            }else{
                return redirect("/")->withSuccess('You are not allowed to access');
            }
    }

    public function attendence()
    {
        $userId = Auth::id();
        $today = now()->toDateString();

        $time = employee_attendence_time::where('user_id', $userId)->whereDate('created_at', $today)->latest()->first();
        if ($time) {
            $currentTime = Date::now()->format('Y-m-d H:i:s');
            $updatetime = employee_attendence_time::where('user_id', $userId)->whereDate('created_at', $today)->latest()->first();
            $updatetime->in_time = $currentTime;
            if ($updatetime->update()) {
                echo "Again Login Successfully";
            }

        } else {
        
            $currentTime = Date::now()->format('Y-m-d H:i:s');
            $model = new employee_attendence_time;
            $model->user_id = $userId;
            $model->in_time = $currentTime;
            $model->out_time = $currentTime;
            if ($model->save()) {
                echo "Login Successfully";
            }
        }
    }


    public function time_start()
    {
      
        $currentTime = Date::now(); // No need to format immediately, keep it as a Carbon instance
        $userId = Auth::id();
        $today = now()->toDateString();
        $time = employee_attendence_time::where('user_id', $userId)
        ->whereDate('created_at', $today)
        ->latest()
        ->first();
       
        if ($time) {
            if($time->login_status == '0'){
            $time->user_id = $userId;
            $time->in_time = $currentTime;
            if ($time->save()) {
                echo "Again Login Successfully";
            }
        }else{
            echo "Already Login";
        }
            }else{
                $model = new employee_attendence_time;
                $model->user_id = $userId;
                $model->in_time = $currentTime;
                $model->out_time = $currentTime;
                $model->login_status = '1';
                if ($model->save()) {
                    echo "Login Successfully";
                }
            }
       
        
       

      
    }

    public function gettime()
    {
        $currentTime = Date::now(); // No need to format immediately, keep it as a Carbon instance
        $userId = Auth::id();
        $today = now()->toDateString();

        // Retrieve the latest attendance time record for the current user
        $time = employee_attendence_time::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->latest()
            ->first();
       $start_time = $time->in_time;
       $time_difference = $currentTime->diff($start_time);

       // Extract hours and minutes
       $hours = $time_difference->h + ($time_difference->days * 24);
       $minutes = $time_difference->i;
       $total_minutes = ($hours * 60) + $minutes;

       // Convert total_minutes to hours and minutes format
       $total_hours = floor($total_minutes / 60);
       $total_minutes = $total_minutes % 60;
       $formatted_total_hours = str_pad($total_hours, 2, '0', STR_PAD_LEFT);
       $formatted_total_minutes = str_pad($total_minutes, 2, '0', STR_PAD_LEFT);
       $totaltime = $formatted_total_hours . ':' . $formatted_total_minutes;
       echo  $totaltime;
    }

    public function time_pause()
    {
        $currentTime = Date::now(); // No need to format immediately, keep it as a Carbon instance
        $userId = Auth::id();
        $today = now()->toDateString();

        // Retrieve the latest attendance time record for the current user
        $time = employee_attendence_time::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->latest()
            ->first();

        if ($time) {
            $start_time = $time->in_time;

            // Calculate time difference
            $time_difference = $currentTime->diff($start_time);

            // Extract hours and minutes
            $hours = $time_difference->h + ($time_difference->days * 24);
            $minutes = $time_difference->i;

            // Calculate total minutes worked
            $total_minutes = ($hours * 60) + $minutes;

            // Convert total_minutes to hours and minutes format
            $total_hours = floor($total_minutes / 60);
            $total_minutes = $total_minutes % 60;

            // Format total_hours and total_minutes
            $formatted_total_hours = str_pad($total_hours, 2, '0', STR_PAD_LEFT);
            $formatted_total_minutes = str_pad($total_minutes, 2, '0', STR_PAD_LEFT);

            // Update out time and total hours in the attendance record
            $time->out_time = $currentTime;

            if ($time->total_hours != '0') {
                list($prev_hours, $prev_minutes) = explode(':', $time->total_hours);
                $total_hours += (int) $prev_hours;
                $total_minutes += (int) $prev_minutes;
            }

            // Adjust hours if minutes exceed 60
            $total_hours += floor($total_minutes / 60);
            $total_minutes = $total_minutes % 60;

            $formatted_total_hours = str_pad($total_hours, 2, '0', STR_PAD_LEFT);
            $formatted_total_minutes = str_pad($total_minutes, 2, '0', STR_PAD_LEFT);

            $time->total_hours = $formatted_total_hours . ':' . $formatted_total_minutes;
            $time->in_time =  $currentTime;
            if ($time->save()) {
                echo "logout successfully";
            } else {
                echo "Failed to update attendance record";
            }
        } else {
            echo "No attendance record found for the user";
        }
    }



    public function time_stop()
    {
        
        $currentTime = Date::now(); // No need to format immediately, keep it as a Carbon instance
        $userId = Auth::id();
        $today = now()->toDateString();

        /// Retrieve the latest attendance time record for the current user
        $time = employee_attendence_time::where('user_id', $userId)
            ->whereDate('created_at', $today)
            ->latest()
            ->first();

        if ($time) {
            $start_time = $time->in_time;

            // Calculate time difference
            $time_difference = $currentTime->diff($start_time);

            // Extract hours and minutes
            $hours = $time_difference->h + ($time_difference->days * 24);
            $minutes = $time_difference->i;

            // Calculate total minutes worked
            $total_minutes = ($hours * 60) + $minutes;

            // Convert total_minutes to hours and minutes format
            $total_hours = floor($total_minutes / 60);
            $total_minutes = $total_minutes % 60;

            // Format total_hours and total_minutes
            $formatted_total_hours = str_pad($total_hours, 2, '0', STR_PAD_LEFT);
            $formatted_total_minutes = str_pad($total_minutes, 2, '0', STR_PAD_LEFT);

            // Update out time and total hours in the attendance record
            $time->out_time = $currentTime;

            if ($time->total_hours != '0') {
                list($prev_hours, $prev_minutes) = explode(':', $time->total_hours);
                $total_hours += (int) $prev_hours;
                $total_minutes += (int) $prev_minutes;
            }

            // Adjust hours if minutes exceed 60
            $total_hours += floor($total_minutes / 60);
            $total_minutes = $total_minutes % 60;

            $formatted_total_hours = str_pad($total_hours, 2, '0', STR_PAD_LEFT);
            $formatted_total_minutes = str_pad($total_minutes, 2, '0', STR_PAD_LEFT);

            $time->total_hours = $formatted_total_hours . ':' . $formatted_total_minutes;

            if ($time->save()) {
                echo "Logout Successfully";
            } else {
                echo "Failed to update attendance record";
            }
        } else {
            echo "No attendance record found for the user";
        }
    }

    public function leave(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'date' => 'required',
            'reason' => 'required',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();
        $leave = Employeleave::create($data);
        return redirect("user/apply-leave")->with('leavemessage', 'Apply Leave Successfully');


    }

    public function profile()
    {
        $userId = Auth::id();
        $userdetail = User::find($userId);
        if (Auth::check()) {
        return view('user.profile',compact('userdetail'));
        }else{
            return redirect("/")->withSuccess('You are not allowed to access');
        }
    }

    public function profile_update(Request $request)
    {
        $request->validate([
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // adjust max size as needed
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('user_profile'), $imageName);
          }
          if ($request->hasFile('image')) {
          $id =  Auth::id();
          $user = User::find($id);
          $user->name = $request->name;
          $user->email = $request->email;
          $user->phone = $request->phone;
          $user->image = $imageName;
          $user->update();
          }else{
             $id =  Auth::id();
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->update();
          }
          return redirect()->back()->with('success','Profile Updated Successfully');
     
    }


    public function get_project()
    {
        $userId = Auth::id();
        $projects = project_management::where('assign',$userId)->get();
        if (Auth::check()) {
        return view('user.get_project',compact('projects'));
        }else{
            return redirect("/")->withSuccess('You are not allowed to access');
        }
    }

    public function view_project($id)
    {
        $projectdetail = project_management::where('id',$id)->first();
        if (Auth::check()) {
            return view('user.view_project',compact('projectdetail'));
            }else{
                return redirect("/")->withSuccess('You are not allowed to access');
            }
    }

    public function get_task()
    {
        $userId = Auth::id();
        $task =  DB::table('project_managements')
        ->join('task_managements', 'project_managements.id', '=', 'task_managements.project_id')
        ->where('project_managements.assign', '=', '2')
        ->select('project_managements.project_name', 'task_managements.*')
        ->get();
       
        if (Auth::check()) {
        return view('user.get_task',compact('task'));
        }else{
            return redirect("/")->withSuccess('You are not allowed to access');
        }
    }

    public function view_task($id)
    {
        $taskdetail =  DB::table('project_managements')
        ->join('task_managements', 'project_managements.id', '=', 'task_managements.project_id')
        ->where('task_managements.id', '=', $id)
        ->select('project_managements.project_name', 'task_managements.*')
        ->first();
        if (Auth::check()) {
            return view('user.view_task',compact('taskdetail'));
            }else{
                return redirect("/")->withSuccess('You are not allowed to access');
            }
    }


    public function add_task_time(Request $request)
    {
        $userId = Auth::id();

        $validatedData = $request->validate([
            'project_id' => 'required',
            'task_id' => 'required'
          ]);
      
        $currentDateTime = Carbon::now();

        $task_time = new task_time();
        $task_time->project_id = $request->project_id;
        $task_time->task_id = $request->task_id;
        $task_time->user_id = $userId;
        $task_time->start_time = $currentDateTime;

        $task_time->status = '0';
        if($task_time->save()){
            return redirect("user/view-task/{$request->task_id}")->with('success', 'Task Time Start');
        }

    }

    public function task_end_time(Request $request)
    { 
        $userId = Auth::id();
        $task_id = $request->task_id;
        $project_id = $request->project_id;
        
        // Fetch the latest task_time record for the given user, task, and project
        $task_time = task_time::where('user_id', $userId)
                              ->where('task_id', $task_id)
                              ->where('project_id', $project_id)
                              ->latest()
                              ->first();
        
        if ($task_time) {
            // Get start time from the fetched record
            $start_time = $task_time->start_time;
            
            // Calculate current time as end time
            $end_time = Carbon::now();
            
            // Parse start and end times using Carbon
            $start = Carbon::parse($start_time);
            $end = Carbon::parse($end_time);
            
            // Calculate the time difference
            $diff = $end->diff($start);
            
            // Update task_time record with end time and total time difference
            $task_time->end_time = $end_time;
            $task_time->total_time = $diff->format('%H:%I:%S'); // Format the difference as HH:MM:SS
            
            // Save the updated record
            $task_time->save();
            
            // Output message or redirect as needed
            echo "Task ended successfully.";
        } else {
            echo "Task time record not found."; // Handle error if no record found
        }
    }
    
    public function signOut()
    {
        Session::flush();
        Auth::logout();
        return Redirect('/');
    }
}
