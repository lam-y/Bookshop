
<!DOCTYPE html>
<html lang="en">
  
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
  
    <title>Bookshop @yield('title')</title>
    <link rel = "icon" href ='{{ asset('img/icon.png') }}' type = "image/x-icon">
  
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" 
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
  
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/shop-homepage.css') }}" rel="stylesheet"> 
    <link href="{{ asset('css/credit.css') }}" rel="stylesheet">    

    @yield('stylesheets')


    <!-- Javaacript and JQuery -->
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>

    @yield('script')
  
  </head>