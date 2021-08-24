@extends('templates.page-single-column')

@section('primary-column')
    <div class="flex flex-col space-y-3 max-w-images mx-auto">
        <div class="page-box shadow">
            <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
                {{ $review->title }}, {{ $review->eatery->town->town }}, {{ $review->eatery->county->county }}
            </h1>

            <p class="text-lg my-2 font-medium leading-relaxed">{!! $review->eatery->info !!}</p>

            <div class="bg-grey-light border-t border-grey-off-light -m-3 mt-3 p-3 flex flex-col space-y-2">
                <div class="flex flex-col sm:flex-row">
                    <div class="flex flex-col sm:w-1/2">
                        <ul class="text-center sm:text-left">
                            <li class="flex flex-col mb-2">
                                <h2 class="text-xl font-semibold">Our Overall Rating</h2>
                                <global-ui-stars stars="{{ $review->overall_rating }}"></global-ui-stars>
                            </li>

                            <li class="flex flex-col mb-2">
                                <h3>Knowledge</h3>
                                <global-ui-stars stars="{{ $review->knowledge_rating }}"></global-ui-stars>
                            </li>

                            <li class="flex flex-col mb-2">
                                <h3>Presentation and Taste</h3>
                                <global-ui-stars stars="{{ $review->presentation_taste_rating }}"></global-ui-stars>
                            </li>

                            <li class="flex flex-col mb-2">
                                <h3>Value</h3>
                                <global-ui-stars stars="{{ $review->value_rating }}"></global-ui-stars>
                            </li>

                            <li class="flex flex-col">
                                <h3>General</h3>
                                <global-ui-stars stars="{{ $review->general_rating }}"></global-ui-stars>
                            </li>
                        </ul>
                    </div>
                    <div class="mt-2 text-center sm:w-1/2 sm:text-right flex flex-col">
                        <map-static :lat="{{ $review->eatery->lat }}" :lng="{{ $review->eatery->lng }}"
                                    :map-classes="['min-h-map-small']"></map-static>
                        <div>
                            {!! $review->eatery->address !!}
                            @if($review->eatery->phone)
                                <br>{{ $review->eatery->phone }}
                            @endif
                            @if($review->eatery->website)
                                <br/><a class="font-semibold hover:underline" href="{{ $review->eatery->website }}"
                                        target="_blank">Visit Website</a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="border-t border-grey-off">
                    <p class="mt-2">Added
                        <time datetime="{{ $review->created_at }}">{{ formatDate($review->created_at) }}</time>
                    </p>
                    @if(!$review->updated_at->isSameDay($review->created_at))
                        <p>Updated
                            <time datetime="{{ $review->updated_at }}">{{ formatDate($review->updated_at) }}</time>
                        </p>
                    @endif
                </div>
            </div>
        </div>

        <div class="shadow">
            <img data-src="{{ $review->main_image }}"
                 src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"
                 loading="lazy" class="lazy" alt="{{ $review->title }}"/>
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

        <global-ui-google-ad code="2925914349"></global-ui-google-ad>

        <div class="page-box p-3 shadow">
            <article>
                {!! $review->body !!}
            </article>
        </div>

        <global-ui-google-ad code="3472709255"></global-ui-google-ad>

        <div class="page-box p-3 shadow">
            <h2 class="text-2xl my-2 font-semibold font-coeliac">Your Comments</h2>

            <div class="flex flex-col -mb-3">
                @forelse($review->comments as $comment)
                    <div class="flex flex-col bg-gradient-to-br from-blue/30 to-blue-light/30 p-3 border-l-8 border-yellow shadow mb-3">
                        <div class="mb-2">{!! $comment->comment !!}</div>
                        <div class="flex text-xs font-medium text-grey">
                            <div class="mr-2">{{ $comment->name }}</div>
                            <div>{{ formatDate($comment->created_at) }}</div>
                        </div>
                        @if($comment->reply)
                            <div class="flex mt-2 flex-col mt-3 bg-white bg-opacity-80 p-3">
                                <strong>Alison @ Coeliac Sanctuary replied to this comment
                                    on {{ formatDate($comment->reply->created_at) }}</strong>
                                <p>{!! $comment->reply->comment_reply !!}</p>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="mb-3">
                        <strong class="font-semibold">There's no comments on this Review, why not leave one?</strong>
                    </div>
                @endforelse
            </div>
        </div>

        <modules-comment-form area="review" :id="{{ $review->id }}"></modules-comment-form>

        <global-ui-google-ad code="7206823714"></global-ui-google-ad>
    </div>
@endsection

@section('alternateMetas')
    <meta property="article:publisher" content="https://www.facebook.com/coeliacsanctuary"/>
    <meta property="article:section" content="Food"/>
    <meta property="article:published_time" content="{{ $review->created_at }}"/>
    <meta property="article:modified_time" content="{{ $review->updated_at }}"/>
    <meta property="article:author" content="Coeliac Sanctuary"/>
    <meta property="article:tag" content="{{ $review->meta_keywords }}"/>
@endsection

@section('footerJavascript')
    <script type="application/ld+json">
        @json($review->richText)
    </script>
@endsection
