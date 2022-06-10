<div id="backend-sidebar" class="ui left vertical {{ $inverted }} menu sidebar">
  <div class="header item aqurz-sidebar-1">{{ __('app.frontend') }}</div>
  <a href="{{ route('frontend.index') }}" class="item">
    {{ __('app.home_page') }}
    <i class="home icon"></i>
  </a>
  <div class="header item aqurz-sidebar-2">{{ __('app.backend') }}</div>
  <a href="{{ route('backend.dashboard') }}" class="item{{ Route::currentRouteName()=='backend.dashboard' ? ' active' : '' }}">
    {{ __('app.dashboard') }}
    <i class="heartbeat icon"></i>
  </a>
  {{--role base menu listing--}}
  <?php if(auth()->user()->role == 'ADMIN'){ ?>


  <a href="{{ route('backend.assets.index') }}" class="item{{ strpos(Route::currentRouteName(),'backend.assets.')!==FALSE ? ' active' : '' }}">
    {{ __('app.assets') }}
    <i class="bitcoin icon"></i>
  </a>
  <a href="{{ route('backend.competitions.index') }}" class="item{{ strpos(Route::currentRouteName(),'backend.competitions.')!==FALSE ? ' active' : '' }}">
    {{ __('app.competitions') }}
    <i class="trophy icon"></i>
  </a>
  <a href="{{ route('backend.trades.index') }}" class="item{{ strpos(Route::currentRouteName(),'backend.trades.')!==FALSE ? ' active' : '' }}">
    {{ __('app.trades') }}
    <i class="retweet icon"></i>
  </a>
  <a href="{{ route('backend.users.index') }}" class="item{{ strpos(request()->fullUrl(),'admin/users')!==FALSE ? ' active' : '' }}">
    {{ __('users.users') }}
    <i class="users icon"></i>
  </a>

  <a href="{{ route('backend.leads') }}" class="item{{ strpos(Route::currentRouteName(),'backend.leads')!==FALSE ? ' active' : '' }}">
    Traders
    <i class="users icon"></i>
  </a>
  <a href="{{ route('backend.users.atsleads') }}" class="item{{ strpos(Route::currentRouteName(),'backend.users.atsleads')!==FALSE ? ' active' : '' }}">
    Leads
    <i class="users icon"></i>
  </a>

  @packageview('includes.backend.header')

  <a href="{{ route('backend.addons.index') }}" class="item{{ strpos(Route::currentRouteName(),'backend.addons.')!==FALSE ? ' active' : '' }}">
    {{ __('settings.addons') }}
    <i class="codepen icon"></i>
  </a>
  <a href="{{ route('backend.settings.index') }}" class="item{{ strpos(Route::currentRouteName(),'backend.settings.')!==FALSE ? ' active' : '' }}">
    {{ __('settings.settings') }}
    <i class="settings icon"></i>
  </a>
  <a href="{{ route('backend.maintenance.index') }}" class="item{{ strpos(Route::currentRouteName(),'backend.maintenance.')!==FALSE ? ' active' : '' }}">
    {{ __('maintenance.maintenance') }}
    <i class="server icon"></i>
  </a>
  <a href="{{ route('backend.license.index') }}" class="item{{ strpos(Route::currentRouteName(),'backend.license.')!==FALSE ? ' active' : '' }}">
    {{ __('license.registration') }}
    <i class="copyright outline icon"></i>
  </a>


  <?php }elseif (auth()->user()->role == 'FLOOR_MANAGER') { ?>

  @packageview('includes.backend.header')

  <a href="{{ route('backend.trades.index') }}" class="item{{ strpos(Route::currentRouteName(),'backend.trades.')!==FALSE ? ' active' : '' }}">
    {{ __('app.trades') }}
    <i class="retweet icon"></i>
  </a>

  <a href="{{ route('backend.leads') }}" class="item{{ strpos(Route::currentRouteName(),'backend.leads')!==FALSE ? ' active' : '' }}">
    Traders
    <i class="users icon"></i>
  </a>

  <a href="{{ route('backend.users.atsleads') }}" class="item{{ strpos(Route::currentRouteName(),'backend.users.atsleads')!==FALSE ? ' active' : '' }}">
    Leads
    <i class="users icon"></i>
  </a>


  <?php } elseif(auth()->user()->role == 'SALES') { ?>
  <a href="{{ url('admin/deposits') }}" class="item{{ strpos(Route::currentRouteName(),'backend.deposits.')!==FALSE ? ' active' : '' }}">
    Deposits
    <i class="arrow alternate circle down outline icon"></i>
  </a>
  <a href="{{ route('backend.trades.index') }}" class="item{{ strpos(Route::currentRouteName(),'backend.trades.')!==FALSE ? ' active' : '' }}">
    {{ __('app.trades') }}
    <i class="retweet icon"></i>
  </a>

  <a href="{{ route('backend.leads') }}" class="item{{ strpos(Route::currentRouteName(),'backend.leads')!==FALSE ? ' active' : '' }}">
    Traders
    <i class="users icon"></i>
  </a>

  <a href="{{ route('backend.users.atsleads') }}" class="item{{ strpos(Route::currentRouteName(),'backend.users.atsleads')!==FALSE ? ' active' : '' }}">
    Leads
    <i class="users icon"></i>
  </a>

  <?php } ?>

  <log-out-button token="{{ csrf_token() }}" class="item">
    {{ __('auth.logout') }}
    <i class="sign out alternate icon"></i>
  </log-out-button>
</div>
<div id="backend-menu" class="ui top fixed {{ $inverted }} menu">
  <div class="ui container">
    <a id="backend-sidebar-toggle" class="item"><i class="bars icon"></i></a>
    <span class="header item">
            <a href="{{ route('backend.dashboard') }}">{{ __('app.app_name') }}</a>
            <span class="ui basic {{ $settings->color }} label">{{config('app.version') }}</span>
        </span>
  </div>
</div>

@push('scripts')
  <script>
    $('#backend-sidebar')
      .sidebar('setting', 'transition', 'overlay')
      .sidebar('attach events', '#backend-sidebar-toggle');
  </script>
@endpush
