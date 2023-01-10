<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | ADORABLEKIDS</title>
    @include('layout.head')
    @include('layout.style')
    {{-- <script src="{{asset('assets/js/html5shiv.js')}}"></script> --}}
    {{-- <script src="{{asset('assets/js/respond.min.js')}}"></script> --}}
    <link rel="shortcut icon" href="{{asset('assets/favicon.ico')}}">
</head>

<body>
@include('layout.header')
 
@yield('content')
 
@include('layout.footer')
 
@include('layout.script')

@yield('jsOutSide')
  
</body>
</html>
