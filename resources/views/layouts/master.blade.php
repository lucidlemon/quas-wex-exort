<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title') - Quas-Wex-Exort.com Dota 6.89 / 7.00 Countdown</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,700" rel="stylesheet">
        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700,400italic">
        <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">

        <!-- Styles -->
        @if(env('APP_DEBUG', false))
            <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        @else
            <link rel="stylesheet" href="{{ elixir('css/app.css') }}">
        @endif

    </head>
    <body class="@yield('bodyclass')">
        <nav class="main">
            <ul>
                <li>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li>
                    <a href="{{ url('overview/items') }}">Items</a>
                </li>
            </ul>
            <ul>
                <li>
                    @if(\Illuminate\Support\Facades\Auth::check())
                        <a href="/logout">logged in as {{\Illuminate\Support\Facades\Auth::user()->username}}</a>
                    @else
                        <a href="{{url('/login')}}">Login with Steam</a>
                    @endif
                </li>
            </ul>
        </nav>
        <div id="app" v-md-theme="'default'">
            @yield('content')
        </div>
        <script>
            window.Laravel = <?php echo json_encode([
                    'csrfToken' => csrf_token(),
                    'apiUrl' => url('/api'),
            ]); ?>
        </script>

        @if(env('APP_DEBUG', false))
            <script src="{{ asset('js/app.js') }}"></script>
        @else
            <script src="{{ elixir('js/app.js') }}"></script>
        @endif
    </body>
</html>
