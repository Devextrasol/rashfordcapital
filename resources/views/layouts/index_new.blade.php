<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css"/>
    @include('includes.frontend.head_new')
</head>
<body class="{{ str_replace('.','-',Route::currentRouteName()) }} background-{{ $settings->background }} color-{{ $settings->color }}">
    @includeWhen(config('settings.gtm_container_id'), 'includes.frontend.gtm-body')

    <div id="app">

        <div id="before-content">
            @yield('before-content')
        </div>

        <div class="ui container pappukhan">
            @section('messages')
                @component('components.session.messages')
                @endcomponent
            @show
        </div>

        <div id="content">
            <!-- ----------HEADER---------- -->
            <header class="page-header">
              <div class="header1">
                <div class="web-search ui computer only" id="websearch">
                  <div class="ui massive left icon input main-search" id="site-search">
                    <input type="text" placeholder="Search..." type="Search" class="new-search">
                    <i class="my-search search icon"></i>
                  </div>
                  <img src="{{ asset('images/menu-x.png') }}" alt="" class="close-search" id="close-trigger">
                </div>
                <div class="test" id="page-test">
                  <div class="menu-container ui container ">
                    <div class="ui grid krypto-nav" id="menu">
                      <div class="sixteen wide tablet six wide computer column cls-responsive">
                        <a href="{{ route('frontend.index') }}" class="hide-logo"><img src="{{ asset('images/home-logo.svg') }}" alt="" class=" home-logo"></a>
                        <a href="{{ route('frontend.index') }}" class="hide-a"><img src="{{ asset('images/home-logo.svg') }}" alt="" class="ui fluid image home-logo"></a>
                        <div class="responsive-icon">

                        <img src="{{ asset('images/search-icon.png') }}" alt="" id="search">
                        <img src="{{ asset('images/menu-bar.png') }}" alt="" id="menu-btn">
                        <span class="close-text">Close</span><img src="{{ asset('images/menu-x.png') }}" alt="" id="menu-close">
                        </div>
                      </div>
                      <div class="sixteen wide tablet ten wide computer column" id="menu-ul">
                        <ul class="mobile-only" >
                          <li class="mobile-only">
                              <a href="{{ route('login') }}" class="nav-link button">Login</a>
                              <a href="{{ route('register') }}" class="nav-link trending-btn">Start Trading</a>

                          </li>
                          <li><a href="{{ url('page/faq') }}" class="nav-link">FAQ </a>

                           </li>
                          <li class="mydropdown"> Company <img src="{{ asset('images/arrow.png') }}" alt=""></i>
                            <ul class="sub-menu">
                              <li><a href="{{ url('page/about-us') }}">About Us</a></li>
                              <li><a href="">AML Policy</a></li>
                              <li><a href="{{ url('page/privacy-policy') }}">Privacy Policy</a></li>
                              <li><a href="{{ url('page/terms-of-use') }}">Terms and Conditions</a></li>
                              <li><a href="{{ url('page/contact-us') }}">Contact Us</a></li>
                            </ul>

                          </li>
                          <li><a href="" class="nav-link"><span><img src="{{ asset('images/eng-uk.png') }}" alt="" class="uk-img"></span>English (UK)</a></li>
                          <li><a href="{{ route('login') }}" class="nav-link hide button login-btn2">{{(auth()->check()) ? 'Dashboard' : 'Login' }}</a></li>
                          <li class="hidden"><a href="javascript:;" class="nav-link search-icon align-item" >
                            <img src="{{ asset('images/search-icon.png') }}" alt="" id="search-trigger"></a>
                          </li>
                          <li><a href="{{ route('register') }}" class="nav-link hide trending-btn">Start Trading</a></li>

                          <li class="mobile-only">
                              <a href="" class="nav-link"><i class="twitter sign icon"></i></a>
                              <a href="" class="nav-link"><i class="facebook sign icon"></i></a>

                          </li>
                        </ul>


                        <div class="ui massive icon input site-search" id="search-open">
                          <input type="text" placeholder="Search Instument" type="Search">
                          <i class="search icon"></i>
                        </div>

                      </div>


                    </div>
                    </div>
                    </div>
                    <div class="ui grid bg-text container" id="bg-text">
                      <div class="sixteen wide tablet sixteen wide computer column" id="text-wrap">
                        <div class="mytext">
                        <h1>
                        Trade CFDs on Bitcoin, Etherum,<br>
                        Ripple and more than 1000 <br>Cryptocurrencies
                        </h1>
                        <p class="p-margin">
                          Reliable. Simple. Innovative. <br>
                          Join millions who have
                          already traded with {{ env('_app_name_f') }}.
                        </p>
                        <a href="{{ route('register') }}" class="trending-btn-2">Start Trading</a>
                        </div>
                      </div>
                      <div class="four wide column"></div>
                    </div>
                  </div>
                </div>
              </div>
            </header>
            @yield('content')
        </div>

        <div id="after-content">
            @yield('after-content')
        </div>

        @includeFirst(['includes.frontend.footer-udf','includes.frontend.footer_new'])

    </div>

    @include('includes.frontend.scripts_new')
</body>
</html>