@extends('layouts.coeliac')

@section('content')
    @include('components.announcement')

    <header class="flex flex-col bg-blue-light border-yellow border-b-4">
        <div style="min-height: 60px">
            <global-layout-top-bar>
                <global-layout-mobile-nav class="mr-2 md:hidden"></global-layout-mobile-nav>
                <a href="/">
                    <global-layout-coeliac-icon class="js-mob-icon text-white md:hidden" style="height: 1.875rem"></global-layout-coeliac-icon>
                </a>
                <coeliac-nav class="hidden md:block"></coeliac-nav>
                <search-ui-header class="h-full flex items-center md:absolute md:right-0 md:top-0 md:mr-2"></search-ui-header>
            </global-layout-top-bar>
        </div>

        <div class="inner-wrapper p-3 flex leading-none items-center">
            <div class="hidden md:block mr-2 w-1/6">
                <a href="/">
                    <x-svg-logo></x-svg-logo>
                </a>
            </div>
            <div class="text-center flex flex-col flex-1 py-2 md:text-left md:py-0">
                <h1 class="text-4xl font-medium font-coeliac mb-4 md:text-3xl md:mb-2">Coeliac Sanctuary</h1>
                <h2>Gluten Free Eateries, Blogs, Recipes. Reviews and more...</h2>
            </div>
        </div>
    </header>

    <breadcrumbs :crumbs='@json($breadcrumbs['crumbs'])'
                 location="{{ $breadcrumbs['location'] }}" :scrapable="{{ isset($scrapable) ? json_encode($scrapable) : 'false' }}"></breadcrumbs>

    @include('components.competition')

    <div class="inner-wrapper">
        @yield('inner-content')
    </div>

    @include('components.footer')
@endsection
