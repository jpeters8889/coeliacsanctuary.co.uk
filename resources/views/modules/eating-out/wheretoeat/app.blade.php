@extends('templates.page-single-column')

@section('primary-column')
    <div class="flex flex-col" chunk>
        <div class="page-box">
            <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
                Coeliac Sanctuary - On the Go<br/>
            </h1>

            <h6 class="text-center -mt-4 mb-2 pt-1">
                <a class="text-sm font-semibold font-sans hover:text-blue-dark transition-all" href="/wheretoeat">
                    Back to eating out guide...
                </a>
            </h6>

            <img class="mb-4 mx-auto" src="{{ asset('assets/images/shares/wheretoeat-app.jpg') }}"
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
