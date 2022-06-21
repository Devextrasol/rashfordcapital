<!--   ------Footer ------ -->
<!--   ------PAYMENTS------ -->

<div class="payment-methods swiper">
  <div class="swiper-wrapper">
    <div class="payment-logo swiper-slide"><img src="{{ asset('images/footer-logo-1.png') }}" class="ui fluid image footer-logo-1"></div>
    <div class="payment-logo swiper-slide"><img src="{{ asset('images/footer-logo-2.png') }}" class="ui fluid image footer-logo-2"></div>
    <div class="payment-logo swiper-slide"><img src="{{ asset('images/footer-logo-3.png') }}" class="ui fluid image footer-logo-3"></div>
    <div class="payment-logo swiper-slide"><img src="{{ asset('images/footer-logo-4.png') }}" class="ui fluid image footer-logo-4"></div>
    <div class="payment-logo swiper-slide"><img src="{{ asset('images/footer-logo-5.png') }}" class="ui fluid image footer-logo-5"></div>
    <div class="payment-logo swiper-slide"><img src="{{ asset('images/footer-logo-6.png') }}" class="ui fluid image footer-logo-6"></div>
    <div class="payment-logo swiper-slide"><img src="{{ asset('images/footer-logo-7.png') }}" class="ui fluid image footer-logo-7"></div>
    <div class="payment-logo swiper-slide"><img src="{{ asset('images/footer-logo-8.png') }}" class="ui fluid image footer-logo-8"></div>
  </div>
</div> 

<div class="connection ">
{{-- <h2 class="Headinh-h1 text-center font-weight">{{ env('_app_name_f') }} in 2019</h2><br> --}}
  <div class="ui grid  ui main container">
    <div class="five column row custom-design" id="inview-example">
      <div class="sixteen wide tablet four wide computer column my-column">
        <div class="column-inner">
        <h1 class="Headinh-h1"><span class="timer" data-count="5">5</span><span>+</span></h1>
        <p>Millions</p>
        <p>positions opened</p>
      </div></div>
      <div class="sixteen wide tablet four wide computer column my-column center-col">
        <div class="column-inner">
        <h1 class="Headinh-h1"><span class="timer" data-count="100">100</span><span>+</span></h1>
        <p>thousands</p>
        <p>active customers</p>
      </div></div>
      <div class="sixteen wide tablet four wide computer column my-column">
        <div class="column-inner">
        <h1 class="Headinh-h1"><span class="timer" data-count="900">900</span><span>+</span></h1>
        <p>Millions</p>
        <p>traded value</p>
      </div></div>
    </div>
  </div>
</div>

<!--   ------trading at your fingertips ------ -->


<div class="trade">
  <h2 class="Headinh-h1 text-center h2-color">Trading at your fingertips</h2>
    <p class="text-center h2-color">Trade anywhere, anytime using our innovative platform.</p>
  <div class="ui grid ui main container newsite">

    <div class="five column row my-padding-class">
      <div class="column">
        <div class="my-content">
          <img src="{{ asset('images/trade-apple.png') }}" class="ui fluid image">
          <p class="mobile-only ">iPhone / IPad</p>
        </div>
      </div>
      <div class="column">
        <div class="my-content">
          <img src="{{ asset('images/trade-android.png') }}" class="ui fluid image">
          <p class="mobile-only">Android</p>
        </div>
      </div>
      <div class="column">
        <div class="my-content">
          <img src="{{ asset('images/trade-window-phone.png') }}" class="ui fluid image" style="width: 113px">
          <p class="mobile-only">Windows Phone</p>
        </div>
      </div>
      <div class="column">
        <div class="my-content">
          <img src="{{ asset('images/trade-windows.png') }}" class="ui fluid image" style="width: 113px">
          <p class="mobile-only">Windows</p>
        </div>
      </div>
      <div class="column">
        <div class="my-content">
          <img src="{{ asset('images/trade-web.png') }}" class="ui fluid image">
          <p class="mobile-only">Web Trader</p>
        </div>
    </div>
    </div>
    <a href="{{ route('register') }}" class="trending-btn-2 trade">start trading</a>
  </div>
</div>
<footer class="footer-contact-us">
  <div class="footer row-1">
    <div class="footer-column-1">
      <div class="footer-logo"><a href="{{ route('frontend.index') }}"><img src="{{ asset('images/logo-footer.svg') }}" alt="" class="home-logo my-logo"></a></div>
      <p>Remember, Crypto Trading CFD is a leveraged product and can cause you to lose all your capital. Trading with Crypto Trading CFD may not be suitable for you</p>
      <p>Please make sure you fully understand the risks involved.</p>
      <p>Rashfordcapital services are mostly paid by using the Offer</p>
      <p>Rashfordcapital is a trademark of Rashfordcapital Ltd.</p>
      <p>SSL protected .</p>
  </div>
  <div class="footer-column-2">
    <ul>
      <li>Explore</li>
      <li><a href="{{ url('page/about-us') }}">About Us</a></li>
      <li><a href="{{ url('page/terms-of-use') }}">AML Policy</a></li>
      <li><a href="{{ url('page/privacy-policy') }}">Privacy Policy</a></li>
      <li><a href="{{ url('page/terms-of-use') }}">Terms and Conditions</a></li>
      <li><a href="{{ url('page/contact-us') }}">Contact Us</a></li>
    </ul>
  </div>
  <div class="footer-column-3">
    <ul>
      <li>Follow Us</li>
      <li><a href="" title="Facebook">Facebook</a></li>
      <li><a href="" title="Twitter">Twitter</a></li>
    </ul>
  </div>
</div>
<div class="footer row-2"><p>Copyright: Rashfordcapital. All rights reserved.</p></div>
</footer>
