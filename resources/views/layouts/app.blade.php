<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @yield('appScript', View::make('partials.appscript'))
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <style type="text/css">
        /* fallback */
        @font-face {
          font-family: 'Material Icons';
          font-style: normal;
          font-weight: 400;
          src: url(/fonts/flUhRq6tzZclQEJ-Vdg-IuiaDsNc.woff2) format('woff2');
        }
        /* cyrillic-ext */
        @font-face {
          font-family: 'Nunito';
          font-style: normal;
          font-weight: 400;
          src: url(/fonts/XRXI3I6Li01BKofiOc5wtlZ2di8HDLshdTk3j77e.woff2) format('woff2');
          unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
        }
        /* cyrillic */
        @font-face {
          font-family: 'Nunito';
          font-style: normal;
          font-weight: 400;
          src: url(/fonts/XRXI3I6Li01BKofiOc5wtlZ2di8HDLshdTA3j77e.woff2) format('woff2');
          unicode-range: U+0301, U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
        }
        /* vietnamese */
        @font-face {
          font-family: 'Nunito';
          font-style: normal;
          font-weight: 400;
          src: url(/fonts/XRXI3I6Li01BKofiOc5wtlZ2di8HDLshdTs3j77e.woff2) format('woff2');
          unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+1EA0-1EF9, U+20AB;
        }
        /* latin-ext */
        @font-face {
          font-family: 'Nunito';
          font-style: normal;
          font-weight: 400;
          src: url(/fonts/XRXI3I6Li01BKofiOc5wtlZ2di8HDLshdTo3j77e.woff2) format('woff2');
          unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
        }
        /* latin */
        @font-face {
          font-family: 'Nunito';
          font-style: normal;
          font-weight: 400;
          src: url(/fonts/XRXI3I6Li01BKofiOc5wtlZ2di8HDLshdTQ3jw.woff2) format('woff2');
          unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
        }

        .material-icons {
          font-family: 'Material Icons';
          font-weight: normal;
          font-style: normal;
          font-size: 24px;
          line-height: 1;
          letter-spacing: normal;
          text-transform: none;
          display: inline-block;
          white-space: nowrap;
          word-wrap: normal;
          direction: ltr;
          -webkit-font-feature-settings: 'liga';
          -webkit-font-smoothing: antialiased;
        }
    </style>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ Config::get('app.name') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </nav>

        <main class="py-4">
            <div class="row">
                <div id="sidebar" class="col-md-2">
                    <ul class="navbar-nav">
                        @auth
                            @if ( Auth::user()->admin )
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ route('livescoring') }}" target="liveScoring"><i class="material-icons">grade</i> Live Scoring</a>
                            </li>
                            @else 
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ route('scoring') }}" target="liveScoring"><i class="material-icons">grade</i> Live Scoring</a>
                            </li>
                            @endif
                            @if ( Auth::user()->admin ) 
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ route('admin') }}"><i class="material-icons">construction</i> Admin Tools</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ route('categories') }}"><i class="material-icons">category</i> Categories</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ route('entries') }}"><i class="material-icons">person</i> Entries</a>
                            </li>
                            <li class="nav-item">
                                <a class="dropdown-item" href="{{ route('schools') }}"><i class="material-icons">school</i> Schools</a>
                            </li>
                            @endif
                        @endauth
                    </ul>
                </div>
                <div id="main" class="col-md-10">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
</body>
</html>
