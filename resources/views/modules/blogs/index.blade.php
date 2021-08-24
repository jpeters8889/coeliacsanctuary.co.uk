@extends('templates.page-single-column')

@section('inner-content')
    {{--    <global-ui-google-ad code="7619961534"></google-ad>--}}

    <div class="page-box">
        <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
            Coeliac Sanctuary Blogs

            <a class="block text-sm font-semibold font-sans text-social-rss hover:text-blue-dark transition-all"
               href="/blog/feed" target="_blank">
                RSS Feed
                <font-awesome-icon :icon="['fas', 'rss-square']"></font-awesome-icon>
            </a>
        </h1>
    </div>

    <div class="page-box">
        <p>
            Our motto is that we're more than just a gluten free blog, but blogs are still the heart and soul of Coeliac
            Sanctuary, we'll write about a bit of everything, from coeliac news, new products, guides, and more, we're
            sure you'll find something you'll love here!
        </p>
    </div>

    <module-list-index module="blogs" title="Blogs" url-prefix="blog"/>

    {{--    <global-ui-google-ad code="6662103082"></google-ad>--}}
@endsection
