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
                                <div class="card-body">
                                   
                                    <section class="vh-100 gradient-custom">
                                        <div class="container py-5 h-100">
                                            <div class="row justify-content-center align-items-center h-100">
                                            <div class="col-12 col-lg-9 col-xl-7">
                                                <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                                                <div class="card-body p-4 p-md-5">
                                                  
                                                    <form action="{{ route('user/profile-update') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="row">
                                                        <div class="col-md-6 mb-4">

                                                        <div data-mdb-input-init class="form-outline">
                                                        <label class="form-label" for="firstName">First Name</label>
                                                            <input type="text" name="name" id="name" value="<?php if($userdetail->name){echo $userdetail->name; }else{ echo " ";}?>" class="form-control form-control-lg" requried />
                                                           
                                                        </div>

                                                        </div>
                                                        <div class="col-md-6 mb-4">

                                                        <div data-mdb-input-init class="form-outline">
                                                        <label class="form-label" for="lastName">Last Name</label>
                                                            <input type="text" id="lastName" class="form-control form-control-lg" />
                                                            
                                                        </div>

                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 mb-4 d-flex align-items-center">

                                                        <div data-mdb-input-init class="form-outline datepicker w-100">
                                                        <label for="birthdayDate" class="form-label">Birthday</label>
                                                            <input type="text" class="form-control form-control-lg" id="birthdayDate" />
                                                           
                                                        </div>

                                                        </div>
                                                        <div class="col-md-6 mb-4">

                                                        <h6 class="mb-2 pb-1">Gender: </h6>

                                                        <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="femaleGender">Female</label>
                                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="femaleGender"
                                                            value="option1" checked />
                                                           
                                                        </div>

                                                        <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="maleGender">Male</label>
                                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="maleGender"
                                                            value="option2" />
                                                           
                                                        </div>

                                                        <div class="form-check form-check-inline">
                                                        <label class="form-check-label" for="otherGender">Other</label>
                                                            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="otherGender"
                                                            value="option3" />
                                                           
                                                        </div>

                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 mb-4 pb-2">

                                                        <div data-mdb-input-init class="form-outline">
                                                        <label class="form-label" for="emailAddress">Email</label>
                                                            <input type="email" name="email" value="<?php if($userdetail->email){echo $userdetail->email; }else{ echo " ";}?>"  id="emailAddress" class="form-control form-control-lg" requried />
                                                            
                                                        </div>

                                                        </div>
                                                        <div class="col-md-6 mb-4 pb-2">

                                                        <div data-mdb-input-init class="form-outline">
                                                        <label class="form-label" for="phoneNumber">Phone Number</label>
                                                            <input type="tel" id="phoneNumber" name="phone" value="<?php if($userdetail->phone){echo $userdetail->phone; }else{ echo " ";}?>" class="form-control form-control-lg" requried/>
                                                           
                                                        </div>

                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-12">
                                                             <label class="form-label select-label">Image upload</label>
                                                             <input type="file" name="image" class="" id="image" requried/>
                                                        </div>
                                                        <?php 
                                                        $userId = Auth::id();
                                                        $userdetail = App\Models\User::where(['id' => $userId])->first();?>
                                                        @if($userdetail->image)
                                                            <img class="img-profile rounded-circle" width="100" height="100"
                                                                src="{{asset('user_profile/'.$userdetail->image)}}">
                                                        @endif

                                                    </div>

                                                    <div class="mt-4 pt-2">
                                                        <input data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg" type="submit" value="Submit" />
                                                    </div>

                                                    </form>
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                    </section>
                                    
                            </div>
                        </div>
                </div>
         <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>  
</body>

</html>