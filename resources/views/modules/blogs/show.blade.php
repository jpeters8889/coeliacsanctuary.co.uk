@extends('templates.page-two-column')

@section('primary-column')
    <div class="flex flex-col">
        <div class="page-box p-3">
            <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">{{ $blog->title }}</h1>

            <p class="text-lg my-2 font-medium leading-relaxed">{!! $blog->description !!}</p>

            <div class="mt-3 p-3 text-sm mt-1 text-grey-darker bg-blue-light-20">
                <div>
                    <h3 class="font-semibold text-base text-grey-darkest">Tagged with:</h3>
                    <ul class="flex flex-row flex-wrap text-sm leading-tight">
                        @foreach($blog->tags as $tag)
                            <li>
                                <a class="font-medium hover:underline text-grey-darker" href="{{ $tag->link }}">
                                    {{ $tag->tag  }}</a>@if(!$loop->last),&nbsp;
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
                <p class="mt-2">Added {{ formatDate($blog->created_at) }}</p>
                @if(!$blog->updated_at->isSameDay($blog->created_at))
                    <p>Updated {{ formatDate($blog->updated_at) }}</p>
                @endif
            </div>
        </div>

        <div class="page-body">
            <img data-src="{{ $blog->main_image }}"
                 src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"
                 alt="{{ $blog->title }}" width="100%" loading="lazy" class="lazy"/>
        </div>

        <div class="page-box p-3">
            {{--            <global-ui-google-ad code="7619961534"></google-ad>--}}

            <article>
                {!! $blog->body !!}
            </article>

            <global-ui-google-ad code="6662103082"></global-ui-google-ad>
        </div>

        <div class="page-box p-3 mt-3">
            <h2 class="text-2xl my-2 font-semibold font-coeliac">Your Comments</h2>

            <div class="flex flex-col -mb-3">
                <module-comments area="blog" :id="{{ $blog->id }}"></module-comments>
            </div>
        </div>

        <modules-comment-form area="blog" :id="{{ $blog->id }}"></modules-comment-form>

    </div>
@endsection

@section('secondary-column')
    <div class="flex flex-col">
        <x-widget class="mb-3" title="Search Blogs">
            <search-ui-blog-widget />
        </x-widget>

        <x-widget class="mb-3" title="Sign up to our newsletter">
            <global-ui-newsletter-signup />
        </x-widget>

        <global-ui-google-ad code="7266831645"></global-ui-google-ad>

        @if($featured)
            @include('components.featured-in', $featured)
        @endif

        @include('components.related-item', $related)
    </div>
@endsection

@section('alternateMetas')
    <meta property="article:publisher" content="https://www.facebook.com/coeliacsanctuary"/>
    <meta property="article:section" content="Food"/>
    <meta property="article:published_time" content="{{ $blog->created_at }}"/>
    <meta property="article:modified_time" content="{{ $blog->updated_at }}"/>
    <meta property="article:author" content="Coeliac Sanctuary"/>
    <meta property="article:tag" content="{{ $blog->meta_keywords }}"/>
@endsection

@section('footerJavascript')
    <script type="application/ld+json">
        @json($blog->richText)
    </script>
@endsection
