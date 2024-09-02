<!DOCTYPE html>
<html lang="en">

<head>
@include('layout.head')
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style>
    .main { 
    background-color: #fff; 
    border-radius: 15px; 
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2); 
    padding: 10px 20px; 
    transition: transform 0.2s; 
    width: 500px; 
    height: 400px; 
    text-align: center; 
} 
  
.timer-circle { 
    border-radius: 50%; 
    width: 200px; 
    height: 200px; 
    margin: 20px auto; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    font-size: 25px; 
    color: crimson; 
    border: 8px solid #3498db; 
} 
  
.control-buttons { 
    margin-top: 75px; 
    display: flex; 
    justify-content: space-evenly; 
} 
  
.control-buttons button { 
    background-color: #3498db; 
    color: #fff; 
    border: none; 
    padding: 10px 20px; 
    border-radius: 5px; 
    cursor: pointer; 
} 
  
.control-buttons button:hover { 
    background-color: #266094; 
    transition: background-color 0.3s; 
}
</style>
@include('layout.header')

                <!-- Begin Page Contentt -->
                <div class="container-fluid">

                        <!-- Page Heading -->
                        <h1 class="h3 mb-2 text-gray-800">Profile</h1>
                        <p class="mb-4"></p>

                        <!-- DataTales Example -->
                        <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Update Profile</h6>
                                </div>
                                @if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
                                <div class="card-body">
                                    <form action="{{ route('user/profile-update') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                           
                                                    <div class="form-group">
                                                        <label for="inputName"> Name</label>
                                                        <input type="text" class="form-control" name="name" id="name" value="<?php if($userdetail->name){echo $userdetail->name; }else{ echo " ";}?>" class="form-control form-control-lg" requried />
                                            
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="inputEmail" readonly>Email</label>
                                                    
                                                        <input type="email" class="form-control" name="email" value="<?php if($userdetail->email){echo $userdetail->email; }else{ echo " ";}?>"  id="emailAddress" class="form-control form-control-lg" requried />

                                                    </div>
                                                    <!-- Email Field -->
                                                    <div class="form-group">
                                                        <label for="inputEmail" >Phone</label>
                                                        <input type="tel" class="form-control" id="phoneNumber" name="phone" value="<?php if($userdetail->phone){echo $userdetail->phone; }else{ echo " ";}?>" class="form-control form-control-lg" requried/>

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputPassword">Image</label>
                                                        <input type="file" name="image" class="" id="image" requried/><br>  
                                                        <?php 
                                                                                $userId = Auth::id();
                                                                                $userdetail = App\Models\User::where(['id' => $userId])->first();?>
                                                                                @if($userdetail->image)
                                                                                    <img class="img-profile rounded-circle" width="100" height="100"
                                                                                        src="{{asset('user_profile/'.$userdetail->image)}}">
                                                                                @endif              
                                                    </div>

                                                    <!-- Submit Button -->
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                    

                                                   </form>

                                                    

                                               
                                    
                            </div>
                        </div>
                </div>
         <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Your Website <?php echo date('Y'); ?></span>
                    </div>
                </div>
            </footer>
        </div>
    </div>  
</body>

</html>