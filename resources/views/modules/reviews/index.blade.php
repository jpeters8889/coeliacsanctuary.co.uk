@extends('templates.page')

@section('inner-content')
    {{--    <global-ui-google-ad code="2925914349"></google-ad>--}}

    <div class="page-box">
        <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
            Coeliac Sanctuary Reviews

            <a class="block text-sm font-semibold font-sans text-social-rss hover:text-blue-dark transition-all"
               href="/review/feed" target="_blank">
                RSS Feed
                <font-awesome-icon :icon="['fas', 'rss-square']"></font-awesome-icon>
            </a>
        </h1>
    </div>

    <div class="page-box">
        <p>
            Being coeliac, eating out isn't always easy, if you're anything like us you'll research and plan way before
            you'll go anywhere, that's why we have our comprehensive
            <a href="/wheretoeat" class="font-semibold text-blue-dark hover:text-black">eating out guide</a>, and
            we'll always try to produce a honest review detailing our experience, so you know its safe for you to eat
            there too!
        </p>
    </div>

    <module-list-index module="reviews" title="Reviews" url-prefix="review"/>

    {{--    <global-ui-google-ad code="3472709255"></google-ad>--}}
@endsection
