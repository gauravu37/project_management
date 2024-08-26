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
    public function register(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
           // 'c_password' => 'required|same:password',

        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
		
		$checkEmail = User::where('email',$request->email)->first();
        if($checkEmail) {
			 return $this->sendError('Alreadtexist.', ['error'=>'User Alreasy exist']);
		}else{

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['gender'] = $input['gender'];
        $input['age'] = $input['age'];
        $input['height'] = $input['height'];
        $input['weight'] = $input['weight'];
        $input['type'] = $input['type'];
        $input['device_token']=$input['device_token'];
        $user = User::create($input);
       // $success['token'] =  $user->createToken('MyApp')->accessToken;
        //$success['name'] =  $user->name;
		
		$input['id'] = $user->id;
		$inseruser = DB::table('users')->where('id',$user->id)->update(
			[
				//'password' => bcrypt($input['password']), 
				'gender' => $input['gender'],
				'age' => $input['age'],
				'height' => $input['height'],
				'weight' => $input['weight'],
                'type'=> $input['type'],
                'device_token'=>$input['device_token']
				//'email' => $input['email'],
				//'name' => $input['name'],
			]
		);

        return $this->sendResponse($input, 'User register successfully.');
		}
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */

    public function loginbyemail(Request $request)
    {
        $checkEmail = User::where('email',$request->email)->first();
        if($checkEmail) {
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                if($user->status==1) {
                    $success['data'] =  User::where('id',$user->id)->first();
                    $success['token'] =  $user->createToken('MyApp')-> accessToken;

                    return $this->sendResponse($success, 'User login successfully.');

                } else {
                    return $this->notAcceptable('Acount is not active or blocked.', ['error'=>'Account not active']);
                }

            } else{
                return $this->sendError('Unauthorised.', ['error'=>'Invalid Credentials']);
            }
        } else {
            if($request->type == '1') {
                $createUser = new User();
                $createUser->email = $request->email;
                $createUser->password = Hash::make($request->password);
                $createUser->save();
                $success['data'] =  User::where('id',$createUser->id)->first();
                $success['token'] =  $success['data']->createToken('MyApp')-> accessToken;
                return $this->sendResponse($success, 'User login successfully.');
            } else {
                return $this->sendError('Unauthorised.', ['error'=>'Invalid Credentials']);
            }
            
        }
    } 
	
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

  
    public function logout_old (Request $request) {
        // $deleteDeviceToken = User::where('id',Auth::id())->update(['device_token' => ""]);
        $token = $request->user()->token();
        $token->revoke();
        return $this->sendResponse('', 'You have been successfully logged out!');
    }

    public function logout (Request $request) {
       
         $deleteDeviceToken = User::where('id',$request->id)->update(['device_token' => "",'device_type'=>""]);
        
        return $this->sendResponse('', 'You have been successfully logged out!');
    }



    public function getProfile(Request $request) {
        $user = User::where('phone',$request->phone)->first();
        return $this->sendResponse($user, 'Profile get successfully.');
    }
	
	
	
	public function getProfileID(Request $request) {
        $user = User::where('id',$request->id)->first();
		
		$trainerpackages = Trainerpackage::where('trainer',$request->id)->get();
      // $posts = Post::where('user_id',$request->id)->get();
        $posts = Post::select('id','image','title','description','created_at')->where('user_id',$request->id)->get();
     
        foreach($posts as $key=>$all_posts){
          //  echo $all_posts->id;
            $comments_count = Comment::where('post_id',$all_posts->id)->count();
            $like_count = Like::where('post_id',$all_posts->id)->count();
            $like = Like::where('post_id',$all_posts->id)->get();
            $islike = Like::where('post_id',$all_posts->id)->where('user_id',$request->id)->count();

            if($islike > 0){
				$all_posts->islike = 1;
			}else{
				$all_posts->islike = 0;
			}
            $all_posts->likes=$like_count;
            ////likes array//
            $get_liked_user=array();
foreach($like as $user_like){
$userdetails= $user_like['user_id'];
$liked_byuser=User::select('id','name','email','profile_image')->where('id',$userdetails)->get();
foreach($liked_byuser as $likes_by_user){
$get_liked_user[]=$likes_by_user; }
$all_posts->liked_by=$get_liked_user;
}
            ///end like array//
            $all_posts->comments=$comments_count;
            $save_flage = FlagSave::
            where('post_id',$all_posts->id)
            ->where('user_id',$request->id)
            ->get();
$save_flage = $save_flage->count();		
if($save_flage > 0){
$all_posts->is_save = 1;
}else{
$all_posts->is_save = 0;
}
           
        }
        $total_post = Post::where('user_id',$request->id)->count();
       $follower_count = Follower::where('user_id',$request->id)->where('status',1)->count();
       $review_count = Review::where('user_id',$request->id)->count();
       $total_trainer = Trianer_plans_history::where('customer_id',$request->id)->count();
       $user['followers']=$follower_count;
       $user['total_trainer']=$total_trainer;
       $user['reviews']=$review_count;
       $user['totalpost']=$total_post;
       $user['trainerpackages'] = $trainerpackages;
       $user['all_posts'] = $posts;

       
		return $this->sendResponse($user, 'Profile get successfully.');
    }
	
	
	public function deleteProfileID(Request $request) {
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
	
	
	public function getOTPdata(Request $request) {
		$phoneno = $request->id;
        $url = 'https://2factor.in/API/V1/a44826f2-67a4-11ec-b710-0200cd936042/SMS/'.$phoneno.'/AUTOGEN';
     
		$ch = curl_init();
		// IMPORTANT: the below line is a security risk, read https://paragonie.com/blog/2017/10/certainty-automated-cacert-pem-management-for-php-software
		// in most cases, you should set it to true
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		$result = curl_exec($ch);
		
		curl_close($ch);
        return $result;
		//$obj = json_decode($result);
		//print_r($result);
		
        //return $this->sendResponse($user, 'Booking get successfully.');
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

public function friendRequest(Request $request)
    {
        /* //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
           // 'c_password' => 'required|same:password',

        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        } */
		/* 
			pending_first_second : the first made a friend request to the second ///// 
			pending_second_first ///// 
			friends ///// 
			block_first_second ///// 
			block_second_first block_both
		*/
		
		$input = $request->all();
        $user_first_id = $input['user_first_id'];
        $user_second_id = $input['user_second_id'];
        $user = DB::table('user_relationship')->insert(
					array(
						'user_first_id'     =>  $user_first_id, 
						'user_second_id'   =>   $user_second_id,
						'type'             =>   'pending_first_second'
					)
				);
		return $this->sendResponse($input, 'Friend request sent successfully.');
		
	}
	
	public function updatefriendRequest(Request $request)
    {
        /* //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
           // 'c_password' => 'required|same:password',

        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        } */
		/* 
			pending_first_second : the first made a friend request to the second ///// 
			pending_second_first ///// 
			friends ///// 
			block_first_second ///// 
			block_second_first block_both
		*/
		
		$input = $request->all();
        $user_first_id = $input['user_first_id'];
        $user_second_id = $input['user_second_id'];
		$type = $input['type'];
        $user = DB::table('user_relationship')->update(
					array(
						'user_first_id'     =>  $user_first_id, 
						'user_second_id'   =>   $user_second_id,
						'type'             =>   $type
					)
				);
		return $this->sendResponse($input, 'Friend request updated successfully.');
		
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


    public function follow_request(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required', 
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        } 
        //$followrequests = Follower::where('user_id',$request->user_id)->where('status',0)->get();

        $followrequests = Follower::where('user_id',$request->user_id)->where('follower.status',0)->join('users', 'users.id', '=', 'follower.follower_id')->select('follower.*','users.name as name','users.profile_image as profile_image','users.email as email' )->get();

        return response()->json(['success' => 'true','message' => 'Follow Requests','data'=> $followrequests], 200);  
    }

    public function FollowRequestAcceept(Request $request){
     
        $validator = Validator::make($request->all(), [
            'user_id' => 'required', 
            'follower_id' => 'required',
            'type' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
 
    }
      if($request->type=='Accepted'){
        //$followrequests = Follower::where('user_id',$request->user_id)->where('status',0)->get();

        $accept_followrequest = Follower::where('user_id',$request->user_id)->where('follower_id',$request->follower_id)->get()->toArray();
       
        if(!empty($accept_followrequest)){
           
            $changes_status = DB::table('follower')->where('user_id',$request->user_id)->where('follower_id',$request->follower_id)->update(['status' => 1]);
            $changes_status2 = DB::table('follower')->where('user_id',$request->user_id)->where('follower_id',$request->follower_id)->first();
           
           if( $changes_status) {
            return response()->json(['success' => 'true','message' => 'Follow Request Accepted Successfully','data'=> $changes_status2], 200);  
           }
           else{
            return response()->json(['success' => 'true','message' => 'request already Accepted'], 200);
           }


        }
        else{
            return response()->json(['success' => 'false','message' => 'id not found'], 404);  
        }
    }
    elseif($request->type=='Rejected'){
        
        $rejected_followrequest = Follower::where('user_id',$request->user_id)->where('follower_id',$request->follower_id)->get()->toArray();
       
        if(!empty($rejected_followrequest)){
            $changes_status = DB::table('follower')->where('user_id',$request->user_id)->where('follower_id',$request->follower_id)->update(['status' => 2]);
            $changes_status1 = Follower::where('user_id',$request->user_id)->where('follower_id',$request->follower_id)->first();

           
           if( $changes_status) {
            return response()->json(['success' => 'true','message' => 'Follow Request Rejected Successfully','data'=> $changes_status1], 200);  
           }
           else{
            return response()->json(['success' => 'true','message' => 'request already Rejected'], 200);
           }

        }
        else{
            return response()->json(['success' => 'false','message' => 'id not found'], 404);  
        }


    }
    else{
        return response()->json(['success' => 'false','message' => 'unvalid type'], 500);  
    }
      //  return response()->json(['success' => 'true','message' => 'Follow Requests','data'=> $followrequests], 200);  

      
    }

    public function Follower(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required', 
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
 
    }
    $follower = Follower::where('user_id',$request->user_id)->where('follower.status',1)->join('users', 'users.id', '=', 'follower.follower_id')->select('follower.*','users.name as name','users.profile_image as profile_image','users.email')->get();
    // $get_revews_data = Review::where('user_id',"$user->id")->join('users', 'users.id', '=', 'reviews.reviewer_id')->select('reviews.*','users.name as name','users.profile_image as profile_image' )->get();
    if( !empty($follower)) {
        return response()->json(['success' => 'true','message' => 'Follower List','data'=> $follower], 200);  
       }
       else{
        return response()->json(['success' => 'false','message' => ' data not found'], 404);
       }

    }

    public function Followe_gym_bus(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required', 
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
 
    }
    $follower = Follower::where('user_id',$request->user_id)->join('users', 'users.id', '=', 'follower.follower_id')->select('follower.*','users.name as name','users.profile_image as profile_image','users.email')->get();
    // $get_revews_data = Review::where('user_id',"$user->id")->join('users', 'users.id', '=', 'reviews.reviewer_id')->select('reviews.*','users.name as name','users.profile_image as profile_image' )->get();
    if(!empty($follower)) {
        return response()->json(['success' => 'true','message' => 'Follower List','data'=> $follower], 200);  
       }
       else{
        return response()->json(['success' => 'false','message' => ' data not found'], 404);
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
      //////chatts
      public function sent_message(Request $request){
        $validator = Validator::make($request->all(), [
            'send_to' => 'required',
            'send_from' => 'required',
            'message' => 'required',
           // 'c_password' => 'required|same:password',
    
        ]);
    
        if($validator->fails()){
            return $validator->errors();
        } 
       $savemessage = new ChMessage();
       $savemessage->to_id=$request->send_to;
       $savemessage->from_id=$request->send_from;
       $savemessage->body=$request->message;
       if ($request->has('attachment')) {

        $image = $request->file('attachment');
         $name = str_slug($request->attachment).'.'.$image->getClientOriginalExtension();
         $destinationPath = public_path('/uploads/images');
         $imagePath = $destinationPath. "/".  $name;
        $image->move($destinationPath, $name);
        $savemessage->attachment = $name;
    }
  $massageinserted=$savemessage->save();
  if( $massageinserted){
    return response()->json(['success' => 'true','message' => 'message sent','data'=> $savemessage], 200);
  }
    }
////////get_chat_users
public function get_chat_users(Request $request){
    $validator = Validator::make($request->all(), [
        'to_id' => 'required',
    ]);

    if($validator->fails()){
        return $validator->errors();
    } 

    $users = ChMessage::where('to_id',"$request->to_id")->join('users', 'users.id', '=', 'ch_messages.from_id')->select('ch_messages.to_id','users.name as name','users.id as user_id',DB::raw("count(ch_messages.from_id) as count"))->groupBy('ch_messages.from_id')->get();
    return response()->json(['success' => 'true','message' => 'message of users','data'=> $users], 200);
}
////////get_messages
public function get_messages(Request $request){
    $validator = Validator::make($request->all(), [
        'to_from_id' => 'required',
    ]);

    if($validator->fails()){
        return $validator->errors();
    } 

    $users = ChMessage::where('to_id',"$request->to_from_id")->orWhere('from_id',"$request->to_from_id")->get();
    return response()->json(['success' => 'true','message' => 'get all messages','data'=> $users], 200);
}


public function fromuser(Request $request){
    $validator = Validator::make($request->all(), [
        'id' => 'required',
    ]);

    if($validator->fails()){
        return $validator->errors();
    } 
  
    $fromuser = ChMessage::where('from_id',"$request->id")->get();
    $to_users = ChMessage::where('to_id',"$request->id")->get();
    foreach($fromuser as $froms){
        $froms->from_id;
        foreach($to_users as $user_to){
           if($froms->from_id ==$user_to->to_id ) {
            echo "working";
           }

        }
    }
  
    return response()->json(['success' => 'true','message' => 'get all messages','data'=> $to_users], 200);
}
public function sendMesaage(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'from_id' => 'required',
        'to_id' => 'required',
        'body' => 'required'
    ]);

    if($validator->fails()){
        return $validator->errors();
    } 
		
		$input = $request->all();
        $from_id = $input['from_id'];
        $to_id = $input['to_id'];
		$body = $input['body'];
        $message_data = DB::table('ch_messages')->insert(
					array(
						'from_id'     =>  $from_id, 
						'to_id'   =>   $to_id,
						'body'             => $body,
                        'created_at'=> Date('Y-m-d H:i:s')
					)
				);

                $getUserName = User::where(['id' => $from_id])
                ->first();
            if(!empty($getUserName->name)){

            $name = $getUserName->name;
            }else{
             $name= "dummy name";
            }
            
            $message = $name. " you have new message";
            $notificationMessage = "you have new message";
            $insertNotification = DB::table('message_notifications')->insert(['user_id' =>$from_id, 'other_user_id' => $to_id, 'message' => $message, 'created_at' => date('Y-m-d H:i:s') , 'updated_at' => date('Y-m-d H:i:s'),'notify_message'=>$notificationMessage, ]);
            $notifyMessage = array(
                'sound' => 1,
                'message' => $message,
                
            );
            $message_new = array('sound' =>1,'message'=>$message,
                                'notifykey'=>'message','id'=>$from_id);
          

            $getotherUser = User::where(['id' => $to_id])->first();
            if (!empty($getotherUser->type) && !empty($getotherUser->device_token))
            {
                if ($getotherUser->device_type == '2')
                {
                    $this->send_android_notification($getotherUser->device_token,"send new message",'send new message',$message_new);
                }
                else
                {
                    $this->send_iphone_notification($getotherUser->device_token, $message, $notmessage ="accepted your post", $notifyMessage);
                }
            }
return response()->json(['success' => 'true','message' => 'messages sent Successfully'], 200);
		
	}
	public function getMessage(Request $request){
    $validator = Validator::make($request->all(), [
        'from_id' => 'required',
        'to_id' => 'required'
	
    ]);
  
   
    if($validator->fails()){
        return $validator->errors();
    } 
	
	 
    $message = chMessage::with('from_user')->with('to_user')->where('from_id',$request->from_id)
	->orWhere('to_id',$request->to_id)->get();
    // foreach ($message as $value) {
//$get_user_data = DB::table('users')->select('name')->where('id',$value->from_id)->orWhere('id',$value->to_id)->first();
	
	//$message->name =   $get_user_data->name;
	
	
//}   
	
	
    return response()->json(['success' => 'true','message' => 'get messages','data'=> $message], 200);
}
	public function getAllMessage(Request $request){
    $validator = Validator::make($request->all(), [
        'id' => 'required'
	
    ]);

    if($validator->fails()){
        return $validator->errors();
    } 

    $message = chMessage::with('from_user')->with('to_user')->where('from_id',$request->id)
	->orWhere('to_id',$request->id)->get();
    return response()->json(['success' => 'true','message' => 'get messages','data'=> $message], 200);
}
	public function getSingleMessage(Request $request){
    $validator = Validator::make($request->all(), [
        'id' => 'required'
	
    ]);

    if($validator->fails()){
        return $validator->errors();
    } 

  //  $message = chMessage::with('from_user')->with('to_user')->where('from_id',$request->id)
	//->orWhere('to_id',$request->id)->orderby('id','DESC')->first();
   // $get_message_detail = DB::table('ch_messages')->where('from_id',$request->id)
	//->orWhere('to_id',$request->id)->orderby('id','DESC')->get();
  

//dd($uniques);
   //   $message = array_merge($get_message_detail, $get_from_user_detail,$get_to_user_detail);
   // return response()->json(['success' => 'true','message' => 'get messages','data'=> $uniqueRecordsArray], 200);
    
 //   $conversations = DB::table('ch_messages')
									//->where('from_id', $request->id)
									
                                   //  ->groupBy('to_id')
                                   // ->orderby('id','DESC')
                                   // 
                                  //   ->get();
    
   // $unreadMessages = chMessage::select(DB::raw('t.*'))
         //   ->from(DB::raw('(SELECT * FROM ch_messages ORDER BY id DESC) t'))
          //  ->groupBy('t.to_id')    
         //  ->where('from_id', $request->id)
          //  ->get();
    $conversations = chMessage::where('from_id', $request->id)
    ->latest()
    ->get()
    ->unique('to_id');
    
    $mainarray = array();
    foreach($conversations as $value){
    	$userd = DB::table('users')->where('id',$value->to_id)->first();
    	if(isset($userd->name)){
        	$uname = $userd->name;
        }else{
        	$uname = 'N/A';
        }
    
    	if(isset($userd->profile_image)){
        	$uprofile = $userd->profile_image;
        }else{
        	$uprofile = 'N/A';
        }
    if($value->created_at == NULL){
    $created_at = 0;
    }else{
    $created_at = $value->created_at;
    }
    	//print_r($userd);
    	$mainarray[] = array('id'=>$value->id,
                           'from_id'=>$value->from_id,
                           'to_id'=>$value->to_id,
                           'body'=>$value->body,
                           'seen'=>$value->seen,
                           'created_at'=>$created_at,
                           'name'=>$uname,
                           'profile_image'=>$uprofile
                           );
    }
    
    
    
  //  $get_user_details = User::where('id',$value->to_id)->first();
   // $to_user['to_user'] = $get_user_details;
    //}
								//->orWhere('to_id', $request->id)
//	$to_user['to_user'] = $get_user_details;								
//$users = $conversations->map(function($conversation){
//	if($conversation->from_id === $request->id) {
	//	return $conversation->to_id;
	//}
//	return $conversation->from_id;
//})->unique();
    return response()->json(['success' => 'true','message' => 'get messages','data'=> $mainarray], 200);
    }
    

public function getSingleMessageNew(Request $request){
    $validator = Validator::make($request->all(), [
        'id' => 'required'
	
    ]);

    if($validator->fails()){
        return $validator->errors();
    } 




$latestMessages = DB::table('ch_messages')
    ->select(DB::raw('LEAST(from_id, to_id) AS user1, GREATEST(from_id, to_id) AS user2, MAX(created_at) AS max_created_at'))
    ->where(function($query) use($request){
        $query->where('from_id', $request->id)
              ->orWhere('to_id', $request->id);
    })
    ->groupBy('user1', 'user2');

$unreadMessages = DB::table('ch_messages')
    ->joinSub($latestMessages, 'latest_messages', function($join) {
        $join->on(function($query) {
            $query->whereColumn('ch_messages.from_id', '=', 'latest_messages.user1')
                  ->whereColumn('ch_messages.to_id', '=', 'latest_messages.user2')
                  ->orWhere(function($subquery) {
                      $subquery->whereColumn('ch_messages.from_id', '=', 'latest_messages.user2')
                              ->whereColumn('ch_messages.to_id', '=', 'latest_messages.user1');
                  });
        })
        ->whereColumn('ch_messages.created_at', '=', 'latest_messages.max_created_at');
    })
    ->orderBy('ch_messages.created_at', 'desc')
    ->select('ch_messages.*')
    ->get();

// $messages now contains the results




 $mainarray = array();
    foreach($unreadMessages as $value){
    	$userd = DB::table('users')->where('id',$value->to_id)->first();
    	if(isset($userd->name)){
        	$uname = $userd->name;
        }else{
        	$uname = 'N/A';
        }
    
    	if(isset($userd->profile_image)){
        	$uprofile = $userd->profile_image;
        }else{
        	$uprofile = 'N/A';
        }
    if($value->created_at == NULL){
    $created_at = 0;
    }else{
    $created_at = $value->created_at;
    }
    	//print_r($userd);
    	$mainarray[] = array('id'=>$value->id,
                           'from_id'=>$value->from_id,
                           'to_id'=>$value->to_id,
                           'body'=>$value->body,
                           'seen'=>$value->seen,
                           'created_at'=>$created_at,
                           'name'=>$uname,
                           'profile_image'=>$uprofile
                           );
    }
    
//$unreadMessages = chMessage::select('*')
   // ->where(function ($query) use ($request) {
       // $query->where('from_id', $request->id)
        //    ->orWhere('to_id', $request->id);
   // })
  //  ->orderBy('id', 'desc')
  //  ->orderBy('created_at', 'desc')
  //  ->groupBy('to_id', 'from_id')
  //  ->get();


//$unreadMessages = chMessage::select('*')
    //->fromSub(function ($query) use ($request) {
       // $query->select('*')
          //  ->from('ch_messages')
          //  ->where(function ($subquery) use ($request) {
             //   $subquery->where('from_id', $request->id)
                 //   ->orWhere('to_id', $request->id);
         //   })
         //   ->orderBy('id', 'desc') // Order by id in descending order
          ///  ->as('t');
   // }, 
   //'t')
    //->groupBy('t.to_id')
   // ->groupBy('t.from_id')
   // ->get();





    return response()->json(['success' => 'true','message' => 'get messages','data'=> $mainarray], 200);
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
   public function calculateBMI($weight, $height) {
        // Convert height from centimeters to meters
        $heightInMeters = $height / 100;
        
        // Calculate BMI
        $bmi = $weight / ($heightInMeters * $heightInMeters);
        
        return $bmi;
    }


   
            function send_android_notification($device_token,$message,$notmessage='',$msgsender_id=''){
                if (!defined('API_ACCESS_KEY'))
                {
                  define('API_ACCESS_KEY','AAAA5n__bPE:APA91bFUxUpjUoRST2x75kwR9OFnXEXdj6SrjRNoY-yqXFUm33unZF9hxaKdyqjupyJG7uAL390CTyrSEO1yyUYqy5PRck6SwezpDKs2IckdzQpRFUoBv3nMIX3teCzjSOxgJYXV8tfX');
                }
                $registrationIds = array($device_token);
                $fields = array(
                  'registration_ids' => $registrationIds,
                  'alert' => $message,
                  'sound' => 'default',
                  'Notifykey' => $notmessage, 
                  'data'=>$msgsender_id
                    
                );
                $headers = array(
                  'Authorization: key=' . API_ACCESS_KEY,
                  'Content-Type: application/json'
                );
            
                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                curl_setopt( $ch,CURLOPT_POST, true );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode($fields) );
                $result = curl_exec($ch);
            
                if($result == FALSE) {
                  die('Curl failed: ' . curl_error($ch));
                }
            
                curl_close( $ch );
                return  $result;
              }
            
            public static function send_iphone_notification($recivertok_id,$message,$notmessage='',$notfy_message){
                //$PATH = dirname(dirname(dirname(dirname(__FILE__))))."/pemfile/lens_development_push.pem";
                $PATH = dirname(dirname(dirname(dirname(__FILE__))))."/pemfile/apns-prod.pem";
                $deviceToken = $recivertok_id;  
                $passphrase = "";
                $message = $message;  
                $ctx = stream_context_create();
                     stream_context_set_option($ctx, 'ssl', 'local_cert', $PATH);
                     stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
                
                  $fp = stream_socket_client(
                            'ssl://gateway.sandbox.push.apple.com:2195', $err,
                $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx); 
                   
                  /*$fp = stream_socket_client(
                             'ssl://gateway.push.apple.com:2195', $err,
                 $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx); 
                  */
                $body['message'] = $message;
                $body['post_id'] = $notfy_message;
                $body['Notifykey'] = $notmessage;
                        if (!$fp)
                             exit("Failed to connect: $err $errstr" . PHP_EOL);
            
                    $body['aps'] = array(
                        'alert' => $message,
                        'sound' => 'default',
                        'details'=>$body
                    );
                       
                $payload = json_encode($body);
                $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
                $result = fwrite($fp, $msg, strlen($msg));
            
                //echo "<pre>";
                // print_r($result);
                // if (!$result)
                  // echo 'Message not delivered' . PHP_EOL;
                // else
                  // echo 'Message successfully delivered' . PHP_EOL;
                // exit;
                fclose($fp);
                return $result;
                die;
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
