<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Now Playing</title>

    <!-- Fonts -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
<script>
    window.Laravel = {
        'csrfToken': "{{ csrf_token() }}"
    };
</script>

<div id="app">
    @yield('content')
</div>
</body>
</html>
