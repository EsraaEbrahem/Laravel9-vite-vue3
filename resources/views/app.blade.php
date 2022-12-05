<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>UMG-E-Commerce</title>
    <link rel="icon" href="{{asset('images/logo.png')}}">
    <!-- Fonts -->
    <link rel="stylesheet" href="//cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    @vite('resources/css/app.css')
</head>
<body>
<div id="app">
    <div id="loadingApplication">
        <div class="loader"/>
    </div>
</div>
</body>
@vite('resources/js/app.js')
</html>
