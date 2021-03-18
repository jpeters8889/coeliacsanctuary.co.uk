@extends('templates.page-two-column')

@section('primary-column')
    <div class="flex flex-col">
        <div class="page-box p-3">
            <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">{{ $collection->title }}</h1>

            <p class="text-lg my-2 font-medium leading-relaxed">{!! $collection->long_description !!}</p>

            <p class="mt-3 p-3 text-sm mt-1 text-grey-darker bg-blue-light-20">
                Added {{ formatDate($collection->created_at) }}
                @if(!$collection->updated_at->isSameDay($collection->created_at))
                    <br>Updated {{ formatDate($collection->updated_at) }}
                @endif
            </p>
        </div>

        <div>
            <img data-src="{{ $collection->main_image }}"
                 src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"
                 alt="{{ $collection->title }}" loading="lazy" class="lazy"/>
        </div>

        <div class="page-box p-3">
            {{--            <global-ui-google-ad code="7619961534"></google-ad>--}}

            @if($collection->body)
                <article>
                    {!! $collection->body !!}
                </article>
            @endif

            {{--            <global-ui-google-ad code="6662103082"></google-ad>--}}
        </div>

        <div class="page-box p-3 mt-3">
            <div class="flex flex-col">
                @foreach($items as $item)
                    {!! $item->render() !!}
                    @if(!$loop->last)
                        <div class="h-1 bg-blue-gradient-30 my-3 w-full"></div>
                    @endif
                @endforeach
            </div>
        </div>

    </div>
@endsection

@section('secondary-column')
    <div class="flex flex-col">
        <x-widget class="mb-3" title="Sign up to our newsletter">
            <global-ui-newsletter-signup />
        </x-widget>

        <global-ui-google-ad code="7266831645"></global-ui-google-ad>

        @include('components.related-item', $related)
    </div>
@endsection

@section('alternateMetas')
    <meta property="article:publisher" content="https://www.facebook.com/coeliacsanctuary"/>
    <meta property="article:section" content="Food"/>
    <meta property="article:published_time" content="{{ $collection->created_at }}"/>
    <meta property="article:modified_time" content="{{ $collection->updated_at }}"/>
    <meta property="article:author" content="Coeliac Sanctuary"/>
    <meta property="article:tag" content="{{ $collection->meta_keywords }}"/>
@endsection

