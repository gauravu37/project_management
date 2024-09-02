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
                    <h1 class="h3 mb-2 text-gray-800">Add Finance</h1>
                    <p class="mb-4"></p>
                    @if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Add Finance</h6>
                           
                        </div>
                        <div class="card-body">
                        <form action="{{url('add')}}" method="POST">
    @csrf <!-- CSRF Protection -->

    <!-- Date Field -->
    <div class="form-group">
        <label for="inputPassword">Date <span style="color:red;"> *</span></label>
        <input type="date" class="form-control" id="inputPassword" name="date" placeholder="Deadline" required>
    </div>

    <!-- Project Name Field -->
    <div class="form-group">
        <label for="inputEmail">Project Name<span style="color:red;"> *</span></label>
        <select name="project_name" class="form-control" id="cars">
            @foreach($project as $projects)
            <option value="{{$projects->id}}">{{$projects->project_name}}</option>
            @endforeach
        </select>
    </div>

    <!-- Amount Field -->
    <div class="form-group">
        <label for="inputEmail">Amount<span style="color:red;"> *</span></label>
        <input type="text" class="form-control" id="amount" name="amount">
    </div>

    <!-- TDS Deduct Field -->
    <div class="form-group">
        <label for="inputPassword">TDS Deduct </label>
        <input type="checkbox" class="form-controls" id="tds_deduct" name="tds_deduct">
    </div>
    <div class="form-group">
        <label for="inputPassword">GST Recieved</label>
        <input type="checkbox" class="form-controls" id="gst_recieved" name="gst_recieved">
    </div>
    <!-- Actual Amount Field -->
    <div class="form-group">
        <label for="inputEmail">Actual Amount</label>
        <input type="text" class="form-control" id="actual_amount" name="actual_amount" readonly>
    </div>

    <!-- GST Received Field -->
  
    <!-- Invoice Number Field -->
    <div class="form-group">
        <label for="inputEmail">Invoice Number<span style="color:red;"> *</span></label>
        <input type="text" class="form-control" id="inputName" name="invoice_number">
    </div>

    <!-- Invoice Amount Field -->
    <div class="form-group">
        <label for="inputEmail">Invoice Amount<span style="color:red;"> *</span></label>
        <input type="text" class="form-control" id="inputName" name="invoice_amount">
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tds_deduct').change(function() {
            var amount = parseFloat($('#amount').val()) || 0;
            if ($(this).is(':checked')) {
                var tdsAmount = amount * 0.95; // Deduct 5%
                $('#actual_amount').val(tdsAmount.toFixed(2));
            } else {
                $('#actual_amount').val(amount.toFixed(2));
            }
        });

        // Optional: Automatically calculate when amount changes if checkbox is already checked
        $('#amount').on('input', function() {
            if ($('#tds_deduct').is(':checked')) {
                $('#tds_deduct').trigger('change');
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        function calculateActualAmount() {
            var amount = parseFloat($('#amount').val()) || 0;
            var tdsDeductedAmount = amount;
            var gstAddedAmount = 0;

            if ($('#tds_deduct').is(':checked')) {
                tdsDeductedAmount = amount * 0.95; // Deduct 5% for TDS
            }

            if ($('#gst_recieved').is(':checked')) {
                gstAddedAmount = amount * 0.18; // Add 18% for GST
            }

            var actualAmount = tdsDeductedAmount + gstAddedAmount;
            $('#actual_amount').val(actualAmount.toFixed(2));
        }

        $('#tds_deduct, #gst_recieved').change(function() {
            calculateActualAmount();
        });

        // Optional: Automatically calculate when amount changes if checkboxes are already checked
        $('#amount').on('input', function() {
            calculateActualAmount();
        });
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