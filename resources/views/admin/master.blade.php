<!DOCTYPE html>
<html>

<head>
	@include ('admin.head')
</head>
<body>
	@include ('admin.header')
	@include ('admin.sidebar')
	
      <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
	
	 
@yield('content')

	
</body>
	@include ('admin.js')
</html>
@include('sweetalert::alert')