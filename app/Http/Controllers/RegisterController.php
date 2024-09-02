<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Redirect;


use App\Models\File;

use App\Models\User;
use App\Models\Userworkout;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
use Hash;
use Carbon\Carbon;


class RegisterController extends Controller
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */

  
	
    public function login(Request $request)
{
    // Validate input if they are present
    $request->validate([
        'email' => 'nullable|email',
        'password' => 'nullable|string',
        'role' => 'nullable|string',
    ]);

    // Check if all required fields are provided
    if (!$request->email || !$request->password || !$request->role) {
        return $this->sendError('Validation Error.', ['error' => 'Email, password, and role are required.']);
    }

    // Normalize and log the role value
    $role = strtolower(trim($request->role));
    \Log::info('Role received: ' . $role);

    // Determine user type based on normalized role and fetch user data
    if ($role == "admin" || $role == "hr") {
        $user_data = Admin::where('email', $request->email)->first();
    } elseif ($role == "user") {
        $user_data = User::where('email', $request->email)->first();
    } else {
        return $this->sendError('Unauthorized.', ['error' => 'Invalid role provided.']);
    }

    // Check if the user exists
    if (!$user_data) {
        return $this->sendError('Unauthorized.', ['error' => 'User does not exist.']);
    }

    // Check if the password matches
    if (!Hash::check($request->password, $user_data->password)) {
        return $this->sendError('Unauthorized.', ['error' => 'Sorry, wrong email or password.']);
    }

    // Successful login
    return $this->sendResponse($user_data, 'You are logged in successfully.');
}

public function add_employee_detail(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required',
        'phone' => 'required',
        'designation'=>'required',
        'password'=>'required'
    ]);
   
    if($validator->fails()){
        return $this->sendError('Validation Error.', $validator->errors());
    }
   
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
        return $this->sendResponse('success', 'You are logged in successfully.');
    }

}

