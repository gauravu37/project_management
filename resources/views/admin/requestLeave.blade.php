<!DOCTYPE html>
<html lang="en">

<head>
@include('layout.head')
</head>

@include('layout.header')

                <!-- Begin Page Contentt -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Request Leaves</h1>
                    <p class="mb-4"></p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Request Leaves</h6>
                        </div>

            @if (session('status'))
                <h6 class="alert alert-success">{{ session('status') }}</h6>
            @endif
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Name</th>
                                            <th>Title</th>
                                            <th>Date</th>
                                            <th>Reason</th>
                                            <th>Action</th>
                                         </tr>
                                    </thead>
                                  
                                    <tbody>
                                       @php $i=0; @endphp
                                        @foreach($user as $users) 
                                        @php $i++; @endphp
                                       <tr>
                                            <td>{{$i}}</td>
                                        @php $userdetail = App\Models\User::where(['id' => $users->user_id])->first(); @endphp
                                            <td>{{$userdetail->name}}</td>
                                            <td>{{$users->title}}</td>
                                            <td>{{$userdetail->email}}</td>
                                             <td>{{$users->reason}}</td>
                                           <td>
                                            <a title="Accept" href="{{url('admin/accept-leave/'.$users->id)}}" class="">
                                           <i class="fa fa-check" style="color:green;" aria-hidden="true"></i>
                                            </a>
                                            <a title="Reject" href="#" class="" data-toggle="modal" data-target="#rejectModal<?php echo $users->id; ?>">
                                          <i style="color:red;" class="fa fa-times" aria-hidden="true"></i>
                                            </a>
                                        </td>
                                        </tr>


                                        <div class="modal fade" id="rejectModal<?php echo $users->id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('leave/reject') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Reason</h5>
                                                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">×</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id" value="<?php echo $users->id; ?>">
                                                            <textarea name="rejectreason" value="" class="form-control form-control-lg" required>  </textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                                            <input data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg" type="submit" value="Submit" />
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>



                                       @endforeach 
                                    </tbody>
                                </table>
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

</body>

</html>