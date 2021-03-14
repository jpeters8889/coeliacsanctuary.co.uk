@extends('templates.page-two-column')

@section('primary-column')
    <div class="flex flex-col" chunk>
        <div class="page-box">
            <h1 class="my-4 p-3 text-3xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
                Gluten Free Places to eat in {{ $town->town }}, {{ $county->county }}<br/>
            </h1>

            <h6 class="text-center -mt-4 pt-1">
                <a class="text-sm font-semibold font-sans hover:text-blue-dark transition-color"
                   href="/wheretoeat/{{ $county->slug }}">
                    Back to {{ $county->county }}
                </a>
            </h6>

            <div class="flex flex-col mt-2">
                <p class="mb-4">
                    Here you can see all of the places in our Where to Eat guide that offer gluten free options in
                    {{ $town->town }}, {{ $county->county }}, from cafes, restaurants, to attractions and hotels.
                </p>

                <p class="mt-2">
                    Most of the places to eat listed in our guide are contributed by people like you, other Coeliac's or
                    people with a gluten intolerance who know of local places in their local area and are kind enough to
                    let us know.
                </p>

                <p class="mt-2">
                    You won't find any nationwide chains in our normal eating out guide simply due to how many places
                    these chains have, the other independent eateries will get lost! Instead, we list
                    <a class="font-semibold hover:text-blue-dark transition-colour" href="/wheretoeat/nationwide">nationwide
                        chains</a> on a separate page.
                </p>

                <p>
                    You can use the tabs below to filter the results to find the type of places you want.
                </p>

                <div class="mt-2 flex flex-col bg-blue-light-50 border text-sm border-blue p-2">
                    <p>
                        Know somewhere that offers gluten free for us to add or does somewhere need removing off our
                        list? <a class="font-semibold hover:text-grey transition-color"
                                 href="/wheretoeat/place-request">Let us know!</a>
                    </p>
                </div>

                <div class="min-h-map">
                    <wheretoeat-list :county-id="{{ $county->id }}" :town-id="{{ $town->id }}"></wheretoeat-list>
                </div>

                <google-ad code="5284484376"></google-ad>

                <div class="flex flex-col bg-blue-light-50 border text-sm border-blue p-2">
                    <p>
                        Know somewhere that offers gluten free for us to add or does somewhere need removing off our
                        list? <a class="font-semibold hover:text-grey transition-color"
                                 href="/wheretoeat/place-request">Let us know!</a>
                    </p>
                </div>
            </div>
        </div>

        <div class="page-box mt-2">
            <h2 class="text-2xl font-coeliac text-center font-semibold leading-tight md:text-left">
                Coeliac Sanctuary - On the Go App
            </h2>

            <p class="mt-2">
                Do you use our Eating Out guide often? Why not check out our <strong>Coeliac Sanctuary - On the
                    Go</strong> App to help you easily find places near you to eat Gluten Free!
            </p>

            <link-button title="Coeliac Sanctuary - On the Go App"
                         class="px-4 py-2 rounded-lg font-semibold my-2"
                         href="/wheretoeat/coeliac-sanctuary-on-the-go"
            >
                Find out more...
            </link-button>
        </div>
    </div>
@endsection

@section('secondary-column')
    <div class="flex flex-col">
        <x-widget class="mb-3" title="Search Places">
            <widget-wheretoeat-search />
        </x-widget>

        <x-widget class="mb-3" title="Sign up to our newsletter">
            <widget-newsletter-signup/>
        </x-widget>

        <google-ad code="7266831645"></google-ad>

        @include('components.related-item', [$title = 'Recent Reviews', $related])
    </div>
@endsection
