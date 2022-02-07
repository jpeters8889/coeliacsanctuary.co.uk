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

            <div class="flex flex-col">
                <div class="flex flex-col space-y-4">
                    <p>
                        Coeliac Sanctuary - On the Go connects to the eating out guide on the Coeliac Sanctuary
                        website to display the locations of gluten free places to eat around your location. You can also
                        search for locations around the UK and Ireland to plan your next trip to the seaside or to the
                        city!
                    </p>
                    <p>
                        All places can either be displayed on a map or as a list and can be filtered to easily find the
                        type of places you'd like to eat out at.
                    </p>
                    <p>
                        All of the places on Coeliac Sanctuary are recommended to us by other people and are checked
                        before they are added to the app, but if you have a bad experience at a location on our app, or
                        if it no longer exists you can easily report it to us through the app.
                    </p>
                    <p>
                        Coeliac Sanctuary - On the Go list places in the UK and Ireland only.
                    </p>
                </div>
                <div class="flex justify-center items-center text-center space-x-2 max-w-[900px] mx-auto">
                    <article-image
                        position="fullwidth"
                        src="{{ asset('assets/images/misc/app/1.png') }}"
                    ></article-image>
                    <article-image
                        position="fullwidth"
                        src="{{ asset('assets/images/misc/app/2.png') }}"
                    ></article-image>
                    <article-image
                        position="fullwidth"
                        src="{{ asset('assets/images/misc/app/3.png') }}"
                    ></article-image>
                </div>
            </div>

            <div class="flex flex-col space-y-4 sm:flex-row sm:justify-between sm:space-x-4 sm:space-y-0 sm:mt-4">
                <a title="Google Play Store"
                   href="https://play.google.com/store/apps/details?id=com.coeliacsanctuary.onthego"
                   target="_blank"
                   class="flex flex-col space-y-2 bg-gradient-to-br from-blue/30 to-blue-light/30 rounded p-2 lg:p-4 items-center sm:max-w-1/2 sm:h-full"
                >
                    <img style="width: 250px"
                         src="https://play.google.com/intl/en_us/badges/images/generic/en_badge_web_generic.png"
                         alt="Get it on Google Play"
                    />
                    <span class="font-semibold text-center">Download the App now from the Google Play store</span>
                </a>

                <a title="Apple App Store"
                   href="https://apps.apple.com/us/app/coeliac-sanctuary-on-the-go/id1608694621"
                   target="_blank"
                   class="flex flex-col space-y-2 bg-gradient-to-br from-blue/30 to-blue-light/30 rounded p-2 lg:p-4 items-center sm:max-w-1/2 sm:h-full"
                >
                    <img style="width: 220px"
                         class="py-[11px]"
                         src="https://tools.applemediaservices.com/api/badges/download-on-the-app-store/black/en-us?size=250x83&amp;releaseDate=1644192000&h=d94315b3908f3483bc41a28cdbda8bf7"
                         alt="Download on the App Store"
                    />
                    <span class="font-semibold text-center">Download the App now from the Apple App store</span>
                </a>
            </div>
        </div>
    </div>
@endsection
