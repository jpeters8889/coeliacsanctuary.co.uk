@extends('templates.page-two-column')

@section('primary-column')
    <div class="flex flex-col" chunk>
        <div class="page-box">
            <h1 class="text-2xl font-coeliac text-center font-semibold leading-tight md:text-left">
                Coeliac Sanctuary - On the Go<br/>
                <a class="text-xs font-sans hover:text-grey transition-color" href="/wheretoeat">Back
                    to Map/List</a>
            </h1>

            <img class="mb-4" src="{{ asset('assets/images/shares/wheretoeat-app.jpg') }}"
                 alt="Coeliac Sanctuary - On the Go"/>

            <p class="mb-4">
                Coeliac Sanctuary - On the Go connects to the Where to Eat guide on the Coeliac Sanctuary website to
                display the locations of Gluten Free places to eat around your location. You can also search for
                locations around the UK and Ireland to plan your next trip to the seaside!
            </p>
            <p class="mb-4">
                All places can either be displayed on a map or as a list and can be filtered to easily find the type of
                places you like to eat out at.
            </p>
            <p class="mb-4">
                All of the places on Coeliac Sanctuary are recommended to us by other people and are checked before they
                are added to the app, but if you have a bad experience at a location on our app, or if it no longer
                exists you can easily report it to us through the app.
            </p>
            <p class="mb-4">
                Coeliac Sanctuary - On the Go list places in the UK and Ireland only.
            </p>
            <p class="mb-4">
                At the moment the App is available for Android only, however, an Apple version is in the works!
            </p>
            <p class="mb-4">
                <a title="Google Play Store"
                   href="https://play.google.com/store/apps/details?id=com.coeliacsanctuary.onthego" target="_blank">
                    <img style="max-width: 250px"
                         src="https://play.google.com/intl/en_us/badges/images/generic/en_badge_web_generic.png"
                         alt="Get it on Google Play"><br/>
                    Download the App now from the Google Play store
                </a>
            </p>

        </div>
    </div>
@endsection

@section('secondary-column')
    <div class="flex flex-col">
        <x-widget class="mb-3" title="Sign up to our newsletter">
            <global-ui-newsletter-signup/>
        </x-widget>

        <global-ui-google-ad code="7266831645"></global-ui-google-ad>

        <x-widget name="Random Reviews">
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