public function delete_employee(Request $request){

    $validator = Validator::make($request->all(), [
        'id' => 'required|exists:users,id',
    ]);
   
    if($validator->fails()){
        return $this->sendError('Validation Error.', $validator->errors());
    }
    $delete = User::find($request->id);
    $delete->delete();
    return $this->sendResponse('success','Employee Deleted Successfully');
}


 public function update_employee(Request $request)
 {

    $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required','email',Rule::unique('users')->ignore($request->id),
        'phone' => 'required',
    ]);
   
    if($validator->fails()){
        return $this->sendError('Validation Error.', $validator->errors());
    }

    $add_employee = User::find($request->id);

    // Check if a new image file is provided
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('user_profile'), $imageName);
        $add_employee->image = $imageName; // Update the image field
    }

    // Update other fields
    $add_employee->name = $request->name;
    $add_employee->email = $request->email;
    $add_employee->phone = $request->phone;
    $add_employee->designation = $request->designation;

    // Save the updated data
    $add_employee->update();
    return $this->sendResponse('success','Employee Updated Successfully');
      
 }
 public function profile_update(Request $request)
 {
 
     $validator = Validator::make($request->all(), [
        'name' => 'required',
        'email' => 'required',
        'phone' => 'required',
        'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);
   
    if($validator->fails()){
        return $this->sendError('Validation Error.', $validator->errors());
    }
     if ($request->hasFile('image')) {
         $image = $request->file('image');
         $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
         $image->move(public_path('user_profile'), $imageName);
       }
       if ($request->hasFile('image')) {
      
       $user = User::find($request->id);
       $user->name = $request->name;
       $user->email = $request->email;
       $user->phone = $request->phone;
       $user->image = $imageName;
       $user->update();
       }else{
         
         $user = User::find($request->id);
         $user->name = $request->name;
         $user->email = $request->email;
         $user->phone = $request->phone;
         $user->update();
       }
       return $this->sendResponse('success','Profile Updated Successfully');
      
  
 }
    public function logout (Request $request) {
       
         $deleteDeviceToken = User::where('id',$request->id)->update(['device_token' => "",'device_type'=>""]);
        
        return $this->sendResponse('', 'You have been successfully logged out!');
    }



    public function getProfile(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
        ]);
       
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user = User::where('id',$request->id)->first();
        return $this->sendResponse($user, 'Profile get successfully.');
    }
	
	
	

	
	
	public function deleteProfileID(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
        ]);
       
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $user = User::where('id',$request->id)->delete();
        return $this->sendResponse($user, 'Profile deleted successfully.');   
    }
	
	public function getBookings(Request $request) {
        $user = Booking::where('customer',$request->id)->join('properties', 'properties.id', '=', 'bookings.property_id')->select('bookings.*','properties.property_name')->orderBy('bookings.id','desc')->get();
        return $this->sendResponse($user, 'Booking get successfully.');
    }

	public function getConfirmedStatus(Request $request) {
        $user = Booking::where('customer',$request->id)->where('status',3)->select('bookings.*')->get();
		$user = $user->count();
        return $this->sendResponse($user, 'Booking get successfully.');
    }
	
	
	

    

    public function editProfile(Request $request) {
        $user_id = $request->user_id;

        /* $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email',
            'mobile_no' => 'required|numeric',
        ]); */

        $updateUser = User::whereId($user_id)->first();

        if ($request->has('profile_image')) {
            $image = $request->file('profile_image');
            $file_name = $image->getClientOriginalName();
            $file_name = uniqid() . "_" . $file_name;
            $file_name= substr("$file_name",10);
           // $file_name = imagecreatefromstring($file_name);
            $destinationPath = public_path('/uploads/images');
            $imagePath = $destinationPath. "/".  $file_name;
            $image->move($destinationPath, $file_name);
            $updateUser->profile_image = $file_name;
        }
          $updateUser->profile_image;
          
       
		if($request->has('gender')){
			$updateUser->gender = $request->gender;
		}
		if($request->has('age')){
			$updateUser->age = $request->age;
		}
		if($request->has('height')){
			$updateUser->height = $request->height;
		}
		if($request->has('weight')){
			$updateUser->weight = $request->weight;
		}
		if($request->has('phone')){
			$updateUser->phone = $request->phone;
		}
		if($request->has('name')){
			$updateUser->name = $request->name;
		}
        if($request->has('about')){
			$updateUser->about = $request->about;
		}
        if($request->has('address')){
			$updateUser->address = $request->address;
		}
        if($request->has('location')){
			$updateUser->location = $request->location;
		}
		$updateUser->update();

        return $this->sendResponse($updateUser, 'Profile updated successfully.');
    }

	public function editSettings(Request $request) {
        $user_id = $request->user_id;
        /* $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required|email',
            'mobile_no' => 'required|numeric',
        ]); */
        $updateUser = User::whereId($user_id)->first();
        
		if($request->has('settings_status')){
			$updateUser->settings_status = $request->settings_status;
		}
		
		$updateUser->update();
        return $this->sendResponse($updateUser, 'Settings updated successfully.');
    }

   


    //api for forget password
    public function forgetPassword(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $userdetail = User::where('email',$request->email)->first();
        if($userdetail) {
            if($userdetail->token=="") {
                $token = md5(uniqid(rand(), true));    
                $data = ['token'=> $token];            ;
                $userdetail->fill($data);
                $userdetail->save();
            }

            $userdetail->email;
            $name = $userdetail->name;
            //global $receiver_email;
            $receiver_email = $userdetail->email;   
            $code = $userdetail->token;         
            
            \Mail::send('web.frontend.email.reset-password-link', ['name' => $name, 'code' => $code ], function ($message) use($receiver_email) {
                $message->to($receiver_email)->subject("Pharmmers-Market : Reset Password");
            });

            return $this->sendResponse([], 'Reset link sent to email.');

        }else{
            return $this->sendError('Unauthorised.', ['error'=>'email not found']);
        }
    }

	

   


    public function changePassword(Request $request) {
        
        $user_id = Auth::id();
        
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required'
        ]);
        

        $checkUser = User::whereId($user_id)->first();

        if(Hash::check($request->old_password,$checkUser->password)) {
            $checkUser->password = Hash::make($request->new_password);
            $checkUser->update();
            return $this->sendResponse($checkUser, 'Password has been chnaged successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error'=>'Sorry, wrong username or password.']);
        }
    }

    public function test(){
        echo "test";
    }
	
	public function getFollow(Request $request){
		$user_id = $request->user_id;
		$follower_id = $request->follower_id;
		$followers = DB::table('follower')->where('user_id',$request->user_id)->get();
	}
	

	public function addFollow(Request $request){

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'follower_id' => 'required'
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
		$user_id = $request->user_id;
		$follower_id = $request->follower_id;
      $check_follow =  Follower::where('follower_id',$follower_id)->where('user_id',$user_id)->first();
    if(!empty($check_follow)){
        return $this->sendResponse($check_follow, 'user already followed.');
    }
		//$followers = DB::table('follower')->where('user_id',$request->user_id)->get();
		$follower = new Follower();
        $follower->user_id =$user_id;
        $follower->follower_id =$follower_id;
        $follower->save();
		 return $this->sendResponse($follower, 'Followed.');
	}

    public function unfollow(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'follower_id' => 'required',
        
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }  

        $unfollowes = Follower::where('user_id',$request->user_id)->where('follower_id',$request->follower_id)->first();
        if(empty($unfollowes)){
            return response()->json(['success' => 'false','message' => 'user not found'], 404);  
        }
        $unfollow = Follower::where('user_id',$request->user_id)->where('follower_id',$request->follower_id)->delete();
        if($unfollow){
            return response()->json(['success' => 'true','message' => 'user unfollow successfully'], 200);  
        }

    }


   

    

  

  
    ////save api /////

