<title>{{ $page->title }}</title>

<meta name="description" content="{{ $page->metas->description }}"/>
<meta name="keywords" content="{{ $page->metas->keywords }}"/>

<link rel="canonical" href="{{ $page->url }}"/>

@if($page->social->facebook)
    <meta property="og:type" content="article" />
    <meta property="og:locale" content="en_GB"/>
    <meta property="og:site_name" content="{{ config('app.name') }}"/>
    <meta property="og:description" content="{{ $page->metas->description }}"/>
    <meta property="og:title" content="{{ $page->title }}"/>
    <meta property="og:image" content="{{ $page->metas->image }}"/>
    <meta property="og:image:type" content="image/jpeg"/>
    <meta property="og:url" content="{{ $page->url }}"/>
@endif

@if($page->social->twitter)
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:description" content="{{ $page->metas->description }}"/>
    <meta name="twitter:title" content="{{ $page->title }}"/>
    <meta name="twitter:site" content="{{ $page->social->twitter->handle }}"/>
    <meta name="twitter:domain" content="{{ config('app.name') }}"/>
    <meta name="twitter:image:src" content="{{ $page->metas->image }}"/>
    <meta name="twitter:creator" content="{{ $page->social->twitter->handle }}"/>
@endif
