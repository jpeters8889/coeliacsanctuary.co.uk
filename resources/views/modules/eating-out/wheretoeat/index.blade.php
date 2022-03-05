@extends('templates.page-single-column')

@section('primary-column')
    <div class="flex flex-col">
        <div class="page-box">
            <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
                Gluten Free Places to Eat and Visit
            </h1>

            <p>
                Our Where to Eat guide lists 1,000s of independent eateries all over the UK and Ireland that offer
                gluten free options or have a gluten free menu.
            </p>
            <p class="mt-2">
                Most of the places to eat listed in our guide are contributed by people like you, other Coeliac's or
                people with a gluten intolerance who know of local places in their local area and are kind enough to let
                us know through our <a class="font-semibold hover:text-blue-dark transition-all"
                                       href="/wheretoeat/recommend-a-place" target="_blank">recommend a place</a> form.
            </p>
            <p class="mt-2">
                You won't find any nationwide chains in our normal eating out guide simply due to how many places these
                chains have, the other independent eateries will get lost! Instead, we list
                <a class="font-semibold hover:text-blue-dark transition-all" href="/wheretoeat/nationwide">nationwide
                    chains</a> on a separate page.
            </p>

            <search-ui-wheretoeat-widget></search-ui-wheretoeat-widget>
        </div>

        <div class="page-box mt-2">
            <a class="text-xl text-center flex flex-col space-y-4 justify-center items-center" href="#guide">
                <p>Or just browse our Eating Out guide...</p>
                <font-awesome-icon :icon="['fas', 'chevron-down']" class="text-6xl animate-bounce animate-pulse"></font-awesome-icon>
            </a>
        </div>

        <div class="page-box mt-2">
            <h2 class="text-2xl text-center font-semibold leading-tight md:text-left">
                Top rated places to eat gluten free around the UK and Ireland
            </h2>

            <p class="my-2">
                These are the top rated places to eat gluten free in our eating out guide, voted by people just
                like you!
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 my-3">
                @foreach($topPlaces as $topPlace)
                    <div class="bg-gradient-to-br from-blue/50 to-blue-light/50 rounded p-2 space-y-2 shadow flex flex-col">
                        <h3 class="text-xl font-semibold">{{ $topPlace->name }}</h3>
                        <div class="font-semibold text-grey flex justify-between">
                            <div class="text-sm">
                                <a class="hover:underline"
                                   href="/wheretoeat/{{ $topPlace->county->slug }}/{{ $topPlace->town->slug }}">
                                    {{ $topPlace->town->town }}
                                </a><br/>
                                <a class="hover:underline"
                                   href="/wheretoeat/{{ $topPlace->county->slug }}">{{ $topPlace->county->county }}</a>
                            </div>

                            <div class="flex flex-col justify-end text-sm">
                                <global-ui-stars stars="{{ $topPlace->average_rating }}"
                                                 align="end"></global-ui-stars>
                                <span>from {{ $topPlace->userReviews->count() }} votes</span>
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

        <div class="page-box mt-2" id="guide">
            <h2 class="text-2xl text-center font-semibold leading-tight md:text-left">
                Gluten Free around the UK and Ireland
            </h2>

            <p class="my-2">
                Our eating out guide is split into countries, counties and then towns or cities, click or tap on a
                country below to get started!
            </p>

            <div class="flex flex-col space-y-2">
                @foreach($list as $country => $details)
                    <wheretoeat-ui-index-country
                        country="{{ $country }}"
                        :details='@json($details)'
                    ></wheretoeat-ui-index-country>
                @endforeach
            </div>
        </div>
    </div>
@endsection
