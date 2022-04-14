@extends('templates.page-single-column')

@section('primary-column')
    <div class="flex flex-col space-y-3 max-w-images mx-auto">
        <div class="page-box shadow">
            <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">{{ $blog->title }}</h1>

            <p class="text-lg my-2 font-medium leading-relaxed">{!! $blog->description !!}</p>

            <div class="bg-grey-light border-t border-grey-off-light -m-3 mt-3 p-3">
                <h3 class="font-semibold text-base text-grey-darkest">Tagged with:</h3>
                <ul class="flex flex-row flex-wrap text-sm leading-tight">
                    @foreach($blog->tags as $tag)
                        <li>
                            <a class="font-semibold text-blue-dark hover:text-grey-darker" href="{{ $tag->link }}">
                                {{ $tag->tag  }}</a>@if(!$loop->last),&nbsp;
                            @endif
                        </li>
                    @endforeach
                </ul>
                <p class="mt-2">Added
                    <time datetime="{{ $blog->created_at }}">{{ formatDate($blog->created_at) }}</time>
                </p>
                @if(!$blog->updated_at->isSameDay($blog->created_at))
                    <p>Updated
                        <time datetime="{{ $blog->updated_at }}">{{ formatDate($blog->updated_at) }}</time>
                    </p>
                @endif
            </div>
        </div>

        <div class="shadow">
            <img data-src="{{ $blog->main_image }}"
                 src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"
                 alt="{{ $blog->title }}" width="100%" loading="lazy" class="lazy"
            />
        </div>

        @if($featured)
            <div class="page-box p-3 shadow">
                <h3 class="font-semibold text-base text-grey-darkest">This blog was featured in:</h3>
                <ul class="flex flex-row flex-wrap text-sm leading-tight">
                    @foreach($featured as $feature)
                        <li>
                            <a class="font-semibold text-blue-dark hover:text-grey-darker" href="{{ $feature->link }}">
                                {{ $feature->title  }}</a>@if(!$loop->last),&nbsp;
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="page-box p-3 shadow">
            <article class="leading-relaxed">
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

{{--        <global-ui-google-ad code="7206823714"></global-ui-google-ad>--}}
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
