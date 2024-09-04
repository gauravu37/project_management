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
                    <h1 class="h3 mb-2 text-gray-800">Add Project</h1>
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
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Add Project</h6>
                           
                        </div>
                        <div class="card-body">
                        <form action="{{url('addproject')}}" method="POST">
                            @csrf <!-- CSRF Protection -->

                            <!-- Input Field -->
                            <div class="form-group">
                                <label for="inputName">Project Name <span style="color:red;"> *</span></label>
                                <input type="text" class="form-control" id="inputName" name="project_name" placeholder="Enter your project name" required>
                            </div>

                            <!-- Email Field -->
                            <div class="form-group">
                                <label for="inputEmail">Client Name</label>
                                <select name="client_name" class="form-control" id="cars">
                                @foreach($client as $clients)
                                <option value="{{$clients->id}}">{{$clients->name}}</option>
                                @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail">Assign <span style="color:red;"> *</span></label>
                                <select id="choices-multiple-remove-button" name="assign[]" class="form-control inpt" id="cars" multiple>
                                @foreach($user as $users)
                                    @php
                                     $designation = App\Models\designation::where(['id' => $users->designation])->first();
                                     @endphp
                                   
                                <option value="{{$users->id}}">{{$users->name}}({{$designation->designation_name}})</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail">Upwork Url</label>
                                <input type="text" class="form-control" id="inputName" value="" name="upwork_url">

                            </div>
                            <div class="form-group">
                                <label for="inputEmail">Asana Url</label>
                                <input type="text" class="form-control" id="inputName" value="" name="asana_url">

                            </div>
                            <div class="form-group">
                                <label for="inputEmail">Development Url</label>
                                <input type="text" class="form-control" id="inputName" value="" name="development_url">

                            </div>
                            <div class="form-group">
                                <label for="inputEmail">Live Url</label>
                                <input type="text" class="form-control" id="inputName" value="" name="live_url">

                            </div>
                            <div class="form-group">
                                <label for="inputStatus">Status</label>
                                <select class="form-control" id="inputStatus" name="status">
                                    <option value="1">Not Started</option>
                                    <option value="2">In Progress</option>
                                    <option value="3">Testing</option>
                                    <option value="4">Completed</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail">Description</label>
                                <div id="editor-container" style="height: 200px;"></div>
                                <textarea id="editor-textarea" name="description" style="display: none;"></textarea>

                            </div>

                            <div class="form-group">
                                <label for="inputEmail">Login Detail</label>
                                <div id="editor-containers" style="height: 200px;"></div>
                                <textarea id="editor-textareas" name="logindetail" style="display: none;"></textarea>

                            </div>

                            <!-- -Password Field -->
                            <div class="form-group">
                                <label for="inputPassword">Total Hours <span style="color:red;"> *</span></label>
                                <input type="text" class="form-control" id="inputPassword" name="total_hours" placeholder="hours" required>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword">Payment <span style="color:red;"> *</span></label>
                                <input type="text" class="form-control" id="inputPassword" name="payment" placeholder="payment" required>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword">Deadline <span style="color:red;"> *</span></label>
                                <input type="date" class="form-control" id="inputPassword" name="deadline" placeholder="Deadline" required>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content --->

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
        theme: 'snow'  // 'snow' is the built-in theme (other themes are available)
    });
    
    // Set initial content if textarea has content
    editor.root.innerHTML = textarea.value;
    
    // Update textarea on editor change
    editor.on('text-change', function(delta, oldDelta, source) {
        textarea.value = editor.root.innerHTML;
    });
</script>

<script>
    var textareas = document.getElementById('editor-textareas');
    var editors = new Quill('#editor-containers', {
        theme: 'snow'  // 'snow' is the built-in theme (other themes are available)
    });
    
    // Set initial content if textarea has content
    editors.root.innerHTML = textareas.value;
    
    // Update textarea on editor change
    editors.on('text-change', function(delta, oldDelta, source) {
        textareas.value = editor.root.innerHTML;
    });
</script>
</body>

</html>