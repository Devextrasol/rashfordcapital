@extends('layouts.index_new')

@section('content')
<!----- headre------------>
   {{--  <header><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <div class="header">

        <div class="web-search" id="websearch">
          <div class="ui massive left icon input main-search" id="site-search">
              <input type="text" placeholder="Search Instument" type="Search" class="new-search">
              <i class="my-search search icon"></i>
          </div>
            <img src="{{ asset('images/menu-x.png') }}" alt="" class="close-search" id="close-trigger">

        </div>
  <div class="test" id="page-test">
      <div class="menu-container ui container">


        <div class="ui grid krypto-nav" id="menu">
          <div class="sixteen wide tablet six wide computer column cls-responsive">
            <a href="{{ route('frontend.index') }}" class="hide-logo"><img src="{{ asset('images/home-logo.png') }}" alt="" class=" home-logo"></a>
            <a href="{{ route('frontend.index') }}" class="hide-a"><img src="{{ asset('images/home-logo.png') }}" alt="" class="ui fluid image responsive-logo"></a>
            <div class="responsive-icon">

            <img src="{{ asset('images/search-icon.png') }}" alt="" id="search">
            <img src="{{ asset('images/menu-bar.png') }}" alt="" id="menu-btn">
            <span class="close-text">Close</span><img src="{{ asset('images/menu-x.png') }}" alt="" id="menu-close">
            </div>
          </div>
          <div class="sixteen wide tablet ten wide computer column" id="menu-ul">
             <ul class="mobile-only" >
              <li class="mobile-only">
                  <a href="{{ route('login') }}" class="nav-link button responsive">Login</a>
                  <a href="{{ route('register') }}" class="nav-link responsive trending-btn">Start Trading</a>

              </li>
              <li><a href="{{ url('page/faq') }}" class="nav-link">FAQ </a></li>
              <li><a href="" class="nav-link"> Company <img src="{{ asset('images/arrow.png') }}" alt=""></a>
                <ul class="sub-menu">
                  <li><a href="{{ url('page/about-us') }}">About Us</a></li>
                  <li><a href="">AML Policy</a></li>
                  <li><a href="{{ url('page/privacy-policy') }}">Privacy Policy</a></li>
                  <li><a href="{{ url('page/terms-of-use') }}">Terms and Conditions</a></li>
                  <li><a href="{{ url('page/contact-us') }}">Contact Us</a></li>


                </ul>

              </li>
              <li><a href="{{ route('login') }}" class="nav-link hide button">Login</a></li>
              <li><a href="{{ route('register') }}" class="nav-link hide trending-btn">Start Trading</a></li>
              <li><a href="" class="nav-link">Eng</a>

              </li>
              <li class="mobile-only">
                  <a href="" class="nav-link"><i class="twitter sign icon"></i></a>
                  <a href="" class="nav-link"><i class="facebook sign icon"></i></a>

              </li>
              <li class="hidden" ><a href="javascript:;" class="nav-link search-icon align-item" id="search-trigger">
                <img src="{{ asset('images/search-icon.png') }}" alt="" ></a></li>
            </ul>


            <div class="ui massive icon input site-search" id="search-open">
              <input type="text" placeholder="Search Instument" type="Search">
              <i class="search icon"></i>
            </div>

          </div>



        </div>
      </div>
      </div>
      </div>
    </header> --}}
<!------body-------------->
 <div class="what-we-offer">
      <div class="ui main container">
      <div class="ui stackable wide column grid">
        <div class="wide column">
          <h1 class="PHeadinh-h1">About Us</h1>
          <div class="inline-content">
            <i class="users icon icon-style"></i>
            <h1 class="Headinh-hlight">Who We Are</h1>
          </div>

          <p class="new-p">The {{ env('_app_name_f') }} trading platform is offered by a UK based company with its offices located in the City of London. The company is authorised and regulated to offer Contracts For Difference (CFD). The company is a rapidly growing CFD provider and currently offers its portfolio of over 1000 cryptocurrnecies.</p>
          <div class="inline-content">
            <i class="shield alternate icon icon-style"></i>
            <h1 class="Headinh-hlight">Client Money</h1>

          </div>
          <p class="new-p">When you open an account, {{ env('_app_name_f') }} Ltd will hold your funds on a segregated basis, in accordance with the Financial Conduct Authority's client money rules.</p>


          <div class="inline-content">
            <i class="certificate icon icon-style"></i>
            <h1 class="Headinh-hlight">Highly Rated CFD Provider</h1>
          </div>
          <p class="new-p">{{ env('_app_name_f') }} is one of the highest rated CFD trading app online as it is simple to use yet powerful in its many advanced features.</p>
          </div></div></div></div>
       <div class="what-we-offer change-bg">
      <div class="ui main container">
      <div class="ui stackable wide column grid">
        <div class="wide column">
          <h1 class="PHeadinh-h1">Objectives & Vision</h1>
          <h1 class="Headinh-hlight">Our Strategy</h1>
          <p>{{ env('_app_name_f') }} has established a strong foundation from which it is well positioned to deliver future growth. {{ env('_app_name_f') }}’s strategic priorities have to date differentiated, and will continue to differentiate, {{ env('_app_name_f') }} from its competitors and be fundamental to {{ env('_app_name_f') }}’s future success.</p>

          <h1 class="Headinh-hlight">Continue to acquire New Customers and retain Active Customers</h1>
          <p>{{ env('_app_name_f') }} own marketing has been and will continue to be the driving force behind New Customer growth within current markets and potential new jurisdictions.</p>
          <p>These innovative marketing initiatives allow {{ env('_app_name_f') }} to deploy targeted marketing resources and develop highly effective marketing campaigns through the monitoring and control of customer acquisition spend based on data analytics tools and proprietary algorithms.</p>

          <h1 class="Headinh-hlight">Increase trading volume from Active Customers on the Trading Platform</h1>
          <p>{{ env('_app_name_f') }} consistent focus on innovation, best-in-class user experience and breadth of offering are the key elements of increasing activity of Active Customers on the Trading Platform. {{ env('_app_name_f') }} continued emphasis on innovation will enable it to continue to be amongst the first to market in launching new instruments which customers find desirable, such as high profile, newly listed equities.</p>
          <p>The Company understands the need to develop and deploy new and innovative financial instruments as part of its strategy to continue to build a loyal and engaged customer base.</p>
          <p>{{ env('_app_name_f') }} is an industry leader within the CFD sector in mobile innovation and customer satisfaction.</p>

          <h1 class="Headinh-hlight">Continue to optimise our operating model to further drive financial performance</h1>
          <p>The continued investment in and development of the Marketing Machine will enable {{ env('_app_name_f') }} to further enhance its ability to efficiently and cost-effectively acquire New Customers.</p>

          <h1 class="PHeadinh-h1">Our Vision</h1>
          <p>Being the no.1 global CFD provider while continuing to lead in technology and innovation, and attracting new and existing customers.</p>

        </div>
      </div>

  </div>
</div>
@endsection
