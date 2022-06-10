<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    @include('includes.frontend.head_new')
</head>
<body class="appu frontend {{ str_replace('.','-',Route::currentRouteName()) }} background-{{ $settings->background }} color-{{ $settings->color }}">
    @includeWhen(config('settings.gtm_container_id'), 'includes.frontend.gtm-body')

    <div id="app">



        <div id="before-content">
            @includeWhen(config('settings.adsense_client_id') && config('settings.adsense_top_slot_id'),
                'includes.frontend.adsense',
                ['client_id' => config('settings.adsense_client_id'), 'slot_id' => config('settings.adsense_top_slot_id')]
            )

            @yield('before-content')
        </div>

        <div id="content">
            @yield('content')
        </div>

        <div id="after-content">
            @yield('after-content')

            @includeWhen(config('settings.adsense_client_id') && config('settings.adsense_bottom_slot_id'),
                'includes.frontend.adsense',
                ['client_id' => config('settings.adsense_client_id'), 'slot_id' => config('settings.adsense_bottom_slot_id')]
            )
        </div>

        @includeFirst(['includes.frontend.footer-udf','includes.frontend.footer_new'])

    </div>

    @include('includes.frontend.privacy_script_new')

</body>
</html>