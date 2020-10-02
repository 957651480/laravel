<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>挖机后台系统</title>
    <link href="{{ mix('css/frontend.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <app></app>
</div>
<script src="{{ mix('backend/js/main.js') }}"></script>
</body>
</html>
