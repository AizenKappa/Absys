<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" async>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" async>
    
    <title>Absys</title>
</head>
<body  class="h-screen">

    
    <main>
        {{$slot}}
    </main>
        

    

    <script src="{{ asset('js/login.js')}}" async></script>
</body>
</html>