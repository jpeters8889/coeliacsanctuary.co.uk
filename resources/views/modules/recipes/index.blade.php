@extends('templates.page')

@section('inner-content')
    {{--    <global-ui-google-ad code="2137793897"></google-ad>--}}

    <div class="page-box">
        <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
            Coeliac Sanctuary Recipes

            <a class="block text-sm font-semibold font-sans text-social-rss hover:text-blue-dark transition-all"
               href="/recipe/feed" target="_blank">
                RSS Feed
                <font-awesome-icon :icon="['fas', 'rss-square']"></font-awesome-icon>
            </a>
        </h1>
    </div>

    <div class="page-box">
        <p>
            Why not check out some of our fabulous, gluten free, coeliac recipes! All of our recipes are tried and
            tested by us, and as much as we can, we will always use simple, easy to get ingredients, readily available
            in most supermarkets, so anyone can make them at home!
        </p>
    </div>

    <module-list-index module="recipes" title="Recipes" url-prefix="recipe"/>

    {{--    <global-ui-google-ad code="4702154153"></google-ad>--}}
@endsection
