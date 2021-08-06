@extends('templates.page-single-column')

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

            <div class="flex flex-col mt-2 space-y-2">
                <p>
                    Here you can see all of the nationwide chains in our Where to Eat guide that offer gluten free options in
                    {{ $town->town }}, {{ $county->county }}, from cafes, restaurants, to attractions and hotels.
                </p>

                <p>
                    Most of the places to eat listed in our guide are contributed by people like you, other Coeliac's or
                    people with a gluten intolerance who know of local places in their local area and are kind enough to
                    let us know.
                </p>

                <p>
                    Know somewhere that offers gluten free for us to add or does somewhere need removing off our
                    list? <a class="font-semibold hover:text-grey transition-color" href="/wheretoeat/place-request">Let us know!</a>
                </p>

                <wheretoeat-ui-daily-update-subscribe :type-id="3" :updatable-id="{{ $town->id }}"
                                                      friendly-name="{{ $town->town }}, {{ $county->county }}"/>

            </div>
        </div>

        <div class="min-h-map">
            <wheretoeat-page-list :county-id="{{ $county->id }}"
                                  :town-id="{{ $town->id }}"></wheretoeat-page-list>
        </div>

        <global-ui-google-ad code="5284484376"></global-ui-google-ad>

        <div class="page-box mt-2">
            <h2 class="text-2xl font-coeliac text-center font-semibold leading-tight md:text-left">
                Coeliac Sanctuary - On the Go App
            </h2>

            <p class="mt-2">
                Do you use our Eating Out guide often? Why not check out our <strong>Coeliac Sanctuary - On the
                    Go</strong> App to help you easily find places near you to eat Gluten Free!
            </p>

            <global-ui-link-button title="Coeliac Sanctuary - On the Go App"
                                   class="px-4 py-2 rounded-lg font-semibold my-2"
                                   href="/wheretoeat/coeliac-sanctuary-on-the-go"
            >
                Find out more...
            </global-ui-link-button>
        </div>
    </div>
@endsection
