<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <title>Absys</title>
</head>
<body  class="h-screen">

    <section id="app">

        {{$slot}}

    </section>


    <script src="{{ asset('js/app.js')}}" ></script>
</body>
</html>