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
<meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                <!-- Begin Page Contentt -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Task Detail</h1>
                    <p class="mb-4"></p>
                    @if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Task Detail</h6>
                           
                        </div>
                        <div class="card-body">
                      
                           
                        <form action="{{url('add-task-start-time')}}" method="POST">
                        @csrf
                        <input type="hidden" id="project_id" name="project_id" value="{{$taskdetail->project_id}}">
                        <input type="hidden" id="task_id" name="task_id" value="{{$taskdetail->id}}">
                            <!-- Input Field -->
                            <div class="form-group">
                                <label for="inputName">Project Name</label>
                                <input type="text" class="form-control" id="inputName" value="{{$taskdetail->project_name}}" name="task_title" readonly>
                       
                            </div>

                            <div class="form-group">
                                <label for="inputEmail" readonly>Project Login Detail</label>
                                <div id="editor-containers" style="height: 200px;"></div>
                                <textarea id="editor-textareas" name="logindetail" value="{{$taskdetail->logindetail}}"  style="display: none;" readonly>{!! $taskdetail->logindetail !!}</textarea>

                            </div>
                            <!-- Email Field -->
                            <div class="form-group">
                                <label for="inputEmail" >Task Title</label>
                                <input type="text" class="form-control" id="inputName" value="{{$taskdetail->task_title}}" name="task_title" readonly>

                            </div>

                            <div class="form-group">
                                <label for="inputEmail" readonly>Task Description</label>
                                <div id="editor-container" style="height: 200px;"></div>
                                <textarea id="editor-textarea" name="description" value="{{$taskdetail->description}}" style="display: none;" readonly>{!! $taskdetail->description !!}</textarea>

                            </div>

                            

                            <!-- Password Field -->
                            <div class="form-group">
                                <label for="inputPassword">Total Hours</label>
                                <input type="text" class="form-control" id="inputPassword" value="{{$taskdetail->total_hours}}" name="total_hours" placeholder="hours" readonly>
                            </div>

                            

                            <div class="form-group">
                                <label for="inputPassword">Deadline</label>
                                <input type="date" class="form-control" id="inputPassword" value="{{$taskdetail->deadline}}" name="deadline" placeholder="Deadline" readonly>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Start Time</button>
                            <a id="ajax-button">End time</a>

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

<script type="text/javascript">
        $(document).ready(function() {
            $('#ajax-button').click(function() {
                var project_ids = document.getElementById("project_id");
                 var project_id = project_ids.value;
                 var task_ids = document.getElementById("task_id");
                 var task_id = task_ids.value;

                $.ajax({
                    url: "{{ route('task-end-time') }}",
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        project_id: project_id,
                        task_id: task_id
                    },
                    success: function(response) {
                       alert(response);
                        if(response.success) {
                            alert('AJAX request successful!');
                        }
                    },
                    error: function(response) {
                        console.log(response);
                        alert('AJAX request failed!');
                    }
                });
            });
        });
    </script>

</body>

</html>