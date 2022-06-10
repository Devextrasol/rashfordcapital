@extends('layouts.auth_new')
@section('title')
{{ __('auth.login') }}
@endsection
@section('before-auth')
<div id="particles"></div>
@endsection
@section('auth')
<!-- --------Header------------->
{{-- <header class="branding">
  <div class="custom-container ui container">
    <a href="{{ route('frontend.index') }}"><img src="{{ asset('images/home-logo.png') }}" class="login-logo main-logo" alt=""></a>
  </div>
</header> --}}
<!------------ Body---------------->
<article>
  <div class="custom-column ui">
    <div class="ui stackable two column grid">
      <div class="custom-style seven wide column">
      <div class="sign-up-form">
        <div class="main-logo">
          <a href="/">
            <img src="{{ asset('images/png-logo.svg') }}" class="ui fluid image care-img" alt="">
          </a>
        </div>
        @component('components.session.messages')
        @endcomponent
        <loading-form v-cloak inline-template>
        <form class="" method="POST" action="{{ route('login') }}" @submit="disableButton">
          {{ csrf_field() }}
          <h2 class="plz-login">Please Login Your Account!</h2>
          <p class="no-account">Don't have an account? <br class="desktop only"> Create your account, it takes less then a minute.</p>
          <a href="{{ route('register') }}" class="sign-up form-button">Sign Up</a>

          <div class="field">
            <?php
            $debug = true;
            if($debug){
              //$email = 'faisal.aqurz@gmail.com';
              //$pass = 'admin';
            }
            ?>
            <input type="text" name="email" id="email" placeholder="Enter {{ __('auth.email') }}" value="{{ old('email') }}" required value="{{@$email}}">
            <label for="email">{{ __('auth.email') }} Address</label>
          </div>

          <div class="field">
            <input type="password" name="password" id="password" placeholder="Enter {{ __('auth.password') }}" required value="{{@$pass}}">
            <label for="password">{{ __('auth.password') }}</label>
          </div>

          <div class="field checkbox">

            <div class="ui checkbox">
              <input type="checkbox" name="remember" tabindex="0" class="hidden" {{ old('remember') ? 'checked="checked"' : '' }}>
              <label for="remember">{{ __('auth.remember') }}</label>
            </div>
            <a href="{{ route('password.request') }}" class="forget-pass hover" >Forget Password</a>

          </div>


          @if(config('settings.recaptcha.public_key'))
            <div class="field">
              <div class="g-recaptcha" data-sitekey="{{ config('settings.recaptcha.public_key') }}" data-theme="{{ $inverted ? 'dark' : 'light' }}"></div>
            </div>
          @endif

          <button class="[{disabled: submitted, loading: submitted}, 'ui {{ $settings->color }} fluid large submit button']" type="submit">Login</button>

          {{-- <div class="submit-btn"><button :class="[{disabled: submitted, loading: submitted}, 'ui {{ $settings->color }} fluid large submit button']">{{ __('auth.login') }}</button></div> --}}
          <a href="{{ url('page/terms-of-use') }}">Term and Conditions</a>
          <a href="{{ url('page/privacy-policy') }}">Privacy Policy</a>
        </form>
        </loading-form>
        @social
        <div id="social-login-divider" class="ui horizontal divider">
          {{ __('auth.social_login') }}
        </div>
        <div>
          @social('facebook')
          <a href="{{ url('login/facebook') }}" class="ui circular facebook icon button">
            <i class="facebook icon"></i>
          </a>
          @endsocial
          @social('twitter')
          <a href="{{ url('login/twitter') }}" class="ui circular twitter icon button">
            <i class="twitter icon"></i>
          </a>
          @endsocial
          @social('linkedin')
          <a href="{{ url('login/linkedin') }}" class="ui circular linkedin icon button">
            <i class="linkedin icon"></i>
          </a>
          @endsocial
          @social('google')
          <a href="{{ url('login/google') }}" class="ui circular google plus icon button">
            <i class="google plus icon"></i>
          </a>
          @endsocial
        </div>
        @endsocial
      </div>
    </div>
      <div class="nine wide column"><div class="care-center-2">
        <img src="{{ asset('images/login.jpg') }}" class="ui fluid image care-img" alt="">
      </div>
    </div>
    
  </div>
</div>
</article>
<!-----------End Body--------------->
@endsection
@push('scripts')
<script type="text/javascript" src="{{ asset('js/auth.js') }}"></script>
@if(config('settings.recaptcha.public_key'))
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endif
@endpush
