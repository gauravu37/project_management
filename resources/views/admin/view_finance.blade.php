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
                    <h1 class="h3 mb-2 text-gray-800">View Finance</h1>
                    <p class="mb-4"></p>
                    @if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">View Finance</h6>
                           
                        </div>
                        <div class="card-body">
                        <form action="#" method="POST">
    @csrf <!-- CSRF Protection -->
    @csrf
  
   
    <!-- Date Field -->
    <div class="form-group">
        <label for="inputPassword">Date </label>
        <input type="date" class="form-control" id="inputPassword" name="date" value="{{$updatefinance->date}}" placeholder="Deadline" readonly>
    </div>

    <!-- Project Name Field -->
    <div class="form-group">
        <label for="inputEmail">Project Name </label>
        @php 
        $projectName = App\Models\project_management::where(['id' => $updatefinance->project_name])->first();
        @endphp
        <input type="text" class="form-control" id="inputPassword" name="date" value="{{$projectName->project_name}}" placeholder="Deadline" readonly>
    </div>

    <!-- Amount Field -->
    <div class="form-group">
        <label for="inputEmail">Amount</label>
        <input type="text" class="form-control" id="amount" name="amount" value="{{$updatefinance->amount}}" readonly>
    </div>

    <!-- TDS Deduct Field -->
    <div class="form-group">
    <label for="tds_deduct">TDS Deduct</label>
    <input type="checkbox" class="form-controls" id="tds_deduct" name="tds_deduct" 
           {{ $updatefinance->tds_deduct ? 'checked' : '' }}>
</div>

<div class="form-group">
    <label for="gst_recieved">GST Received</label>
    <input type="checkbox" class="form-controls" id="gst_recieved" name="gst_recieved" 
           {{ $updatefinance->gst_recieved ? 'checked' : '' }}>
</div>

    <!-- Actual Amount Field -->
    <div class="form-group">
        <label for="inputEmail">Actual Amount</label>
        <input type="text" class="form-control" id="actual_amount" name="actual_amount" 
               value="{{$updatefinance->actual_amount}}" readonly>
    </div>

    <!-- Invoice Number Field -->
    <div class="form-group">
        <label for="inputEmail">Invoice Number </label>
        <input type="text" class="form-control" id="inputName" name="invoice_number" value="{{$updatefinance->invoice_number}}" readonly>
    </div>

    <!-- Invoice Amount Field -->
    <div class="form-group">
        <label for="inputEmail">Invoice Amount</label>
        <input type="text" class="form-control" id="inputName" name="invoice_amount" value="{{$updatefinance->invoice_amount}}" readonly>
    </div>

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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   
 <script>
    $(document).ready(function() {
        $('#tds_deduct').prop('disabled', true);
        $('#gst_recieved').prop('disabled', true);
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