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
                    <h1 class="h3 mb-2 text-gray-800">Edit Client</h1>
                    <p class="mb-4"></p>
                    @if (session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
                    <!-- DataTales Example --->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Edit Client</h6>
                           
                        </div>
                        <div class="card-body">
                        <form action="{{url('update-client-detail')}}" method="POST">
                            @csrf <!-- CSRF Protection -->
                            <input type="hidden" value="{{$editclient->id}}" name="id">
                            <!-- Input Field -->
                            <div class="form-group">
                                <label for="inputName"> Name</label>
                                <input type="text" class="form-control" id="inputName" name="name" value="{{$editclient->name}}" required>
                            </div>

                            <div class="form-group">
                                <label for="inputName"> Email</label>
                                <input type="text" class="form-control" id="inputName" name="email" value="{{$editclient->email}}" required>
                            </div>


                            <div class="form-group">
                                <label for="inputName"> Contact</label>
                                <input type="text" class="form-control" id="inputName" name="contact" value="{{$editclient->contact}}" required>
                            </div>

                            <div class="form-group">
                                <label for="inputName"> Facebook Id</label>
                                <input type="text" class="form-control" id="inputName" name="facebook_id" value="{{$editclient->facebook_id}}" >
                            </div>

                            <div class="form-group">
                                <label for="inputName"> Instagram Id</label>
                                <input type="text" class="form-control" id="inputName" name="instagram_id" value="{{$editclient->instagram_id}}" >
                            </div>

                            <div class="form-group">
                                <label for="inputName"> Skype Id</label>
                                <input type="text" class="form-control" id="inputName" name="skype_id" value="{{$editclient->skype_id}}" >
                            </div>

                            <div class="form-group">
                                <label for="inputName"> Telegram</label>
                                <input type="text" class="form-control" id="inputName" name="telegram_id" value="{{$editclient->telegram_id}}" >
                            </div>

                            <div class="form-group">
                                <label for="inputName"> Upwork Id</label>
                                <input type="text" class="form-control" id="inputName" name="upwork_id" value="{{$editclient->upwork_id}}" >
                            </div>
                            <div class="form-group">
                                <label for="inputName"> Project Url</label>
                                <input type="text" class="form-control" id="inputName" name="project_url" value="{{$editclient->v}}" >
                            </div>
                            <div class="form-group">
                                <label for="inputName"> Assana</label>
                                <input type="text" class="form-control" id="inputName" name="assana" value="{{$editclient->assana}}" >
                            </div>
                            <!-- Email Field -->
                            <div class="form-group">
                                <label for="inputEmail">Whatsapp</label>
                                <input type="text" class="form-control" id="inputEmail" name="whatsapp" value="{{$editclient->whatsapp}}" >
                            </div>
                            

                            <!-- Password Field -->
                           

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Submit</button>
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

</body>

</html>