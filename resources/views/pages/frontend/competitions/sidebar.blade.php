@php
    $competition = \App\Models\Competition::all()->last();
@endphp

<ul class="sidebar-nav">
    <li>
        <div class="sidebar-top">
            <a href="">
                <img src="/images/dashlogo.png">
            </a>
            <a  href="{{ url()->previous() }}">
                <img src="/images/backtopreve.png">
            </a>
        </div>
    </li> 
    @if(auth()->check())
        <li class="item-account">
            @packageview('includes.frontend.header') 
        </li>
    @endif
        <li class="item-trade"> 
            <a href="{{ route('frontend.competitions.index') }}" class="item {{ Route::currentRouteName()=='frontend.competitions.show' ? 'active' : '' }}">

            {{-- <a href="{{ route('frontend.competitions.index') }}" class="item {{ strpos(Route::currentRouteName(),'frontend.competitions.')!==FALSE ? 'active' : '' }}"> --}}
                {{ __('app.trade') }}
            </a>
        </li>
    {{-- @endif --}}

    {{-- @if($participant) --}}
        <li class="item-trade-history">
            <a href="{{ route('frontend.competitions.history', $competition) }}" class="item {{ Route::currentRouteName()=='frontend.competitions.history' ? 'active' : '' }}">
                {{ __('app.history') }}
            </a>
        </li>
    {{-- @endif --}}

    <li class="item-coins">
        <a href="{{ route('frontend.assets.index') }}" class="item {{ Route::currentRouteName()=='frontend.assets.index' ? 'active' : '' }}">
            {{ __('app.coins') }}
        </a>
    </li>
    <li class="item-deposit">
        @packageview('includes.frontend.deposit')
    </li>
    <li class="item-withdrawls">
        @packageview('includes.frontend.withdrawal')
    </li> 
    <li>
        <p class="more-links">more</p>
    </li>
    <li class="item-club">
        <a href="{{ route('frontend.assets.index') }}" class="item">
            {{ __('Rashford Club') }}
        </a>
    </li>
     <li class="item-friends">
        <a href="{{ route('frontend.assets.index') }}" class="item">
            {{ __('Invite Friends') }}
        </a>
    </li>
    <li class="item-funds">
        <a href="{{ route('frontend.assets.index') }}" class="item">
            {{ __('Withdrow Funds') }}
        </a>
    </li>
    <li class="item-settings">
        <a href="" class="item">
           Settings
        </a>
    </li>
    <li class="item-help">
        <a href="{{ route('frontend.assets.index') }}" class="item">
            {{ __('Help') }}
        </a>
    </li>
    <li class="item-logout">
         <log-out-button token="{{ csrf_token() }}" class="item">
        <i class="sign out alternate icon"></i>
        {{ __('auth.logout') }}
    </log-out-button>
    </li>
    
    @if(config('broadcasting.connections.pusher.key'))
        <li class="item-support">
            <a href="{{ route('frontend.chat.index') }}" class="item {{ Route::currentRouteName()=='frontend.chat.index' ? 'active' : '' }}">
                {{ __('app.chat') }}
            </a>
        </li>
    @endif
</ul>