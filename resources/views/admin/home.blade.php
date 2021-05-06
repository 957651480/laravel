<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--<link href="{{ mix('css/ant.css') }}" rel="stylesheet">--}}
    <title>挖机后台系统</title>
</head>
<body>
<div id="app">
    <app></app>
</div>
<script src="{{ mix('js/manifest.js') }}" defer></script>
<script src="{{ mix('js/vendor.js') }}" defer></script>
<script src="{{ mix('js/main.js') }}" defer></script>
</body>
</html>
