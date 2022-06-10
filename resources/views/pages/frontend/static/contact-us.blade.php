@extends('layouts.frontend_new')

@section('content')
	 <!-- ----------HEADER---------- -->
    <header>
      <div class="header-contact">

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
            <a href="{{ route('frontend.index') }}" class="hide-logo hind-mobile"><img src="{{ asset('images/home-logo.png') }}" alt="" class="contact-logo home-logo"></a>
            <a href="{{ route('frontend.index') }}" class="hide-a"><img src="{{ asset('images/home-logo.png') }}" alt="" class="ui fluid image home-logo desktop-logo"></a>
            <div class="responsive-icon">
           
            <img src="{{ asset('images/search-icon.png') }}" alt="" id="search">
            <img src="{{ asset('images/menu-bar.png') }}" alt="" id="menu-btn">
            <span class="close-text">Close</span><img src="{{ asset('images/menu-x.png') }}" alt="" id="menu-close">
            </div>
          </div>
          <div class="sixteen wide tablet ten wide computer column" id="menu-ul">
            <ul class="mobile-only contact-ul" >
              <li class="mobile-only">
                  <a href="{{ route('login') }}" class="nav-link "><button>Login</button></a>
                  <a href="{{ route('register') }}" class="nav-link"><button class="trending-btn">Start Trading</button></a>

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
              <li><a href="{{ route('login') }}" class="nav-link hide login-btn"><button>Login</button></a></li>
              <li><a href="{{ route('register') }}" class="nav-link hide trd-btn"><button class="trending-btn" >Start Trading</button></a></li>
              <li><a href="" class="nav-link">Eng <img src="{{ asset('images/arrow.png') }}" alt=""></a>
               
              </li>
              <li class="mobile-only">
                  <a href="" class="nav-link"><i class="twitter sign icon"></i></a>
                  <a href="" class="nav-link"><i class="facebook sign icon"></i></a>

              </li>
              <li class="hidden" ><a href="javascript:;" class="nav-link search-icon align-item search-padding" id="search-trigger">
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
    <!-- -------contact-us section------- -->
    <div class="contact-us">
      <div class="ui main container">
        <div class="ui two column doubling stackable grid container contact-form">
          <div class="column">
              <h1 class="contact-heading">Send us an Email</h1>
              <p>The response time may be longer than usual, due to the high number of new traders. We are working around the clock to speed up the process. Thank you for your patience.</p>
              <form class="ui form">
                <div class="field">
                  <select class="ui fluid dropdown" style="border-radius: 10px;">
                    <option value="">Reason of Request</option>
                  <option value="AL">Customer Service</option>
                  <option value="AK">Support</option>
                  <option value="AZ">Dealing Room</option>
                  <option value="AR">Finance Department</option>
                  </select>
                </div>
              <div class="field">
                <div class="two fields">
                  <div class="field">
                    <input type="text" name="name" placeholder="Name" style="border-radius: 10px;">
                  </div>
                  <div class="field">
                    <input type="text" name="surname" placeholder="Sur Name" style="border-radius: 10px;">
                  </div>
                </div>
              </div>
              <div class="field">
                <input type="text" placeholder="Email" style="border-radius: 10px;">
              </div>
              <div class="field">
                <input type="text" placeholder="Phone Number" style="border-radius: 10px;">
              </div>
              <div class="field">
                <input type="text" placeholder="Subject" style="border-radius: 10px;">
              </div>
              <div class="field">
                <textarea rows="8" placeholder="Your Message" style="border-radius: 10px;"></textarea>
              </div>
              <div class="ui button submit-btn" tabindex="0">SEND MESSAGE</div>
            </form>
          </div>
          <div class="column content-block">
            <h1 class="contact-heading">Trading Hours</h1>
            <p>Unlike trading stocks and commodities, the cryptocurrency market isn’t traded on a regulated exchange. Rather, the market is open 24/7 across a growing number of exchanges.
      Successful crypto traders understand that, although the market for digital currency is open nonstop</p>
            <h1 class="contact-heading">Holiday Trading Hours</h1>
            <p>Unlike other centralized markets or any trading stock markets, cryptocurrency market can't be 'closed'. It has no holidays or breaks. Some centralized exchanges may shut temporarily to update the servers, etc but these moments are really rare. Online crypto exchanges are way more dynamic than stocks-and-bonds ones.</p>
            <h1 class="contact-heading">Phone Number</h1>
              <p><b>UK:</b> <a href="tel:+442070488128">+442070488128</a></p>
              <p><b>Whatsapp:</b><a href="tel:+447405326797">+447405326797</a></p>  
              <p><b>EMAIL:</b><a href="mailto:support@zurich-group.uk">support@zurich-group.uk</a></p>
          </div>
        </div>
  </div>
</div> 
@endsection