public function Savedpost(Request $request){
$validator = Validator::make($request->all(), [
'user_id' => 'required', 
]);
if($validator->fails()){
return $this->sendError('Validation Error.', $validator->errors());
}
$save_post = FlagSave::where('flag_saves.user_id',$request->user_id)->join('posts', 'posts.id', '=', 'flag_saves.post_id')
->join('users', 'users.id', '=', 'posts.user_id')->select('flag_saves.*','posts.title','posts.description','posts.image','users.id as saved_post_id','users.name as name','users.profile_image as profile_image','users.email')->get();

//if(!empty($request->user_id)){
    // $save_post = FlagSave::where('flag_saves.user_id',$request->user_id)->join('posts', 'posts.id', '=', 'flag_saves.post_id')->select('flag_saves.*','posts.title','posts.description','posts.image')->groupBy('flag_saves.post_id')->get();
// }
// else{
// $save_post = FlagSave::join('posts', 'posts.id', '=', 'flag_saves.post_id')->select('flag_saves.*','posts.title','posts.description','posts.image')->get();
//}

foreach($save_post as $key=>$all_save_post){
  if(empty($all_save_post->profile_image)){
    $all_save_post->profile_image="";
  }
$liked_array=array();
$likes = Like::where('status','1')->where('post_id',$all_save_post->post_id)->get();
$likecount = $likes->count();
$like = Like::where('status','1')->where('post_id',$all_save_post->post_id)->get()->toArray();
$all_save_post->likes = $likecount;
$likesbyuser = Like::where('status','1')->where('post_id',$all_save_post->post_id)->where('user_id',$request->user_id)->get();           
$likesbyuserC = $likesbyuser->count();		
if($likesbyuserC > 0){
$all_save_post->islike  = 1;
}else{
$all_save_post->islike  = 0;

}	
$save_flage = FlagSave::
            where('post_id',$all_save_post->post_id)
            ->where('user_id',$request->user_id)
            ->get();
$save_flage = $save_flage->count();		
if($save_flage > 0){
$all_save_post->is_save = 1;
}else{
$all_save_post->is_save = 0;
}
$comments =  Comment::select('id','comment')->where('post_id',$all_save_post->post_id)->get();
$all_save_post->total_comments=$comments->count();
$all_save_post->comments=$comments;
$get_liked_user=array();
foreach($like as $user_like){
$userdetails= $user_like['user_id'];
$liked_byuser=User::select('id','name','email','profile_image')->where('id',$userdetails)->get();
foreach($liked_byuser as $likes_by_user){
$get_liked_user[]=$likes_by_user; }
$all_save_post->liked_by=$get_liked_user;
}
}
if(!empty($save_post)) {
return response()->json(['success' => 'true','message' => 'post save List','data'=> $save_post], 200);  
}
else{
return response()->json(['success' => 'false','message' => ' data not found'], 404);
}
}
  /////my_trainers///
  public function my_trainers(Request $request){
    $validator = Validator::make($request->all(), [
        'id' => 'required', 
        ]);
        if($validator->fails()){
        return $this->sendError('Validation Error.', $validator->errors());
        }
         $record= Follower::with('my_trainer')->whereRelation('my_trainer','type','=',1)->where('follower_id',$request->id)->get();
        return response()->json(['success' => 'true','message' => 'all my trainers','data'=> $record], 200);
  }
  /////  

    /////myGyms///
    public function my_gyms(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required', 
            ]);
            if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
            }
             $record= Follower::with('my_gym')->whereRelation('my_trainer','type','=',4)->where('follower_id',$request->id)->get();
            return response()->json(['success' => 'true','message' => 'all my gym','data'=> $record], 200);
      }
      /////  


          /////following list///
    public function following(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required', 
            ]);
            if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
            }
             $record= Follower::with('my_trainer')->where('follower_id',$request->id)->get();
            return response()->json(['success' => 'true','message' => 'following count','total'=> $record], 200);
      }
      /////  


      ///////activities ////
      public function activites(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required', 
            ]);
            if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
            }
           //  $Workouts = Workout::count();
             $Workouts= Userworkout::where('user_id',$request->id)->where('status',2)->count();
             $get_user_diet_plan = DB::table('user_diet_plan')
             ->join('diet_plan_detail', 'user_diet_plan.meal_id', '=', 'diet_plan_detail.id')
             ->join('diet_plan', 'diet_plan_detail.category_id', '=', 'diet_plan.id')
             ->select(DB::raw('SUM(diet_plan_detail.calories) AS total_calories')) // Calculate total calories
             ->where('user_diet_plan.user_id', $request->id) // Filter by user_id
             ->first();
         

            $total_calories = $get_user_diet_plan->total_calories ?? 0;
            $total_complete= Userworkout::where('user_id',$request->id)->count();
            $users= User::select('height','weight')->where('id',$request->id)->first();
            if(!empty($users)){
                $bmi = $this->calculateBMI($users->weight, $users->height);
                $bmi_data =  round($bmi, 2);
            }else{
                $bmi_data = '';
            }
           
           //  $record= Follower::where('follower_id',$request->id)->get();
            //  foreach($record as $alldetails){
                
            //     $trainer= User::select('id','name','email','phone','about')->where('id',$alldetails->user_id)->where('type',1)->get();
            //     $gym= User::select('id','name','email','phone','about')->where('id',$alldetails->user_id)->where('type',4)->get();
        
            //     $alldetails->my_trainers=$trainer;
            //     $alldetails->my_gyms=$gym;
            //  }
            return response()->json(['success' => 'true','message' => 'all details', 'total_workouts'=>$total_complete,'complete_workouts'=>$Workouts,'steps'=>'9,999','calories'=>$total_calories,'bmi'=>$bmi_data], 200);
      }


      public function workoutdone(Request $request){

        $validator = Validator::make($request->all(), [
            'workout_id' => 'required', 
            ]);
            if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
            }
            $Workouts = Userworkout::where('id',$request->workout_id)->first();
            if(!empty($Workouts)){
                $Workouts->status=2; 
               $done_workout= $Workouts->save();
               if( $done_workout){
                return response()->json(['success' => 'true','message' => 'workoutdone'], 200);
               }
            }
            else{
                return response()->json(['success' => 'false','message' => 'workout not found'], 404);
            }
         
      }
 


   

    public function updateBmi(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'user_id' => 'required',
        'age' => 'required',
        'height' => 'required',
        'weight'=>'required'
    ]);

    if($validator->fails()){
        return $validator->errors();
    } 
		
		$input = $request->all();
        $user_id = $input['user_id'];
        $age = $input['age'];
		$height = $input['height'];
        $weight = $input['weight'];
        $message = DB::table('users')->where('id',$user_id)->update(
					array(
						'age'     =>  $age, 
						'height'   =>   $height,
						'weight'             => $weight
                        
					)
				);

                
        
