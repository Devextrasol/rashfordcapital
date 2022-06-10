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
          <h1 class="PHeadinh-h1">Copyright</h1>
          <p >Copyright © 2019, 2015, 2011 Author Name</p>
          <h1 class="Headinh-hlight">Information Collection, Use, and Sharing</h1>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Recusandae veritatis, vel laborum consectetur tempore molestiae, numquam fugit at quam quae dolorem eligendi voluptatem aperiam sequi iste. Voluptates iste, numquam omnis.</p>
          <h1 class="Headinh-hlight">Lorem ipsum</h1>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa voluptatem, quisquam unde et atque rerum eveniet numquam quasi illo dolores suscipit quam cupiditate exercitationem totam veritatis est blanditiis dolorum, dignissimos.</p>
          <h1 class="Headinh-hlight">What is Lorem Ipsum?</h1>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Temporibus reprehenderit, amet architecto. Esse, minima sint aut similique, id temporibus eos praesentium tempore harum rem nihil consequatur quisquam perspiciatis, cumque, pariatur.</p>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A, temporibus distinctio! Asperiores illo at ipsum, veritatis, fuga ullam laudantium hic recusandae ut rem placeat minima eaque, necessitatibus enim, libero cupiditate!</p>
          <h1 class="Headinh-hlight">Why do we use it?</h1>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorum fugit incidunt nam autem possimus, ipsam facere provident ipsum totam eum libero in a repudiandae laborum, ullam quibusdam ut, voluptatum ea!</p>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Totam explicabo culpa nisi, impedit, ipsam odit. Deserunt praesentium tempora, et quae repellat perspiciatis? Tempore error ad facere sint iste alias nam.</p>
          <h1 class="Headinh-hlight">Where does it come from?</h1>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque ipsum sint et earum nam cumque, quia molestias aut temporibus consequuntur hic fuga, laborum, autem voluptatem eum expedita assumenda fugiat dolorem!.</p>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis consequatur illum numquam ea quas libero, blanditiis odio id! Cumque aut, dolores quasi cum ut molestias quas ad maxime non vel.</p>

        </div>
      </div>

  </div>
</div>
@endsection