@extends('templates.page-two-column')

@section('primary-column')
    <div class="flex flex-col">
        <div class="min-h-screen page-box">
            <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
                Gluten Free Places to Eat and Visit
            </h1>

            <p>
                Our Where to Eat guide lists 1000s of independent eateries all over the UK and Ireland that offer gluten
                free options or have a gluten free menu.
            </p>
            <p class="mt-2">
                Most of the places to eat listed in our guide are contributed by people like you, other Coeliac's or
                people with a gluten intolerance who know of local places in their local area and are kind enough to let
                us know through our <a class="font-semibold hover:text-blue-dark transition-colour"
                                       href="/wheretoeat/place-request" target="_blank">Place Request form</a>.
            </p>
            <p class="mt-2">
                Our eating out guide can be viewed as an interactive map of all the counties across the UK, or as a
                simple list to make it easier to find what you're looking for. Each county in then broken down into
                individual cities, towns or even villages, and then you can easily view places in that area.
            </p>
            <p class="mt-2">
                You won't find any nationwide chains in our normal eating out guide simply due to how many places these
                chains have, the other independent eateries will get lost! Instead, we list
                <a class="font-semibold hover:text-blue-dark transition-colour" href="/wheretoeat/nationwide">nationwide
                    chains</a> on a separate page.
            </p>

            <wheretoeat-ui-quick-search></wheretoeat-ui-quick-search>

            <global-ui-tabs base-url="wheretoeat">
                <global-ui-tab title="Map" url="map">
                    <wheretoeat-tabs-map></wheretoeat-tabs-map>
                </global-ui-tab>

                <global-ui-tab title="List" url="list" mobile-default>
                    <ul class="flex flex-col">
                        @foreach($list as $country => $counties)
                            @if($country !== 'Nationwide')
                                <li>
                                    <global-ui-accordion group="countries" name="{{ $country }}">
                                        <template v-slot:title>
                                            <h3 class="cursor-pointer border-b border-blue-light-50 p-1 text-lg text-black">{{ $country }}</h3>
                                        </template>

                                        <template v-slot:body>
                                            @foreach($counties as $county)
                                                <a href="/wheretoeat/{{ $county['slug'] }}"
                                                   class="text-grey text-base p-1 border-b border-blue-light-50 flex flex-col">
                                                    <h4 class="font-semibold">{{ $county['name'] }}</h4>
                                                    <h5 class="text-sm">{{ $county['details'] }}</h5>
                                                </a>
                                            @endforeach
                                        </template>
                                    </global-ui-accordion>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </global-ui-tab>

                <global-ui-tab title="Nationwide Places" url="nationwide">
                    <wheretoeat-page-list :county-id="{{ $nationwide_id }}">
                        <template v-slot:intro>
                            <p class="mb-4" id="nationwide-eateries">
                                Here you can find chain restaurants and eateries that offer gluten free. We don't show
                                these places within our main Where To Eat guide because there is so many of them.
                            </p>
                            <p>
                                You can use the tabs above to filter the results to find the type of places you want.
                            </p>
                        </template>
                    </wheretoeat-page-list>
                </global-ui-tab>
            </global-ui-tabs>

        </div>
    </div>
@endsection

@section('secondary-column')
    <div class="flex flex-col">
        <x-widget class="mb-3" title="Search Places">
            <search-ui-wheretoeat-widget />
        </x-widget>

        <x-widget class="mb-3" title="Sign up to our newsletter">
            <global-ui-newsletter-signup/>
        </x-widget>

        <global-ui-google-ad code="7266831645"></global-ui-google-ad>

        @include('components.related-item', [$title = 'Recent Reviews', $related])
    </div>
@endsection

{{--@section('footerJavascript')--}}
{{--    <script async src="{{ asset('assets/external/wteMap/raphael-min.js') }}"></script>--}}
{{--    <script async src="{{ asset('assets/external/wteMap/map.js') }}"></script>--}}
{{--@endsection--}}
