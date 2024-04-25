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
                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Project Management</h1>
                    <p class="mb-4"></p>
                    @if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-4">
                            <h6 class="m-0 font-weight-bold text-primary">Project Management <a href="{{url('add-project')}}" class="addproject">Add Project</a></h6>
                           
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Project Name</th>
                                            <th>Client Name</th>
                                            <th>Total Hours</th>
                                            <th>Payment</th>
                                            <th>Action</th>
                                         </tr>
                                    </thead>
                                   
                                    <tbody>
                                       @php $i=0; @endphp
                                        @foreach($project_management as $project_managements) 
                                        @php $i++; @endphp
                                       <tr>
                                            <td>{{$i}}</td>
                                            <td>{{$project_managements->project_name}}</td>
                                            <td>{{$project_managements->client_name}}</td>
                                            <td>{{$project_managements->total_hours}}</td>
                                            <td>{{$project_managements->payment}}</td>
                                           <td> 
                                            <a href="{{url('edit-project/'.$project_managements->id)}}" class="btn btn-info btn-circle">
                                            <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{url('delete-project/'.$project_managements->id)}}" class="btn btn-info btn-circle">
                                            <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                        </tr>
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

</body>

</html>