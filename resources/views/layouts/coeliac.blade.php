<!DOCTYPE html>
<html lang="en" class="min-h-screen">
<head>
    @include('page-view-builder::header')

    <meta name="author" content="Coeliac Sanctuary"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="google-site-verification" content="MkXdbyO1KF2xCS7VFkP7v5ZaWw3WObMUJDFxX0z7_4w"/>

    <!-- Responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes"/>

    <meta property="article:publisher" content="https://www.facebook.com/CoeliacSanctuary"/>

    @yield('alternateMetas')

    <meta property="og:updated_time" content="{{ date('c') }}"/>

    @if(config('app.env') !== 'production' || (isset($tracking) && $tracking===false))
        <meta name="robots" content="noindex">
    @endif

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="asset-url" content="{{ config('coeliac.assets_url') }}">

    @isset($prefetch)
    <!-- DNS Prefetch -->
        @foreach($prefetch as $domain)
            <link rel="dns-prefetch" href="{{ $domain }}"/>
            <link rel="preload" href="{{ $domain }}"/>
            <link rel="preconnect" href="{{ $domain }}" crossorigin/>
        @endforeach
    @endisset

    <link rel="preload" href="/assets/fonts/Notethis.woff" />

    <link rel="stylesheet" type="text/css" href="{{ mix('/assets/css/coeliac.css') }}"/>

    <!--iPhone tiles-->
    <link href="/assets/images/apple/apple-touch-icon-57x57.png" rel="apple-touch-icon"/>
    <link href="/assets/images/apple/apple-touch-icon-72x72.png" rel="apple-touch-icon" sizes="72x72"/>
    <link href="/assets/images/apple/apple-touch-icon-114x114.png" rel="apple-touch-icon" sizes="114x114"/>
    <link href="/assets/images/apple/apple-touch-icon-152x152.png" rel="apple-touch-icon" sizes="152x152"/>

    @yield('headerJavaScript', '')

    @if(config('app.env') !== 'testing')
        <script defer async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script defer async src="https://www.googletagmanager.com/gtag/js?id=UA-53299243-1"></script>

        <noscript>
            <img height="1" width="1" src="https://www.facebook.com/tr?id=1163828547057901&ev=PageView&noscript=1"/>
        </noscript>
    @endif

    @if($page->url === config('app.url'))
        <script type="application/ld+json">
            {
                "@context": "https:\/\/schema.org",
                "@type": "WebSite",
                "@id": "#website",
                "url": "https:\/\/www.coeliacsanctuary.co.uk\/",
                "name": "Coeliac Sanctuary | Gluten Free Places to Eat, Reviews, Blogs and more!"
            }
        </script>

        <script type='application/ld+json'>
            {
                "@context": "https:\/\/schema.org",
                "@type": "Person",
                "url": "https:\/\/www.coeliacsanctuary.co.uk\/",
                "sameAs": [
                    "https:\/\/www.facebook.com\/coeliacsanctuary",
                    "http:\/\/www.instagram.com\/coeliacsanctuary",
                    "https:\/\/twitter.com\/CoeliacSanc"
                ],
                "@id": "#person",
                "name": "Alison Wheatley"
            }
        </script>
    @endif
</head>

<body class="min-h-screen shadow-lg flex flex-col bg-grey-off-light font-sans">

<div id="coeliac" class="min-h-screen flex flex-col">
    @yield('content')

    <popup-cta></popup-cta>
    <quick-search></quick-search>
    <portal-target name="modal"></portal-target>
    <full-page-loader></full-page-loader>
</div>

@yield('footerCSS')

<script>
    var config = {
        googleMaps: {
            static: '{{ config('services.google.maps.static') }}',
            dynamic: '{{ config('services.google.maps.dynamic') }}',
        },
        shop: {
            stripe: '{{ config('services.shop.payments.stripe.public') }}',
            paypal: '{{ config('app.env') === 'production' ? 'production' : 'sandbox' }}'
        },
    }
</script>

<script src="{{ mix('/assets/js/manifest.js') }}" async defer></script>
<script src="{{ mix('/assets/js/vendor.js') }}" async defer></script>
<script src="{{ mix('/assets/js/coeliac.js') }}" async defer></script>

@yield('footerJavascript')

</body>
</html>
