@extends('templates.page-single-column')

@section('primary-column')
    <div class="flex flex-col space-y-3 max-w-images mx-auto">
        <div class="page-box shadow">
            <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">{{ $collection->title }}</h1>

            <p class="text-lg my-2 font-medium leading-relaxed">{!! $collection->long_description !!}</p>

            <div class="bg-grey-light border-t border-grey-off-light -m-3 mt-3 p-3">
                <p>Added
                    <time datetime="{{ $collection->created_at }}">{{ formatDate($collection->created_at) }}</time>
                </p>
                @if(!$collection->updated_at->isSameDay($collection->created_at))
                    <p>Updated
                        <time datetime="{{ $collection->updated_at }}">{{ formatDate($collection->updated_at) }}</time>
                    </p>
                @endif
            </div>
        </div>

        <div class="shadow">
            <img data-src="{{ $collection->main_image }}"
                 src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"
                 alt="{{ $collection->title }}" loading="lazy" class="lazy"/>
        </div>

        @if($collection->body)
            <div class="page-box p-3 shadow">
                <article>
                    {!! $collection->body !!}
                </article>
            </div>
        @endif

        <div class="page-box p-3">
            <div class="flex flex-col">
                @foreach($items as $item)
                    {!! $item->render() !!}
                    @if(!$loop->last)
                        <div class="h-1 bg-gradient-to-br from-blue/30 to-blue-light/30 my-3 w-full"></div>
                    @endif
                @endforeach
            </div>
        </div>

        <global-ui-google-ad code="7206823714"></global-ui-google-ad>

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

