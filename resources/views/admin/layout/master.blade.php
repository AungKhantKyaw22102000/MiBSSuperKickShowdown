<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="{{ asset('user/images/favicon.png') }}">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('user/css/materialize.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/loaders.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/lightbox.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('user/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <!-- navbar -->
    <div class="navbar">
        <div class="container">
            <div class="row">
                <div class="col s3">
                    <div class="content-left">
                        <a href="#slide-out" data-activates="slide-out" class="sidebar"><i class="fas fa-bars"></i></a>
                    </div>
                </div>
                <div class="col s6">
                    <div class="content-center">
                        <a href="index.php"><img src="{{ asset('user/images/logo2.webp') }}" style="margin-top: -10px;" alt="MiBS"></a>
                    </div>
                </div>
                <div class="col s3">
                    <div class="content-right">
                        <a href="#modal1" class="modal-trigger"><i class="fas fa-search"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end navbar -->

    <!-- sidebar -->
    <div class="sidebar-panel">
        <ul id="slide-out" class="collapsible side-nav">
            <li>
                <div class="user-view">
                    <img class="circle responsive-img" src="{{ asset("user/images/madlab.png") }}" alt="">
                    <h5>MadLab</h5>
                    <span>Developer</span>
                </div>
            </li>
            <li>
                <a href="{{ route('admin#clubList') }}">Club List</a>
            </li>
            <li>
                <a href="{{ route('admin#footballMatchList') }}">Match List</a>
            </li>
            <li>
                <a href="{{ route('admin#playerList') }}">Player List</a>
            </li>
            <li>
                <a href="{{ route('admin#galleryList') }}">Gallery</a>
            </li>
            <li>
                <div class="collapsible-header">
                    Pages<span><i class="fas fa-circle"></i></span>
                </div>
                <div class="collapsible-body">
                    <ul>
                        @guest
                            <li><a href="{{ route('auth#loginPage') }}">Sign In</a></li>
                            <li><a href="{{ route('auth#registerPage') }}">Sign Up</a></li>
                        @endguest
                        @auth
                            <li><a href="">Settings</a></li>
                            <li><a href="">Verify Mail</a></li>
                        @endauth
                    </ul>
                </div>
            </li>
            @auth
            <li>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-4">
                            <button class="btn text-white" type="submit">
                                <i class="fa-solid fa-right-from-bracket"></i> Logout
                            </button>
                        </div>
                    </div>
                </form>
            </li>
            @endauth
        </ul>
    </div>
    <!-- end sidebar -->

    <!-- search -->
    <div id="modal1" class="modal">
        <div class="modal-content">
            <form id="player-search-form">
                <input type="text" id="search-input" placeholder="Search">
                <button class="button" id="search-button"><i class="fas fa-search"></i></button>
            </form>
            <div id="search-results">
                <!-- Results will be displayed here -->
            </div>
        </div>
    </div>
    <!-- end search -->

    @yield('content');

    <script src="{{ asset('user/js/jquery.min.js') }}"></script>
    <script src="{{ asset('user/js/materialize.js') }}"></script>
    <script src="{{ asset('user/js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('user/js/main.js') }}"></script>

</body>
</html>
