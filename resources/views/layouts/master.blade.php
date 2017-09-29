<!DOCTYPE html>
<html lang="en">
<head>

    <!--

    ##,                                   ,##
    '##,                                 ,##'
     '##                                 ##'
      ##               __,               ##
      ##          __.-'   \              ##
      ##    ___.-'__.--'\ |              ##,
      ## .-' .-, (      | |        _     '##
      ##/ / /""=\ \     | |       / \     ##,
      '#| |_\   / /     | |      /   \    '##
      / `-` 0 0 '-'`\   | |      | |  \   ,##
      \_,   (__)  ,_/  / /       |  \  \  ##'
       / /    \   \\  / /        |  |\  \ ## __
      | /`.__.-'-._)|/ /         |  | \  \##`__)
      \        ^    / /          |  |  | v## '--.
       '._    '-'_.' / _.----.   |  |  l ,##  (_,'
        '##'-,  ` `"""/       `'/|  | / ,##--,  )
         '#/`        `         '    |'  ##'   `"
          |                         /\_/#'
          |              __.  .-,_.;###`
         _|___/_..---'''`   _/  (###'
     .-'`   ____,...---""```     `._
    (   --''        __,.,---.    ',_)
     `.,___,..---'``  / /    \     '._
          |  |       ( (      `.  '-._)
          |  /        \ \      \'-._)
          | |          \ \      `"`
          | |           \ \
          | |    .-,     ) |
          | |   ( (     / /
          | |    \ '---' /
          /  \    `-----`
         | , /
         |(_/\-,
         \  ,_`)
          `-._)

          PLS VOLVO BE ON TIME
          --
          /u/karreerose did this. bitches.

    -->

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <title>@yield('title') - Quas-Wex-Exort.com</title>
    <!-- Sorry /u/wykrhm. Didn't want to cause any trouble. -->


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Ubuntu:100,300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="//fonts.googleapis.com/icon?family=Material+Icons">

    <!-- Styles -->
    @if(env('APP_DEBUG', false))
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @else
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @endif

</head>
<body class="@yield('bodyclass')">
<aside class="sidebar">
    <a href="{{url('/')}}" class="logo"></a>
    <nav class="main">
        <ul>
            <li>
                <a href="{{ url('/') }}" class="{{ active('/') }}">
                    <img src="{{asset('assets/ic_countdown.svg')}}" />
                    Countdown
                </a>
            </li>
            <li>
                <a href="{{ url('/oneliner') }}" class="{{ active('oneliner') }}">
                    <img src="{{asset('assets/ic_trashtalk.svg')}}" />
                    Trashtalk
                </a>
            </li>
            <li>
                <a href="{{ url('/guides') }}" class="{{ active(['guides', 'guides/heroes', 'guides/items', 'guides/post', 'guides/tactics']) }}">
                    <img src="{{asset('assets/ic_guides.svg')}}" />
                    Guides
                </a>
            </li>
            <li>
                <a href="{{ url('quiz') }}">
                    <img src="{{asset('assets/ic_games.svg')}}" />
                    Quiz
                </a>
            </li>
            @if(env('APP_DEBUG', false))
                {{--<li>--}}
                    {{--<a href="{{ url('quiz') }}">--}}
                        {{--<img src="{{asset('assets/ic_games.svg')}}" />--}}
                        {{--Mini Games--}}
                    {{--</a>--}}
                {{--</li>--}}
                {{--<li>--}}
                {{--<a href="{{ url('oneliner') }}">--}}
                {{--<img src="{{asset('assets/ic_social.svg')}}" />--}}
                {{--Reddit Posts--}}
                {{--</a>--}}
                {{--</li>--}}
            @endif
            <li class="hidden-desktop hidden-tablet">
                @if(\Illuminate\Support\Facades\Auth::check())
                    <a href="/logout">
                        <img src="{{asset('assets/ic_steam.svg')}}" />
                        {{\Illuminate\Support\Facades\Auth::user()->username}} (logout)
                    </a>
                @else
                    <a href="{{url('/login')}}">
                        <img src="{{asset('assets/ic_steam.svg')}}" />
                        Login with Steam
                    </a>
                @endif
            </li>
        </ul>
    </nav>
    <nav class="user hidden-phone">
        <ul>
            @if(\Illuminate\Support\Facades\Auth::check())
                <li>
                    <a href="/logout">
                        <img src="{{asset('assets/ic_steam.svg')}}" />
                        {{\Illuminate\Support\Facades\Auth::user()->username}} - Log Out
                    </a>
                </li>
                @if(\Illuminate\Support\Facades\Auth::user()->mod)
                    <li class="text-only">
                        <a href="/patches">Edit Patches</a>
                    </li>
                @endif
            @else
                <li>
                    <a href="{{url('/login')}}">
                        <img src="{{asset('assets/ic_steam.svg')}}" />
                        Login with Steam
                    </a>
                </li>
            @endif
            <li class="text-only">
                <a href="https://t.me/joinchat/BLwcJAsyWJfig7oNil-LSQ" target="_blank">
                    Telegram Group
                </a>
            </li>
            <li class="text-only">
                <a href="/about">About</a>
            </li>
        </ul>
    </nav>
</aside>
<div id="app">
    {{--<passport-clients></passport-clients>--}}
    {{--<passport-authorized-clients></passport-authorized-clients>--}}
    {{--<passport-personal-access-tokens></passport-personal-access-tokens>--}}
    @yield('content')
</div>
<script>
    window.Laravel = <?php echo json_encode([
        'csrfToken' => csrf_token(),
        'apiUrl' => url('/api'),
        'user' => \Illuminate\Support\Facades\Auth::user(),
    ]); ?>
</script>

<script>@yield('serverdata')</script>

@if(env('APP_DEBUG', false))
    <script src="{{ asset('js/app.js') }}"></script>
@else
    <script src="{{ mix('js/app.js') }}"></script>

    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-17828347-11', 'auto');
        ga('send', 'pageview');

    </script>

    <!-- Piwik -->
    <script type="text/javascript">
        var _paq = _paq || [];
        // tracker methods like "setCustomDimension" should be called before "trackPageView"
        _paq.push(["disableCookies"]);
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
            var u="https://piwik.danielwinter.at/";
            _paq.push(['setTrackerUrl', u+'piwik.php']);
            _paq.push(['setSiteId', '3']);
            var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
            g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
        })();
    </script>
    <!-- End Piwik Code -->
@endif


</body>
</html>
