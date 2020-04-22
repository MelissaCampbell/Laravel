<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ ('Videos Laravel') }}</title>


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts  -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> 
    

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }} "type="text/css" >

</head>

<body>
    <div id="app">

        <nav class="navbar sticky-top navbar-expand-lg navbar-light shadow-sm" style="background-color: #0e0b16">
            <div class="container">
                <a class="navbar-brand" id="letras-navbar" href="{{ url('/') }}">
                    Videos Laravel
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarResponsive" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarResponsive">
                    
                 <!-- Boton de buscar -->    
                    <form class="form-inline my-2 my-lg-0 " action="{{ url('/buscar') }}" method="GET">
                        <input class="form-control mr-sm-2" type="text" placeholder="¿Qué deseas buscar?" aria-label="Search" name="search">
                        <button class="btn my-2 my-sm-0" id="botonbuscar"  type="submit">Buscar</button>
                    </form>                
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link " id="letras-navbar" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link " id="letras-navbar" href="{{ route('register') }}">{{ __('Registro') }}</a>
                                </li>
                            @endif
                        @else
                       
                            
                            <li class="nav-item">
                                <a class="nav-link " id="letras-navbar" href="{{ route('createVideo') }}"> Subir Video</a>
                            </li>

                            <li class="nav-item dropdown">                               
                                <a id="letras-navbar" class="nav-link dropdown-toggle text-capitalize " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        <footer class="col-md-12" >
            <hr/>
            <p> Curso de Laravel </p> 
        </footer>    

        </main>
    </div>
</body>
</html>
