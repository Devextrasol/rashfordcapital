@php
    $competition = \App\Models\Competition::all()->last();
@endphp

<div id="header">
    <div class="ui inverted vertical masthead center aligned segment">
        <div class="ui container-fluid">
            <div class="ui equal width middle aligned grid">
                <div class="row">
                    <div class="left aligned column">
                        @if(auth()->check())
                            <a href="{{ route('frontend.competitions.index') }}">
                                <img src="{{ asset('images/home-logo.png') }}" class="logo">
                                {{-- {{ __('app.app_name') }} --}}
                            </a>
                        @else
                            <a href="{{ route('frontend.index') }}">
                                <img src="{{ asset('images/home-logo.png') }}" class="logo">
                                {{-- {{ __('app.app_name') }} --}}
                            </a>
                        @endif
                    </div>
                    <div class="mobile only right aligned column">
                        <locale-select :locales="{{ json_encode($locale->locales()) }}" :locale="{{ json_encode($locale->locale()) }}"></locale-select>
                    </div>
                     <div class="tablet only computer only right aligned column">
                        <ul class="primary-nav">
                           {{--  <li>
                                 <a href="{{ route('frontend.competitions.index') }}" class="item {{ strpos(Route::currentRouteName(),'frontend.competitions.')!==FALSE ? 'active' : '' }}">
                                    <i class="trophy icon"></i>
                                    {{ __('app.trade') }}

                                </a>
                            </li>
                            <li>
                                <a href="{{ route('frontend.help') }}" class="item {{ Route::currentRouteName()=='frontend.help' ? 'active' : '' }}">
                                    <i class="question icon"></i>
                                    {{ __('app.help') }}
                                </a>
                            </li> --}}
                            @if(auth()->check())
                                <li>
                                    <div class="right menu aqurzzz-menu-1">
                                        @if(session()-> has('impersonate_by'))
                                            <div class="ui item">
                                                <a href="/admin/imperstop" class="item">
                                                    <i class="setting icon"></i>
                                                    Back to Admin
                                                </a>
                                            </div>
                                        @endif



                                        <div class="ui item dropdown">
                                            <div class="text">
                                                <img class="ui avatar image" src="{{ auth()->user()->avatar_url }}">
                                                {{ auth()->user()->name }}
                                            </div>
                                            <i class="chevron down icon"></i>
                                            <div class="menu">

                                                @if(in_array(auth()->user()->role , ['ADMIN' , 'FLOOR_MANAGER' , 'SALES']))
                                                    <a href="{{ route('backend.dashboard') }}?dashboard" class="item">
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
                                </li>
                            @endif
                            <li>
                                <locale-select :locales="{{ json_encode($locale->locales()) }}" :locale="{{ json_encode($locale->locale()) }}"></locale-select>
                            </li>
                        </ul>
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

                            <a href="{{ route('frontend.competitions.history', $competition) }}" class="item {{ Route::currentRouteName()=='frontend.competitions.history' ? 'active' : '' }}">
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
</div>
