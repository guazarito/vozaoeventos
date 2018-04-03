<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109219912-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-109219912-1');
    </script>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
	
	<link rel="apple-touch-icon" sizes="180x180" href="/layout/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/layout/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/layout/favicon/favicon-16x16.png">
	<link rel="manifest" href="/layout/favicon/manifest.json">
	<meta name="theme-color" content="#ffffff">

    <title>Vozão 2017</title>

    <!-- Styles -->
    <link href="{{asset('layout/css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('layout/css/style.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    
    <script src="{{asset('layout/js/bootstrap.js')}}"></script>
    <script src="{{asset('js/ingressos.js')}}"></script>

       
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{asset('/layout/img/vozao_logo_2017.png')}}" style="height: 40px; position: relative; top:-10px;">
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li><a href="{{ route('index_route') }}"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                        <li><a href="{{ route('help') }}"><span class="glyphicon glyphicon-question-sign"></span> Ajuda</a></li>
                    </ul>  

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Cadastre-se</a></li>
                        @else

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    @if (Auth::user()->role==1)
                                     <li>
                                        <a href="{{route('adm_lista_pedidos')}}">Ver todos pedidos</a>
                                    </li>
                                    <li>
                                        <a href="{{route('adm_lista_usuarios')}}">Ver usuários cadastrados</a>
                                    </li>                                   
                                    <li>
                                        <a href="{{route('adm_lista_precos')}}">Gerenciar preços/lotes</a>
                                    </li>    
                                    <li class="divider"></li>
                                    @endif
                                    <li>
                                        <a href="{{route('meuspedidos')}}">Meus pedidos</a>
                                    </li>
                                     <li>
                                        <a href="{{route('meusdados')}}">Meus dados</a>
                                    </li>
                                   <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Sair
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @yield('num_carrinho')
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

    </div>

    <div id="footer">
        <div class="container" id="footer_copy">
            <div class="row">
                <div class="col-sm-12 col-md-6" id="footer_logo">
                         <a href="{{ url('/') }}">
                           <img src="{{asset('/layout/img/vozao_logo_2017.png')}}" style="height: 80px;">
                        </a>
                </div><!--col-->
                <div class="col-sm-12 col-md-6" id="footer_copyright">
                            <p>Todos os direitos reservados © Vozão Eventos 2017</p>
							<a href="{{route('termosdeuso')}}"><u>Termos de uso</u></a>
                            <p id="developedby">Desenvolvido por <a href="mailto:guazarito@gmail.com">Gustavo Azarito</a></p>
                </div><!--col-->
            </div><!--row-->

        </div><!-- container -->
    </div>

 
   
   
</body>
</html>