return response()->json(['success' => 'true','message' => 'data get successfully'], 200);
		
	}
 

            public function get_all_dietplan(Request $request) {
                $diet_plans = diet_plan::orderBy('id', 'DESC')->get();

                foreach ($diet_plans as $diet_plan) {
                    $category = diet_meal::where('id',$diet_plan->category_id)->first();
                    if ($category) {
                        $diet_plan->category_name = $category->category;
                    } else {
                        $diet_plan->category_name = 'Unknown Category'; // Or whatever default value you want
                    }
                }
            return response()->json(['success' => 'true','message' => 'diet plan get successfully','data'=>$diet_plans], 200);
            }

            public function add_user_diet_plan(Request $request){
                $validator = Validator::make($request->all(), [
                    'user_id' => 'required',
                    'meal_id' => 'required',
                    'category_id' => 'required',
                    'type'=>'required'
                    
                ]);
                if($validator->fails()){
                    return $this->sendError('Validation Error.', $validator->errors());
                }  
                $meal_ids = explode(',', $request->meal_id);
                $category_ids = explode(',', $request->category_id);
            
                // Loop through each pair of meal_id and category_id
                foreach ($meal_ids as $key => $meal_id) {
                    // Create a new instance of add_user_diet_plan model
                    $savedietplan = new add_user_diet_plan();
                    $savedietplan->user_id = $request->user_id;
                    $savedietplan->meal_id = $meal_id;
                    // Ensure category_id exists for the current index
                    if (isset($category_ids[$key])) {
                        $savedietplan->category_id = $category_ids[$key];
                    } else {
                        // Handle the case where category_id is not provided for the current meal_id
                        $savedietplan->category_id = null; // Or set a default value
                    }
                    $savedietplan->type = $request->type;
                    $savedietplan->created_at = date('Y-m-d H:i:s'); // You can use now() to get the current timestamp
            
                    // Save the record to the database
                    $savedietplan->save();
                }
             
                return response()->json(['success' => 'true','message' => 'diet plan added successfully'], 200);
                } 
            
            

            public function get_all_dietplan_user(Request $request) {
                $validator = Validator::make($request->all(), [
                    'user_id' => 'required'
                    
                ]);
                if($validator->fails()){
                    return $this->sendError('Validation Error.', $validator->errors());
                }  
                $get_user_diet_plan =  DB::table('user_diet_plan')
                ->join('diet_plan_detail', 'user_diet_plan.meal_id', '=', 'diet_plan_detail.id')
                ->join('diet_plan', 'diet_plan_detail.category_id', '=', 'diet_plan.id')
                ->where('user_diet_plan.user_id', '=', $request->user_id)
                ->get();
            
                return response()->json(['success' => 'true','message' => 'diet plan get successfully','data'=>$get_user_diet_plan], 200);
                }

                public function get_all_plan_by_date_old(Request $request) {
                    $validator = Validator::make($request->all(), [
                        'user_id' => 'required',
                        'date'=>'required'
                        
                    ]);
                    if($validator->fails()){
                        return $this->sendError('Validation Error.', $validator->errors());
                    }
                    $date =$request->date;   
                    $get_user_diet_plan = DB::table('user_diet_plan')
                    ->select('diet_plan_detail.meal_name','diet_plan_detail.category_id','diet_plan_detail.calories','diet_plan_detail.protein','diet_plan_detail.carbs','diet_plan_detail.fat','diet_plan_detail.fiber','diet_plan_detail.meal_name', 'diet_plan.category', 'user_diet_plan.id', 'user_diet_plan.user_id', 'user_diet_plan.meal_id', 'user_diet_plan.type','diet_plan_detail.image as MealImage')
                    ->join('diet_plan_detail', 'user_diet_plan.meal_id', '=', 'diet_plan_detail.id')
                    ->join('diet_plan', 'diet_plan_detail.category_id', '=', 'diet_plan.id')
                    ->where('user_diet_plan.user_id', $request->user_id)
                    ->whereDate('user_diet_plan.created_at', $date) // Compare date portion only
                    ->get();
                    
                    return response()->json(['success' => 'true','message' => 'diet plan get successfully','data'=>$get_user_diet_plan], 200);
                    }

               
                    public function get_all_plan_by_date(Request $request) {
                        $validator = Validator::make($request->all(), [
                            'user_id' => 'required',
                            'date' => 'required|date',
                            'period' => 'required|in:daily,weekly,monthly'
                        ]);
                        
                        if ($validator->fails()) {
                            return $this->sendError('Validation Error.', $validator->errors());
                        }
                    
                        $userId = $request->user_id;
                        $date = $request->date;
                        $period = $request->period;
                    
                        $query = DB::table('user_diet_plan')
                            ->select(
                                'diet_plan_detail.meal_name', 'diet_plan_detail.category_id', 
                                'diet_plan_detail.calories', 'diet_plan_detail.protein', 
                                'diet_plan_detail.carbs', 'diet_plan_detail.fat', 'diet_plan_detail.image as MealImage',
                                'diet_plan_detail.fiber', 'diet_plan.category', 
                                'user_diet_plan.id', 'user_diet_plan.user_id', 
                                'user_diet_plan.meal_id', 'user_diet_plan.type',
                                'diet_plan_detail.created_at'
                            )
                            ->join('diet_plan_detail', 'user_diet_plan.meal_id', '=', 'diet_plan_detail.id')
                            ->join('diet_plan', 'diet_plan_detail.category_id', '=', 'diet_plan.id')
                            ->where('user_diet_plan.user_id', $userId);
                    
                        switch ($period) {
                            case 'daily':
                                $query->whereDate('user_diet_plan.created_at', $date);
                                break;
                            case 'weekly':
                                 $startOfWeek = \Carbon\Carbon::parse($date)->startOfWeek();
                               $endOfWeek = \Carbon\Carbon::parse($date)->endOfWeek();
                                $query->whereBetween('user_diet_plan.created_at', [$startOfWeek, $endOfWeek]);
                                break;
                            case 'monthly':
                                $startOfMonth = \Carbon\Carbon::parse($date)->startOfMonth();
                                $endOfMonth = \Carbon\Carbon::parse($date)->endOfMonth();
                                $query->whereBetween('user_diet_plan.created_at', [$startOfMonth, $endOfMonth]);
                                break;
                        }
                    
                        $get_user_diet_plan = $query->get();
                    
                        return response()->json(['success' => 'true', 'message' => 'Diet plan retrieved successfully', 'data' => $get_user_diet_plan], 200);
                    }
                    
}
