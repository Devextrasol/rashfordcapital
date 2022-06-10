@extends('layouts.frontend_new')



@section('content')
<!----- headre------------>
    <header>
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
    </header>
<!------body-------------->
    <div class="what-we-offer change-bg">
      <div class="ui main container">
      <div class="ui stackable wide column grid">
        <div class="wide column">
          <h1 class="PHeadinh-h1">Privacy Policy</h1>
          <p>This privacy notice discloses the privacy practices for<a href="{{ route('frontend.index') }}"> {{ url('') }}</a> This privacy notice applies solely to information collected by this website. It will notify you of the following:</p>
          <div class="ui bulleted list">
              <div class="item">What personally identifiable information is collected from you through the website, how it is used and with whom it may be shared.</div>
              <div class="item">What choices are available to you regarding the use of your data.</div>
              <div class="item">The security procedures in place to protect the misuse of your information.</div>
              <div class="item">How you can correct any inaccuracies in the information.</div>
        </div>
          <h1 class="Headinh-hlight">Information Collection, Use, and Sharing</h1>
          <p>We are the sole owners of the information collected on this site. We only have access to/collect information that you voluntarily give us via email or other direct contact from you. We will not sell or rent this information to anyone.</p>
          <p>We will use your information to respond to you, regarding the reason you contacted us. We will not share your information with any third party outside of our organization, other than as necessary to fulfill your request, e.g. to ship an order.</p>
          <p>Unless you ask us not to, we may contact you via email in the future to tell you about specials, new products or services, or changes to this privacy policy.</p>
          <h1 class="Headinh-hlight">Your Access to and Control Over Information</h1>
          <p>You may opt out of any future contacts from us at any time. You can do the following at any time by contacting us via the email address or phone number given on our website:</p>
          <div class="ui bulleted list">
              <div class="item">See what data we have about you, if any.</div>
              <div class="item">Change/correct any data we have about you.</div>
              <div class="item">Have us delete any data we have about you.</div>
              <div class="item">Express any concern you have about our use of your data.</div>
        </div>
        <h1 class="Headinh-hlight">Security</h1>
        <p>We take precautions to protect your information. When you submit sensitive information via the website, your information is protected both online and offline.</p>
        <p>Wherever we collect sensitive information (such as credit card data), that information is encrypted and transmitted to us in a secure way. You can verify this by looking for a lock icon in the address bar and looking for "https" at the beginning of the address of the Web page.</p>
        <p>While we use encryption to protect sensitive information transmitted online, we also protect your information offline. Only employees who need the information to perform a specific job (for example, billing or customer service) are granted access to personally identifiable information. The computers/servers in which we store personally identifiable information are kept in a secure environment.</p>
        </div>
      </div>

  </div>
</div>
@endsection
