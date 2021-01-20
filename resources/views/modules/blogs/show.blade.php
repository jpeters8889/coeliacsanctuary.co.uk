@extends('templates.page-two-column')

@section('primary-column')
    <div class="flex flex-col" style="max-width: 1200px">


        <div class="page-box p-3">
            <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">{{ $blog->title }}</h1>

            <p class="text-lg my-2 font-medium leading-relaxed">{!! $blog->description !!}</p>

            <p class="mt-3 p-3 text-sm mt-1 text-grey-darker bg-blue-light-20">
                Added {{ formatDate($blog->created_at) }}
                @if(!$blog->updated_at->isSameDay($blog->created_at))
                    <br>Updated {{ formatDate($blog->updated_at) }}
                @endif
            </p>
        </div>

        <div class="page-body">
            <img data-src="{{ $blog->main_image }}"
                 src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"
                 alt="{{ $blog->title }}" loading="lazy" class="lazy"/>
        </div>

        <div class="page-box p-3">
{{--            <google-ad code="7619961534"></google-ad>--}}

            <article>
                {!! $blog->body !!}
            </article>

            <google-ad code="6662103082"></google-ad>
        </div>

        <div class="page-box p-3 mt-3">
            <h2 class="text-2xl my-2 font-semibold font-coeliac">Your Comments</h2>

            <div class="flex flex-col -mb-3">
                @forelse($blog->comments as $comment)
                    <div class="flex flex-col bg-blue-gradient-30 p-3 border-l-8 border-yellow shadow mb-3">
                        <div class="mb-2">{!! $comment->comment !!}</div>
                        <div class="flex text-xs font-medium text-grey">
                            <div class="mr-2">{{ $comment->name }}</div>
                            <div>{{ formatDate($comment->created_at) }}</div>
                        </div>
                        @if($comment->reply)
                            <div class="flex mt-2 flex-col mt-3 bg-white-80 p-3">
                                <strong>Alison @ Coeliac Sanctuary replied to this comment
                                    on {{ formatDate($comment->reply->created_at) }}</strong>
                                <p>{!! $comment->reply->comment_reply !!}</p>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="mb-3">
                        <strong class="font-semibold">There's no comments on this Blog, why not leave one?</strong>
                    </div>
                @endforelse
            </div>
        </div>

        <comment-form area="blog" :id="{{ $blog->id }}"></comment-form>

    </div>
@endsection

@section('secondary-column')
    <div class="flex flex-col">
        <widget-blog-search class="mb-3"></widget-blog-search>

        <widget class="mb-3">
            <template v-slot:title>Tags</template>
            <template v-slot:body>
                <ul class="flex flex-row flex-wrap text-sm leading-tight">
                    @foreach($blog->tags as $tag)
                        <li>
                            <a class="font-medium hover:underline text-grey-darker" href="{{ $tag->link }}">
                                {{ $tag->tag  }}</a>@if(!$loop->last),&nbsp;
                            @endif
                        </li>
                    @endforeach
                </ul>
            </template>
        </widget>

        <widget-newsletter-signup class="mb-3"></widget-newsletter-signup>

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
