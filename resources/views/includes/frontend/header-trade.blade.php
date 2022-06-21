@php
    $competition = \App\Models\Competition::all()->last();
@endphp
 
<div id="header" class="trade">
    <div class="ui inverted vertical masthead center aligned segment">
        <div class="ui container-fluid">
            <div class="ui stackable three column grid spacer">
              <div class="four wide column desktop-style">
                  <h1 class="ui blue header">{{ __('app.trade') }}</h1>
                  <div class="mobile-only right aligned column">
                        <locale-select :locales="{{ json_encode($locale->locales()) }}" :locale="{{ json_encode($locale->locale()) }}"></locale-select>
                    </div>
              </div>
              <div class="eight wide column">
                  @if(Route::currentRouteName()=='frontend.competitions.show')
                    <div id="asset-search" class="ui tablet-and-below-center  {{ $inverted }} search">
                      <div class="ui icon input">
                        <input class="prompt" type="text" placeholder="{{ __('app.search') }}">
                        <i class="search icon"></i>
                      </div>
                      <div class="search-results"></div>

                    </div>
                @endif
              </div>
              <div class="four wide column desktop-only">
                  <div class="mobile only right aligned column">
                        <locale-select :locales="{{ json_encode($locale->locales()) }}" :locale="{{ json_encode($locale->locale()) }}"></locale-select>
                    </div>
              </div>
            </div>
        </div>
    </div>
<div class="ui container">
    <div class="ui equal width middle aligned grid">
        <div id="menu-top-bar" class="row">
            <div class="mobile only column">
                <!-- Mobile menu -->
                <div class="ui vertical icon {{ $inverted }} menu">
                    <div class="ui left pointing dropdown icon item">
                        <i class="bars icon"></i>
                        <div class="ui stackable large menu">
                            {{-- <a href="{{ route('frontend.dashboard') }}" class="item {{ Route::currentRouteName()=='frontend.dashboard' ? 'active' : '' }}">
                                <i class="home icon"></i>
                                {{ __('app.dashboard') }}
                            </a> --}}
                            <a href="{{ route('frontend.competitions.index') }}" class="item {{ strpos(Route::currentRouteName(),'frontend.competitions.')!==FALSE ? 'active' : '' }}">
                                <i class="trophy icon"></i>
                                {{ __('app.trade') }}
                            </a>

                            <a href="{{ route('frontend.competitions.history', $competition) }}" class="test item {{ Route::currentRouteName()=='frontend.competitions.history' ? 'active' : '' }}">
                                <i class="history icon"></i>
                                {{ __('app.history') }}
                            </a>

                            <a href="{{ route('frontend.assets.index') }}" class="item {{ Route::currentRouteName()=='frontend.assets.index' ? 'active' : '' }}">
                                <i class="bitcoin icon"></i>
                                {{ __('app.coins') }}
                            </a>

                            @if(config('broadcasting.connections.pusher.key'))
                                <a href="{{ route('frontend.chat.index') }}" class="item {{ Route::currentRouteName()=='frontend.chat.index' ? 'active' : '' }}">
                                    <i class="comments outline icon"></i>
                                    {{ __('app.chat') }}
                                </a>
                            @endif
                            <a href="{{ route('frontend.help') }}" class="item {{ Route::currentRouteName()=='frontend.help' ? 'active' : '' }}">
                                <i class="question icon"></i>
                                {{ __('app.help') }}
                            </a>
                            @if(auth()->check())
                                <div class="item">
                                    <div class="text">
                                        <img class="ui avatar image" src="{{ auth()->user()->avatar_url }}">
                                        {{ auth()->user()->name }}
                                    </div>
                                    <div class="menu">
                                        @if(auth()->user()->admin())
                                            <a href="{{ route('backend.dashboard') }}" class="item">
                                                <i class="setting icon"></i>
                                                {{ __('app.backend') }}
                                            </a>
                                        @endif
                                        <a href="{{ route('frontend.users.show', auth()->user()) }}" class="item">
                                            <i class="user icon"></i>
                                            {{ __('users.profile') }}
                                        </a>

                                        @packageview('includes.frontend.header')

                                        <log-out-button token="{{ csrf_token() }}" class="item">
                                            <i class="sign out alternate icon"></i>
                                            {{ __('auth.logout') }}
                                        </log-out-button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- END Mobile menu -->
            </div>
        </div>
        {{-- <div class="row">
            <div class="tablet only computer only column">

                <div class="ui stackable {{ $inverted }} menu">
                    <a href="{{ route('frontend.dashboard') }}" class="item {{ Route::currentRouteName()=='frontend.dashboard' ? 'active' : '' }}">
                        <i class="home icon"></i>
                        {{ __('app.dashboard') }}
                    </a>
                    <a href="{{ route('frontend.competitions.index') }}" class="item {{ strpos(Route::currentRouteName(),'frontend.competitions.')!==FALSE ? 'active' : '' }}">
                        <i class="trophy icon"></i>
                        {{ __('app.competitions') }}
                    </a>
                    <a href="{{ route('frontend.assets.index') }}" class="item {{ Route::currentRouteName()=='frontend.assets.index' ? 'active' : '' }}">
                        <i class="bitcoin icon"></i>
                        {{ __('app.coins') }}
                    </a>
                    @if(config('broadcasting.connections.pusher.key'))
                        <a href="{{ route('frontend.chat.index') }}" class="item {{ Route::currentRouteName()=='frontend.chat.index' ? 'active' : '' }}">
                            <i class="comments outline icon"></i>
                            {{ __('app.chat') }}
                        </a>
                    @endif
                    <a href="{{ route('frontend.help') }}" class="item {{ Route::currentRouteName()=='frontend.help' ? 'active' : '' }}">
                        <i class="question icon"></i>
                    </a>
                    @if(auth()->check())
                        <div class="right menu">
                            <div class="ui item dropdown">
                                <div class="text">
                                    <img class="ui avatar image" src="{{ auth()->user()->avatar_url }}">
                                    {{ auth()->user()->name }}
                                </div>
                                <i class="dropdown icon"></i>
                                <div class="menu">
                                    @if(auth()->user()->admin())
                                        <a href="{{ route('backend.dashboard') }}" class="item">
                                            <i class="setting icon"></i>
                                            {{ __('app.backend') }}
                                        </a>
                                    @endif
                                    <a href="{{ route('frontend.users.show', auth()->user()) }}" class="item">
                                        <i class="user icon"></i>
                                        {{ __('users.profile') }}
                                    </a>

                                    @packageview('includes.frontend.header')

                                    <log-out-button token="{{ csrf_token() }}" class="item">
                                        <i class="sign out alternate icon"></i>
                                        {{ __('auth.logout') }}
                                    </log-out-button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div> --}}
    </div>
</div>
@packageview('includes.frontend.accountinfo')
{{-- <div class="account-info">
    <div class="inner-content">
        <h3>Balance</h3>
        <p><span>10,001.44</span></p>
    </div>
    <div class="inner-content">
        <h3>win/loss</h3>
        <p><span>287.07</span></p>
    </div>
    <div class="inner-content">
        <h3>EQUITY</h3>
        <p><span>9,715.25</span></p>
    </div>
    <div class="inner-content">
        <h3>MARGIN</h3>
        <p><span>590.26</span></p>
    </div>
    <div class="inner-content">
        <h3>FREE MARGIN</h3>
        <p><span>9,124.12</span></p>
    </div>
    <div class="inner-content">
        <h3>MARGIN LEVEL</h3>
        <p><span>1,645.78%</span></p>
    </div>
</div> --}}
</div>