<!DOCTYPE html>
<html lang="en">

<head>
@include('layout.head')


</head>

@include('layout.header')
<style>
    a.addproject {
  float: right;
  background-color: #4e73df;
  padding: 10px;
  border-radius: 19px;
  color: white;
  font-weight: 800;
}
</style>
                <!-- Begin Page Contentt -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">View Project</h1>
                    <p class="mb-4"></p>
                    @if (session()->has('success'))
    <div class="alert alert-success" id="success-alert">
        {{ session('success') }}
    </div>
    
    <script>
        setTimeout(function() {
            let successAlert = document.getElementById('success-alert');
            if (successAlert) {
                successAlert.style.display = 'none';
            }
        }, 10000); // 10 seconds delay before hiding the alert
    </script>
@endif
                    <!-- DataTales Example --->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                        <ul class="nav nav-tabs" id="patientTabs" role="tablist">

                        <li class="nav-item" role="presentation">
              <a class="nav-link tablinks tab-button active" id="home-tab" onclick="openTab(event, 'Tab1')" type="button" >View Project</a>
            </li>
          
            <li class="nav-item" role="presentation">
              <a class="nav-link tablinks tab-button" id="profile-tab" onclick="openTab(event, 'Tab2')" type="button" >Task detail</a>
            </li>

                        
           
          </ul>
                           
                        </div>

                        <div id="Tab1" class="tab-content">
                            <div class="card-body">
                        
                       
                            <!-- Input Field -->
                            <div class="form-group">
                                <label for="inputName">Project Name</label>
                                <input type="text" class="form-control" id="inputName" name="project_name" value="<?php if($view_project->project_name){echo $view_project->project_name;}?>"  placeholder="Enter your project name" readonly>
                            </div>

                            <!-- Email Field -->
                            <div class="form-group">
                                <label for="inputEmail">Client Name</label>
                                <select name="client_name" class="form-control" id="cars" disabled>
                                    @foreach($client as $clients)
                                        <option value="{{ $clients->id }}" @if($clients->id == $view_project->client_name) selected @endif>
                                            {{ $clients->name }}
                                        </option>
                                    @endforeach
                                </select>                        
                              </div>
                              <div class="form-group">
                                <label for="inputEmail">Assign</label>
                                <select name="assign" class="form-control" id="cars" disabled>
                                @foreach($user as $users)
                                <option value="{{$users->id}}" @if($users->id == $view_project->assign) selected @endif>{{$users->name}}({{$users->designation}})</option>
                                @endforeach
                                </select>
                            </div>

                            <!-- Password Field -->
                            <div class="form-group">
                                <label for="inputPassword">Total Hours</label>
                                <input type="text" class="form-control" id="inputPassword" name="total_hours" value="<?php if($view_project->total_hours){echo $view_project->total_hours;}?>" placeholder="hours" readonly>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword">Payment</label>
                                <input type="text" class="form-control" id="inputPassword" name="payment" value="<?php if($view_project->payment){echo $view_project->payment;}?>" placeholder="payment" readonly>
                            </div>
 
                            <div class="form-group">
                                <label for="inputPassword">Deadline</label>
                                <input type="date" class="form-control" id="inputPassword" name="deadline" value="<?php if($view_project->deadline){echo $view_project->deadline;}?>" placeholder="payment" readonly>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword">Upwork Url</label>
                                <input type="text" class="form-control" id="inputPassword" name="upwork_url" value="<?php if($view_project->upwork_url){echo $view_project->upwork_url;}?>" placeholder="payment" readonly>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword">Asana Url</label>
                                <input type="text" class="form-control" id="inputPassword" name="asana_url" value="<?php if($view_project->asana_url){echo $view_project->asana_url;}?>" placeholder="payment" readonly>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail">Development Url</label>
                                <input type="text" class="form-control" id="inputName" value="<?php if($view_project->development_url){echo $view_project->development_url;}?>" name="development_url" readonly>

                            </div>
                            <div class="form-group">
                                <label for="inputEmail">Live Url</label>
                                <input type="text" class="form-control" id="inputName" value="<?php if($view_project->live_url){echo $view_project->live_url;}?>" name="live_url" readonly>

                            </div>

                            <div class="form-group">
                                <label for="inputStatus">Status</label>
                                <select class="form-control" id="inputStatus" name="status" disabled>
                                    <option value="1" {{ $view_project->status == 1 ? 'selected' : '' }}>Not Started</option>
                                    <option value="2" {{ $view_project->status == 2 ? 'selected' : '' }}>In Progress</option>
                                    <option value="3" {{ $view_project->status == 3 ? 'selected' : '' }}>Testing</option>
                                    <option value="4" {{ $view_project->status == 4 ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail">Description</label>
                                <div id="editor-container" style="height: 200px;"></div>
                                <textarea id="editor-textarea" name="description" value="{{$view_project->description}}" style="display: none;" readonly>{!! $view_project->description !!}</textarea>

                            </div>

                            <div class="form-group">
                                <label for="inputEmail">Login Detail</label>
                                <div id="editor-containers" style="height: 200px;"></div>
                                <textarea id="editor-textareas" name="logindetail" value="{{$view_project->description}}"  style="display: none;"readonly>{!! $view_project->logindetail !!}</textarea>

                            </div>


                            <!-- Submit Button -->
                           
                            </div>
                        </div>

                        <div id="Tab2" class="tab-content">
    <div class="card-body">
        <ul>
            @foreach($task as $tasks)
                <li>{{ $tasks->task_title }}</li>
            @endforeach
        </ul>
    </div>
</div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Your Website <?php echo date('Y'); ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <script>
function openTab(evt, tabName) {
    // Declare all variables
    var i, tabcontent, tabbuttons;

    // Get all elements with class="tab-content" and hide them
    tabcontent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tab-button" and remove the class "active"
    tabbuttons = document.getElementsByClassName("tab-button");
    for (i = 0; i < tabbuttons.length; i++) {
        tabbuttons[i].className = tabbuttons[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Set the default tab to open
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector('.tab-button').click();
});


</script>
    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>

    <!-- Page level plugins -->
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <!-- Page level custom scripts -->
    <script src="{{asset('assets/js/demo/datatables-demo.js')}}"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
    var textarea = document.getElementById('editor-textarea');
    var editor = new Quill('#editor-container', {
        theme: 'snow',
        readOnly: true   // 'snow' is the built-in theme (other themes are available)
    });
    
    // Set initial content if textarea has content
    editor.root.innerHTML = textarea.value;
    
    // Update textarea on editor change
    editor.on('text-change', function(delta, oldDelta, source) {
        textarea.value = editor.root.innerHTML;
    });
</script>

<script>
    var textarea = document.getElementById('editor-textareas');
    var editor = new Quill('#editor-containers', {
        theme: 'snow',
        readOnly: true   // 'snow' is the built-in theme (other themes are available)
    });
    
    // Set initial content if textarea has content
    editor.root.innerHTML = textarea.value;
    
    // Update textarea on editor change
    editor.on('text-change', function(delta, oldDelta, source) {
        textarea.value = editor.root.innerHTML;
    });
</script>
</body>

</html>