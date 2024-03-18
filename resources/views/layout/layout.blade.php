<!doctype html>
<html>
<head>
   @include('layout.head')
</head>
<body id="page-top">

   <header>
       @include('layout.header')
   </header>
  
           @yield('content')
   
   <footer class="sticky-footer bg-white">
       @include('layout.footer')
   </footer>

</body>
</html>