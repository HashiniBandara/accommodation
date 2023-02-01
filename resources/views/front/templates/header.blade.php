<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ !empty($title) ? $title . ' | ' : '' }}{{ $siteTitle ?? config('app.name', '') }}</title>

    @isset($meta_description)
        <meta name="description" content="{{ $meta_description }}">
    @endisset

    @isset($pageData['meta_description'])
        <meta name="description" content="{{ $pageData['meta_description'] }}">
        <meta property="og:description" content="{{ $pageData['meta_description'] }}" />
        <meta property="twitter:description" content="{{ $pageData['meta_description'] }}" />
    @endisset

    <meta property="og:title" content="{{ !empty($title) ? $title . ' | ' : '' }}{{ $siteTitle ?? config('app.name', '') }}" />
    <meta property="twitter:title" content="{{ !empty($title) ? $title . ' | ' : '' }}{{ $siteTitle ?? config('app.name', '') }}" />
    
    @if (!empty($og_image))
        <meta property="og:image" content="{{ $og_image }}" />
        <meta property="twitter:image" content="{{ $og_image }}" />
    @endif

    @if ($favicon = getSettingValue($themeSettingsKey, 'favicon'))
        <link rel="icon" href="{{ $favicon }}" />
    @endif

    {{-- styles --}}
    <link rel="stylesheet" href="{{ asset('assets/front/css/master.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css"
        integrity="sha512-nNlU0WK2QfKsuEmdcTwkeh+lhGs6uyOxuUs+n+0oXSYDok5qy0EI0lt01ZynHq6+p/tbgpZ7P+yUb+r71wqdXg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
</head>

<body>
    <header class="main-header">
    </header>
