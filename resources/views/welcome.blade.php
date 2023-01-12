<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="body">
<div id="app">
    <welcome></welcome>
    <button>1111222111</button>
</div>
<script src="{{ mix('js/app.js') }}" defer type="text/javascript"></script>
</body>
</html>
