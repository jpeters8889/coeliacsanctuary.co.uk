@extends('templates.page-two-column')

@section('primary-column')
    <div class="flex flex-col" chunk>
        <div class="page-box">
            <h1 class="text-2xl font-coeliac text-center font-semibold leading-tight md:text-left">
                Place Request<br/>
                <a class="text-xs font-sans hover:text-grey transition-color" href="/wheretoeat">Back
                    to Map/List</a>
            </h1>

            <p>
                Do you know a place that needs adding to our guide? Or maybe one we have listed doesn't offer gluten
                free anymore. Let us know
            </p>

            <wheretoeat-pages-place-request></wheretoeat-pages-place-request>
        </div>
    </div>
@endsection

@section('secondary-column')
    <div class="flex flex-col">
        <x-widget class="mb-3" title="Sign up to our newsletter">
            <global-ui-newsletter-signup/>
        </x-widget>

        <global-ui-google-ad code="7266831645"></global-ui-google-ad>

        <x-widget title="Random Reviews">
            @foreach($related as $relatedRecipe)
                <div
                    class="w-full rounded-lg overflow-hidden flex flex-col shadow-md mb-4 bg-blue-gradient-30 {{ !$loop->last ? 'sm:mb-3' : '' }}">
                    <div>
                        <img src="{{ $relatedRecipe->main_image }}" alt="{{ $relatedRecipe->title }}"/>
                    </div>
                    <div class="p-2 flex flex-col h-full">
                        <a href="{{ $relatedRecipe->link }}">
                            <h3 class="font-bold hover:underline">{{ $relatedRecipe->title }}</h3>
                        </a>
                        <p class="flex-1">{{ $relatedRecipe->meta_description }}</p>
                    </div>
                </div>
            @endforeach
        </x-widget>
    </div>
@endsection
