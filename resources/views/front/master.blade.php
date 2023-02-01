@php
    $detect = new Mobile_Detect();
    compileCSS();
@endphp

@include('front.templates.header')

@yield('content')

@include('front.templates.footer')