@extends('templates.page-single-column')

@section('primary-column')
    <div class="flex flex-col">
        <div class="page-box">
            <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
                Gluten Free Places to eat in {{ $county }}<br/>
            </h1>

            <h6 class="text-center -mt-4 pt-1">
                <a class="text-sm font-semibold font-sans hover:text-blue-dark transition-all" href="/wheretoeat">
                    Back to eating out guide...
                </a>
            </h6>

            <div class="flex flex-col space-y-2 mt-2">
                <p>
                    In the list below you can see cities, towns and villages in {{ $county }} that we know offer
                    gluten free options, whether these are places to eat, attractions or hotels / B&Bs.
                </p>

                <p>
                    All of the places in our eating out guide are recommended by people just like you, other
                    coeliacs visiting our website wanting to help others eat out safely!
                </p>

                <div>
                    <wheretoeat-ui-daily-update-subscribe :type-id="2" :updatable-id="{{ $id }}"
                                                          friendly-name="{{ $county }}"/>
                </div>

                <a href="/wheretoeat/recommend-a-place"
                   class="bg-blue-light bg-opacity-50 hover:bg-opacity-30 transition rounded-lg p-2 border border-blue group">
                    Do you know somewhere that offers gluten free that we should add to our guide?
                    <span class="font-semibold group-hover:text-blue-dark transition-all"
                          href="/wheretoeat/recommend-a-place">
                        Let us know!
                    </span>
                </a>
            </div>
        </div>


        <div class="page-box mt-2">
            <a class="text-xl text-center flex flex-col space-y-4 justify-center items-center" href="#guide">
                <p>View all places in {{ $county }}</p>
                <font-awesome-icon :icon="['fas', 'chevron-down']"
                                   class="text-6xl animate-bounce animate-pulse"></font-awesome-icon>
            </a>
        </div>

        @if($topPlaces && $topPlaces->count() > 0)
            <div class="page-box mt-2">
                <h2 class="text-2xl text-center font-semibold leading-tight md:text-left">
                    Top rated places to eat gluten free in {{ $county }}
                </h2>

                <p class="my-2">
                    These are the top rated places to eat gluten free in {{ $county }}, voted by people just
                    like you!
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-3">
                    @foreach($topPlaces as $topPlace)
                        <div
                            class="bg-gradient-to-br from-blue/50 to-blue-light/50 rounded p-2 space-y-2 shadow flex flex-col">
                            <h3 class="text-xl font-semibold">
                                <a href="{{ $topPlace->link() }}">
                                    {{ $topPlace->name }}
                                </a>
                            </h3>
                            <div class="font-semibold text-grey flex justify-between">
                                <a href="/wheretoeat/{{ $topPlace->county->slug }}/{{ $topPlace->town->slug }}">
                                    {{ $topPlace->town->town }}
                                </a>

                                <div class="flex flex-col justify-end">
                                    <global-ui-stars stars="{{ $topPlace->rating }}" align="end"></global-ui-stars>
                                    <span>from {{ $topPlace->rating_count }} votes</span>
                                </div>
                            </div>

                            <p class="flex-1">{{ $topPlace->info }}</p>

                            <p class="text-xs text-grey">{{ str_replace('<br />', ', ', $topPlace->address) }}</p>

                            <a class="font-semibold hover:underline mt-4 text-grey-darker hover:text-black block text-xs"
                               href="/wheretoeat/{{ $topPlace->county->slug }}/{{ $topPlace->town->slug }}"
                            >
                                View all places in {{ $topPlace->town->town }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="page-box mt-2" id="guide">
            <h2 class="text-2xl text-center font-semibold leading-tight md:text-left">
                Gluten Free eating out in {{ $county }}
            </h2>

            <p>
                Heading to {{ $county }}? Listed below are all the towns, villages and cities
                in {{ $county }}that have gluten free places listed in our eating out guide.
            </p>

            <div class="grid grid-cols-1 xs:grid-cols-2 md:grid-cols-3 gap-2 my-3">
                @foreach($towns as $town)
                    <div class="block bg-gradient-to-br from-blue/50 to-blue-light/50 rounded p-2 space-y-2 shadow">
                        <a href="/wheretoeat/{{ $slug }}/{{ $town->slug }}">
                            <h3 class="text-lg font-semibold mb-2">
                                {{ $town->town }}
                            </h3>

                            <p class="text-sm">
                                We've got {!! $town->snippet !!} in {{ $town->town }} listed in our eating out guide.
                            </p>
                        </a>
                    </div>
                @endforeach
            </div>

            <global-ui-google-ad code="5284484376"></global-ui-google-ad>
        </div>

        <div class="page-box mt-2">
            <h2 class="text-2xl text-center font-semibold leading-tight md:text-left">
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
