<div id="footer" class="ui inverted vertical segment">
    <div class="ui container">
        <div class="ui equal width middle aligned grid">
            <div class="row">
                <div class="left aligned column">
                    <h4 class="ui inverted header">
                     <a href="{{ route('frontend.index') }}">
                        <img src="{{ asset('images/front-logo.png') }}" class="logo">
                     </a>
                 {{--        <img src="{{ asset('images/home-logo.png') }}" class="ui tiny image">
                        {{ __('app.app_name') }} --}}
                    </h4>
                </div>
                <div class="right aligned column">
                    <div class="ui inverted horizontal link list">
                        <a href="{{ url('page/privacy-policy') }}" class="item">{{ __('app.privacy_policy') }}</a>
                        <a href="{{ url('page/terms-of-use') }}" class="item">{{ __('app.terms_of_use') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>