<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Now Playing</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.0.10/css/all.css"
          integrity="sha384-KwxQKNj2D0XKEW5O/Y6haRH39PE/xry8SAoLbpbCMraqlX7kUP6KHOnrlrtvuJLR" crossorigin="anonymous">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css">

    <script>
        window.Laravel = {
            access_token: '{{ session('access_token') }}',
            expires_at: '{{ session('expires_at') * 1000 }}'
        };
    </script>
</head>
<body>

    <div id="app">
        <div v-if="window.Laravel.access_token">
            Authed
        </div>

        <div v-else>
            Login with Spotify
        </div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
