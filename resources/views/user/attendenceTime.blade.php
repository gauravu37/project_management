<!DOCTYPE html>
<html lang="en">

<head>
@include('layout.head')
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style>
    .main { 
    background-color: #fff; 
    border-radius: 15px; 
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.2); 
    padding: 10px 20px; 
    transition: transform 0.2s; 
    width: 500px; 
    height: 400px; 
    text-align: center; 
} 
  
.timer-circle { 
    border-radius: 50%; 
    width: 200px; 
    height: 200px; 
    margin: 20px auto; 
    display: flex; 
    align-items: center; 
    justify-content: center; 
    font-size: 25px; 
    color: crimson; 
    border: 8px solid #3498db; 
} 
  
.control-buttons { 
    margin-top: 75px; 
    display: flex; 
    justify-content: space-evenly; 
} 
  
.control-buttons button { 
    background-color: #3498db; 
    color: #fff; 
    border: none; 
    padding: 10px 20px; 
    border-radius: 5px; 
    cursor: pointer; 
} 
  
.control-buttons button:hover { 
    background-color: #266094; 
    transition: background-color 0.3s; 
}
</style>
@include('layout.header')

                <!-- Begin Page Contentt -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Attendence Time</h1>
                    <p class="mb-4"></p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Attendence Time</h6>
                        </div>
                          <div class="card-body">
                            <div class="table-responsive">
                            <div class="main"> 
                            <!-- <div class="timer-circle" 
                                id="timer">00:00:00
                            </div>  -->
                           
                            <button  id="startBtn">Start</button>
                            <!-- <button id="pauseBtn">Pause</button> -->
                            <button  id="stopBtn">Stop</button>
                            </div>
                        </div>
                      
                        <h2>Total Time:<span id="totaltime"> </span></h2>
                       
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#startBtn').click(function() {
      
        $.ajax({
            url: '{{ url('user/time-start') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                alert(response);
                // Optionally, update the UI to reflect the change
            },
            error: function(xhr, status, error) {
                alert('Error changing status');
            }
        });
    });
});
</script>
<script>
$(document).ready(function() {
    $('#stopBtn').click(function() {
      
        $.ajax({
            url: '{{ url('user/time-stop') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                alert(response);
                // Optionally, update the UI to reflect the change
            },
            error: function(xhr, status, error) {
                alert('Error changing status');
            }
        });
    });
});
</script>
    

    