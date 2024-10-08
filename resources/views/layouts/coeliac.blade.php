<!DOCTYPE html>
<html lang="en" class="min-h-screen">
<head>
    @include('page-view-builder::header')

    <meta name="author" content="Coeliac Sanctuary"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="google-site-verification" content="MkXdbyO1KF2xCS7VFkP7v5ZaWw3WObMUJDFxX0z7_4w"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes"/>
    <meta property="article:publisher" content="https://www.facebook.com/CoeliacSanctuary"/>
    <meta property="og:updated_time" content="{{ date('c') }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="asset-url" content="{{ config('coeliac.assets_url') }}">

    @if(config('app.env') !== 'production' || (isset($tracking) && $tracking===false))
        <meta name="robots" content="noindex">
    @endif

    @yield('alternateMetas')

    @isset($prefetch)
        @foreach($prefetch as $domain => $as)
            <link rel="dns-prefetch" href="{{ $domain }}"/>
            <link rel="preload" href="{{ $domain }}" as="{{ $as }}"/>
            <link rel="preconnect" href="{{ $domain }}" crossorigin/>
        @endforeach
    @endisset

    <link rel="preload" as="font" href="https://fonts.cdnfonts.com/s/9372/Note%20this.woff" type="font/woff2" crossorigin="anonymous">
    <link rel="preconnect" href="https://www.google-analytics.com/" crossorigin="anonymous">

{{--    @preload--}}

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin />

    <!-- [2] -->
    <link rel="preload"
          as="style"
          href="https://fonts.googleapis.com/css?family=Raleway:200,400,500,600,700&display=swap" />

    <!-- [3] -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Raleway:200,400,500,600,700&display=swap"
          media="print" onload="this.media='all'" />

    <link rel="preload stylesheet" href="http://fonts.cdnfonts.com/css/note-this" as="style">
    <link rel="preload stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:200,400,500,600,700&display=swap" as="style">
    <link rel="preload stylesheet" href="{{ mix('/assets/css/coeliac.css') }}" as="style">

    <!--iPhone tiles-->
    <link href="/assets/images/apple/apple-touch-icon-57x57.png" rel="apple-touch-icon"/>
    <link href="/assets/images/apple/apple-touch-icon-72x72.png" rel="apple-touch-icon" sizes="72x72"/>
    <link href="/assets/images/apple/apple-touch-icon-114x114.png" rel="apple-touch-icon" sizes="114x114"/>
    <link href="/assets/images/apple/apple-touch-icon-152x152.png" rel="apple-touch-icon" sizes="152x152"/>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-53299243-1"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-5PWV6VHY13"></script>

    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag(){
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-53299243-1');
        gtag('config', 'G-5PWV6VHY13'); // GA-4
    </script>

    @yield('headerJavaScript', '')
</head>

<body class="min-h-screen shadow-lg flex flex-col bg-grey-off-light font-sans">

<div id="coeliac" class="min-h-screen flex flex-col">
    @yield('content')

    <global-ui-popup-cta></global-ui-popup-cta>
    <search-ui-quick></search-ui-quick>
    <portal-target name="modal"></portal-target>
    <global-layout-full-page-loader></global-layout-full-page-loader>
</div>

@yield('footerCSS')

<script>
    var config = {
        baseUrl: '{{ config('app.url') }}',
        googleMaps: {
            static: '{{ config('services.google.maps.static') }}',
            dynamic: '{{ config('services.google.maps.dynamic') }}',
        },
        shop: {
            stripe: '{{ config('services.shop.payments.stripe.public') }}',
            paypal: '{{ config('app.env') === 'production' ? 'production' : 'sandbox' }}'
        },
        user: @json(request()->user()),
    }
</script>

<script async defer src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

<noscript>
    <img alt='' height="1" width="1" style="display:none"
         src="https://www.facebook.com/tr?id=376206517120953&ev=PageView&noscript=1"
    />
</noscript>

<script src="{{ mix('/assets/js/manifest.js') }}" async></script>
<script src="{{ mix('/assets/js/vendor.js') }}" async></script>
<script src="{{ mix('/assets/js/coeliac.js') }}" async></script>

<script>
    setTimeout(() => {
        !(function (f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function () {
                n.callMethod
                    ? n.callMethod.apply(n, arguments) : n.queue.push(arguments);
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s);
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js'));
        fbq('init', '376206517120953');
        fbq('track', 'PageView');
    }, 5000);
</script>

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

@yield('footerJavascript')

</body>
</html>
