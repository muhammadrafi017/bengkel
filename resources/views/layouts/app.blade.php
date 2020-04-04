<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <link rel="icon" href="{{ asset('landing/img/favicon.png') }}" type="image/png" />
    <title>Edustage Education</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('landing/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('landing/css/flaticon.css') }}" />
    <link rel="stylesheet" href="{{ asset('landing/css/themify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('landing/vendors/owl-carousel/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('landing/vendors/nice-select/css/nice-select.css') }}" />
    <!-- main css -->
    <link rel="stylesheet" href="{{ asset('landing/css/style.css') }}" />
  </head>

  <body>
    <!--================ Start Header Menu Area =================-->
    <header class="header_area">
      <div class="main_menu">
        <div class="search_input" id="search_input_box">
          <div class="container">
            <form class="d-flex justify-content-between" method="" action="">
              <input
                type="text"
                class="form-control"
                id="search_input"
                placeholder="Search Here"
              />
              <button type="submit" class="btn"></button>
              <span
                class="ti-close"
                id="close_search"
                title="Close Search"
              ></span>
            </form>
          </div>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light">
          <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <a class="navbar-brand logo_h" href="index.html"
              ><img src="{{ asset('landing/img/logo.png') }}" alt=""
            /></a>
            <button
              class="navbar-toggler"
              type="button"
              data-toggle="collapse"
              data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
              <span class="icon-bar"></span> <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div
              class="collapse navbar-collapse offset"
              id="navbarSupportedContent"
            >
              <ul class="nav navbar-nav menu_nav ml-auto">
                <li class="nav-item active">
                  <a class="nav-link" href="{{ url('') }}">Home</a>
                </li>
                @guest
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('register') }}">Register</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('login') }}">Login</a>
                  </li>
                @endguest
                @auth
                  <li class="nav-item">
                    <a class="nav-link" href="{{ url('calon_mahasiswa/form') }}">Formulir</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Logout</a>
                  </li>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>    
                @endauth
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </header>
    <!--================ End Header Menu Area =================-->

    @yield('content')

    <!--================ Start footer Area  =================-->
    <footer class="footer-area">
      <div class="container">
        <div class="row footer-bottom d-flex justify-content-between">
          <p class="col-lg-8 col-sm-12 footer-text m-0 text-white">
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="ti-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
          </p>
        </div>
      </div>
    </footer>
    <!--================ End footer Area  =================-->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{ asset('landing/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('landing/js/popper.js') }}"></script>
    <script src="{{ asset('landing/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('landing/vendors/nice-select/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('landing/vendors/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('landing/js/owl-carousel-thumb.min.js') }}"></script>
    <script src="{{ asset('landing/js/jquery.ajaxchimp.min.js') }}"></script>
    <script src="{{ asset('landing/js/mail-script.js') }}"></script>
    <!--gmaps Js-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCjCGmQ0Uq4exrzdcL6rvxywDDOvfAu6eE"></script>
    <script src="{{ asset('landing/js/gmaps.min.js') }}"></script>
    <script src="{{ asset('landing/js/theme.js') }}"></script>
  </body>
</html>
