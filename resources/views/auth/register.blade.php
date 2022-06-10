@extends('layouts.auth_new')
@section('title')
{{ __('auth.sign_up') }}
@endsection
@section('before-auth')
<div id="particles"></div>
@endsection
@section('auth')
<!------------ Header----------------->
<header class="branding">
  <div class="custom-container ui container">
    <a href="{{ route('frontend.index') }}"><img src="{{ asset('images/home-logo.png') }}" class="login-logo main-logo" alt=""></a>
  </div>
</header>
<!-------------body------------------->
<article>
  <div class="custom-column ui container">
    <div class="ui stackable two column grid">
      <div class="nine wide column"><div class="care-center"><img src="{{ asset('images/login-illustration_03.png') }}" class="ui fluid image care-img" alt=""></div></div>
      <div class="custom-style seven wide column">
        <div class="sign-up-form new-form">
          @component('components.session.messages')
          @endcomponent
          <loading-form v-cloak inline-template>
          <form class="" method="POST" action="{{ route('register') }}" @submit="disableButton">
            {{ csrf_field() }}
            <h2 class="plz-login">{{ env('_app_name_f') }} Sign Up!</h2>
            <p class="no-account">Don't have an account? Create your account, it takes less then a minute.</p>
            <div class="field{{ $errors->has('email') ? ' error' : '' }}">
              <input type="email" placeholder="Enter Email" name="email" id="email" value="{{ old('email') }}" autofocus required>
              <label for="email">{{ __('auth.email') }} Address</label>
            </div>
            <div class="field{{ $errors->has('password') ? ' error' : '' }}">
              <input type="password" placeholder="Enter Password" id="password" name="password" required>
              <label for="password">Choose Password</label>
            </div>
            <div class="field{{ $errors->has('password') ? ' error' : '' }}">
              <input type="password" placeholder="Confirm Password" name="password_confirmation" id="password_confirmation" required>
              <label for="password_confirmation">Please Confirm Password</label>
            </div>
            <div class="field{{ $errors->has('name') ? ' error' : '' }}">
              <input type="text" placeholder="First Name" name="name" value="{{ old('name') }}" id="name" required>
              <label for="name">First Name</label>
            </div>
            <div class="field{{ $errors->has('last_name') ? ' error' : '' }}">
              <input type="text" placeholder="Last Name" name="last_name" id="last_name" value="{{ old('last_name') }}" required>
              <label for="last_name">Last Name</label>
            </div>
            <div class="field{{ $errors->has('country') ? ' error' : '' }}">
              <select name="country" id="country" value="{{ old('country') }}" required>
                @include('includes.frontend.country_options')
              </select>
              <label for="country">Country</label>
            </div>
            <div class="field{{ $errors->has('phone') ? ' error' : '' }}">
              <input type="text" placeholder="Phone" id="phone" name="phone" value="{{ old('phone') }}" required>
              <label for="phone">Phone</label>
            </div>
            @if(config('settings.recaptcha.public_key'))
            <div class="field">
              <div class="g-recaptcha" data-sitekey="{{ config('settings.recaptcha.public_key') }}" data-theme="{{ $inverted ? 'dark' : 'light' }}"></div>
            </div>
            @endif
            <button class="[{disabled: submitted, loading: submitted}, 'ui {{ $settings->color }} fluid large submit button']">{{ __('auth.sign_up') }}</button>
            <a href="{{ url('page/privacy-policy') }}" class="term-and-condition hover">Term and Conditions</a>
            <a href="{{ url('page/terms-of-use') }}" class="privacy-policy hover">Privacy Policy</a>
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
    </div>
  </div>
</article>
<!-------------End body--------------->
@endsection
@push('scripts')
<script type="text/javascript" src="{{ asset('js/auth.js') }}"></script>
@if(config('settings.recaptcha.public_key'))
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endif
@endpush
