@extends('layouts.coeliac')

@section('content')
    <header class="flex flex-col bg-blue-light border-yellow border-b-4">
        <global-layout-top-bar>
            <global-layout-mobile-nav class="mr-2 md:hidden"></global-layout-mobile-nav>
            <a href="/">
                <global-layout-coeliac-icon class="js-mob-icon text-white md:hidden"
                                            style="height: 1.875rem"></global-layout-coeliac-icon>
            </a>
            <coeliac-nav class="hidden md:block"></coeliac-nav>
            <search-ui-header
                class="h-full flex items-center md:absolute md:right-0 md:top-0 md:mr-2"></search-ui-header>
        </global-layout-top-bar>
    </header>

    <global-layout-breadcrumbs :crumbs='@json($breadcrumbs['crumbs'])'
                               location="{{ $breadcrumbs['location'] }}"
                               :scrapable="{{ isset($scrapable) ? json_encode($scrapable) : 'false' }}"></global-layout-breadcrumbs>


    <div class="h-full flex-1 flex max-h-full overflow-hidden">
        <wheretoeat-page-browse />
    </div>

    <footer
        class="bg-blue-gradient p-3 flex flex-col border-t-4 border-yellow text-center text-sm w-full mx-auto">
        <p>
            Copyright &copy; 2014 - {{ date('Y') }} Coeliac Sanctuary
        </p>
        <div>
            <a class="font-medium hover:underline" href="/terms-of-use">Terms of Use</a> |
            <a class="font-medium hover:underline" href="/privacy-policy">Privacy Policy</a> |
            <a class="font-medium hover:underline" href="/cookie-policy">Cookie Policy</a> |
            <a class="font-medium hover:underline" href="/work-with-us">Work With Us</a>
        </div>
    </footer>

@endsection
