<!DOCTYPE html>
<html lang="en">

<head>
@include('layout.head')
</head>

@include('layout.header')

                <!-- Begin Page Contentt -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Apply Leave </h1> 
                    @if(session()->has('leavemessage'))
    <div class="alert alert-success">
        {{ session()->get('leavemessage') }}
    </div>
@endif
                    <p class="mb-4"></p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                     <div class="row row justify-content-center">
                        <div class="col-lg-6 p-5">
                        <form class="user" action="{{ route('user/leave') }}" method="POST">
                            @csrf
                             <div class="form-group">
                                            <label> Title </label>
                                            <input type="text" class="form-control form-control-user"
                                                id="title" name="title" aria-describedby="emailHelp"
                                                placeholder="Title">
                                                @if ($errors->has('title'))
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                                @endif
                                        </div>
                                        <div class="form-group">
                                        <label> Date </label>
                                            <input type="text" name="date" class="form-control form-control-user"
                                                id="datepicker">
                                                
                                                @if ($errors->has('date'))
                                <span class="text-danger">{{ $errors->first('date') }}</span>
                                @endif
                                        </div>
                                        <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Reason</label>
                                        <textarea class="form-control" id="reason" name="reason" rows="3"></textarea>
                                        @if ($errors->has('reason'))
                                <span class="text-danger">{{ $errors->first('reason') }}</span>
                                @endif    
                                    </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Submit</button>

                                        <hr>
                            </form>
                        </div>
                    </div>
                        <div class="card-body">
                            
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
    
    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{asset('assets/js/sb-admin-2.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('assets/js/demo/datatables-demo.js')}}"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <script>
  $(function() {
    $("#datepicker").datepicker({
      minDate: 0 // Prevent past dates
    });
  });
</script>

</body>

</html>