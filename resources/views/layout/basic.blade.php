<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <meta name="author" content=" @yield ('meta_author','Jawad Maqbool')">
    <link rel="canonical" href="{{ route('dashboard') }}" />
    <meta name="description"
        content="
        @yield ('meta_description','Best Site to get baby walker, baby clothes, baby shampoo, baby toys and other new be products in capital city Islamabad')" />
    <meta name="keywords"
        content=" @yield ('meta_keywords','baby walker, baby clothes, baby shampoo, baby toys,
        new be products, capital city, Islamabad, baby products')" />
    <title>@yield ('page_title', 'Home | adorablekids.pk')</title>
    @include('layout.head')
    @include('layout.style')
    {{-- <script src="{{asset('assets/js/html5shiv.js')}}"></script> --}}
    {{-- <script src="{{asset('assets/js/respond.min.js')}}"></script> --}}
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
</head>

<body>
    <div id="preloder">
        <div class="loader"></div>
    </div>
    @include('layout.header')

    @yield('content')

    @include('layout.footer')

    @include('layout.script')

    @yield('jsOutSide')

</body>

</html>
