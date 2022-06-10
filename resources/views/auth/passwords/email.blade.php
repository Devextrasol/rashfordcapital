@extends('layouts.auth_new')
@section('title')
{{ __('auth.reset') }}
@endsection
@section('before-auth')
<div id="particles"></div>
@endsection
@section('auth')
<!-- --------Header------------->
<header class="branding">
  <div class="custom-container ui container">
    <a href="{{ route('frontend.index') }}"><img src="{{ asset('images/logo-ing.png') }}" class="main-logo hide-logo" alt=""></a>
  </div>
</header>
<!------------ Body------------>
<article>
  <div class="custom-column ui container">
    <div class="ui stackable two column grid">
      <div class="nine wide column"><div class="care-center"><img src="{{ asset('images/Reset-password.png') }}" class="care-img ui fluid image care-img" alt=""></div></div>
      <div class="custom-style seven wide column">
        <div class="sign-up-form new-form reset-form">
          @component('components.session.messages')
          @endcomponent
          <loading-form v-cloak inline-template>
          <form class="" method="POST" action="{{ route('password.email') }}" @submit="disableButton">
            {{ csrf_field() }}
            <h2 class="plz-login">Reset Your Password!</h2>
            <p class="no-account">We are here to help you to recover password.<br>Enter the Email address you used when you joined.
            </p>
            <div class="field{{ $errors->has('email') ? ' error' : '' }}">
              <input type="email" placeholder="Enter Email" name="email" id="email" value="{{ old('email') }}" required autofocus>
              <label for="email">{{ __('auth.email') }} Address</label>
            </div>
            @if(config('settings.recaptcha.public_key'))
            <div class="field">
              <div class="g-recaptcha" data-sitekey="{{ config('settings.recaptcha.public_key') }}" data-theme="{{ $inverted ? 'dark' : 'light' }}"></div>
            </div>
            @endif
            <button class="reset-pass [{disabled: submitted, loading: submitted}, 'ui {{ $settings->color }} fluid large submit button']">{{ __('auth.reset') }}</button>
          </form>
          </loading-form>
        </div>
      </div>
    </div>
  </div>
</article>
<!---------End Body---------------->
@endsection
@push('scripts')
<script type="text/javascript" src="{{ asset('js/auth.js') }}"></script>
@if(config('settings.recaptcha.public_key'))
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endif
@endpush