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
          <h1 class="PHeadinh-h1">Terms of Use</h1>
          <p>Welcome to our website. If you continue to browse and use this website, you are agreeing to comply with and be bound by the following terms and conditions of use, which together with our privacy policy govern our relationship with you in relation to this website. If you disagree with any part of these terms and conditions, please do not use our website.</p>
          <p>The term 'us' or 'we' refers to the owner of the website. The term 'you' refers to the user or viewer of our website.</p>
          <p>The use of this website is subject to the following terms of use:</p>
          <div class="ui bulleted list">
              <div class="item">The content of the pages of this website is for your general information and use only. It is subject to change without notice.</div>
              <div class="item">This website uses cookies to monitor browsing preferences. If you do allow cookies to be used, the following personal information may be stored by us for use by third parties.</div>
              <div class="item">Neither we nor any third parties provide any warranty or guarantee as to the accuracy, timeliness, performance, completeness or suitability of the information and materials found or offered on this website for any particular purpose. You acknowledge that such information and materials may contain inaccuracies or errors and we expressly exclude liability for any such inaccuracies or errors to the fullest extent permitted by law..</div>
              <div class="item">Your use of any information or materials on this website is entirely at your own risk, for which we shall not be liable. It shall be your own responsibility to ensure that any products, services or information available through this website meet your specific requirements.</div>
              <div class="item">This website contains material which is owned by or licensed to us. This material includes, but is not limited to, the design, layout, look, appearance and graphics. Reproduction is prohibited other than in accordance with the copyright notice, which forms part of these terms and conditions.</div>
              <div class="item">All trade marks reproduced in this website which are not the property of, or licensed to, the operator are acknowledged on the website.</div>
              <div class="item">Unauthorised use of this website may give rise to a claim for damages and/or be a criminal offence.
              </div>
              <div class="item">From time to time this website may also include links to other websites. These links are provided for your convenience to provide further information. They do not signify that we endorse the website(s). We have no responsibility for the content of the linked website(s).</div>
        </div>

        </div>
      </div>

  </div>
</div>
@endsection