<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    @include('includes.frontend.head_new')
</head>
<body class="{{ str_replace('.','-',Route::currentRouteName()) }} background-{{ $settings->background }} color-{{ $settings->color }}">
    @includeWhen(config('settings.gtm_container_id'), 'includes.frontend.gtm-body')

    <div id="app">

        <div id="before-content">
            @yield('before-content')
        </div>

        <div class="ui container pappukhan">
            @section('messages')
                @component('components.session.messages')
                @endcomponent
            @show
        </div>

        <div id="content">
            @yield('content')
        </div>

        <div id="after-content">
            @yield('after-content')
        </div>

        @includeFirst(['includes.frontend.footer-udf','includes.frontend.footer_new'])

    </div>

    @include('includes.frontend.scripts_new')

</body>
</html>