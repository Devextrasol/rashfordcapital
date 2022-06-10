@php
    $competition = \App\Models\Competition::all()->last();
@endphp

<ul class="sidebar-nav">
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

    @if(config('broadcasting.connections.pusher.key'))
        <li class="item-support">
            <a href="{{ route('frontend.chat.index') }}" class="item {{ Route::currentRouteName()=='frontend.chat.index' ? 'active' : '' }}">
                {{ __('app.chat') }}
            </a>
        </li>
    @endif
</ul>