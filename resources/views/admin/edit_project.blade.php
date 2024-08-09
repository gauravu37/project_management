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
                    <h1 class="h3 mb-2 text-gray-800">Update Project</h1>
                    <p class="mb-4"></p>
                    @if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
                    <!-- DataTales Example --->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Update Project</h6>
                           
                        </div>
                        <div class="card-body">
                        <form action="{{url('update-project')}}" method="POST">
                            @csrf
                        <input type="hidden" name="id" value="{{$editproject->id}}">
                            <!-- Input Field -->
                            <div class="form-group">
                                <label for="inputName">Project Name<span style="color:red;"> *</span></label>
                                <input type="text" class="form-control" id="inputName" name="project_name" value="<?php if($editproject->project_name){echo $editproject->project_name;}?>"  placeholder="Enter your project name" required>
                            </div>

                            <!-- Email Field -->
                            <div class="form-group">
                                <label for="inputEmail">Client Name</label>
                                <select name="client_name" class="form-control" id="cars" required>
                                    @foreach($client as $clients)
                                        <option value="{{ $clients->id }}" @if($clients->id == $editproject->client_name) selected @endif>
                                            {{ $clients->name }}
                                        </option>
                                    @endforeach
                                </select>                        
                              </div>
                              <div class="form-group">
                                <label for="inputEmail">Assign<span style="color:red;"> *</span></label>
                                <select name="assign" class="form-control" id="cars" required>
                                @foreach($user as $users)
                                @php
                                     $designation = App\Models\designation::where(['id' => $users->designation])->first();
                                     @endphp
                                <option value="{{$users->id}}" @if($users->id == $editproject->assign) selected @endif>{{$users->name}}({{$designation->designation_name}})</option>
                                @endforeach
                                </select>
                            </div>
                              <div class="form-group">
                                <label for="inputEmail">Upwork Url</label>
                                <input type="text" class="form-control" id="inputName" value="{{$editproject->upwork_url}}" name="upwork_url">

                            </div>
                            <div class="form-group">
                                <label for="inputEmail">Asana Url</label>
                                <input type="text" class="form-control" id="inputName" value="{{$editproject->asana_url}}" name="asana_url">

                            </div>
                            <div class="form-group">
                                <label for="inputEmail">Description</label>
                                <div id="editor-container" style="height: 200px;"></div>
                                <textarea id="editor-textarea" name="description" value="{{$editproject->description}}" style="display: none;">{!! $editproject->description !!}</textarea>

                            </div>

                            <div class="form-group">
                                <label for="inputEmail">Login Detail</label>
                                <div id="editor-containers" style="height: 200px;"></div>
                                <textarea id="editor-textareas" name="logindetail" value="{{$editproject->description}}"  style="display: none;">{!! $editproject->logindetail !!}</textarea>

                            </div>
                            <!-- Password Field -->
                            <div class="form-group">
                                <label for="inputPassword">Total Hours<span style="color:red;"> *</span></label>
                                <input type="text" class="form-control" id="inputPassword" name="total_hours" value="<?php if($editproject->total_hours){echo $editproject->total_hours;}?>" placeholder="hours" required>
                            </div>

                            <div class="form-group">
                                <label for="inputPassword">Payment<span style="color:red;"> *</span></label>
                                <input type="text" class="form-control" id="inputPassword" name="payment" value="<?php if($editproject->payment){echo $editproject->payment;}?>" placeholder="payment" required> 
                            </div>

                            <div class="form-group">
                                <label for="inputPassword">Deadline<span style="color:red;"> *</span></label>
                                <input type="date" class="form-control" id="inputPassword" name="deadline" value="<?php if($editproject->deadline){echo $editproject->deadline;}?>" placeholder="payment" required>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
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
                        <span>Copyright &copy; Your Website 2020</span>
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

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>

    <!-- Page level plugins -->
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>('
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
    var textarea = document.getElementById('editor-textareas');
    var editor = new Quill('#editor-containers', {
        theme: 'snow'  // 'snow' is the built-in theme (other themes are available)
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