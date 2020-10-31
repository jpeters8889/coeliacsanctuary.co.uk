@extends('templates.page-two-column')

@section('primary-column')
    <div class="flex flex-col" style="max-width: 1200px">
        <div class="page-box">
            <h1 class="text-2xl font-coeliac text-center font-semibold leading-tight md:text-left">
                Gluten Free Places to Eat and Visit
            </h1>

            <p>
                Find independent places to eat that offer gluten free options on our Map and List page, you can also
                find Nationwide chains that offer gluten free options on a separate page to avoid cluttering our lists.
            </p>

            <wheretoeat-quick-search></wheretoeat-quick-search>

            <tabs base-url="wheretoeat">
                <tab title="Map" url="map">
                    <wheretoeat-map></wheretoeat-map>
                </tab>

                <tab title="List" url="list" mobile-default>
                    <ul class="flex flex-col">
                        @foreach($list as $country => $counties)
                            @if($country !== 'Nationwide')
                                <li>
                                    <accordion group="countries" name="{{ $country }}">
                                        <template v-slot:title>
                                            <h3 class="cursor-pointer border-b border-blue-light-50 p-1 text-lg text-black">{{ $country }}</h3>
                                        </template>

                                        <template v-slot:body>
                                            @foreach($counties as $county => $details)
                                                <a href="/wheretoeat/{{ $county }}"
                                                   class="text-grey text-base p-1 border-b border-blue-light-50 flex flex-col">
                                                    <h4 class="font-semibold">{{ $county }}</h4>
                                                    <h5 class="text-sm">{{ $details }}</h5>
                                                </a>
                                            @endforeach
                                        </template>
                                    </accordion>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </tab>

                <tab title="Nationwide Places" url="nationwide">
                    <wheretoeat-list :county-id="{{ $nationwide_id }}">
                        <template v-slot:intro>
                            <p class="mb-4">
                                Here you can find chain restaurants and eateries that offer gluten free. We don't show
                                these places within our main Where To Eat guide because there is so many of them.
                            </p>
                            <p>
                                You can use the tabs above to filter the results to find the type of places you want.
                            </p>
                        </template>
                    </wheretoeat-list>
                </tab>
            </tabs>

        </div>
    </div>
@endsection

@section('secondary-column')
    <div class="flex flex-col">
        <widget-wheretoeat-search class="mb-3"></widget-wheretoeat-search>

        <widget-newsletter-signup class="mb-3"></widget-newsletter-signup>

        @include('components.related-item', [$title = 'Recent Reviews', $related])
    </div>
@endsection

@section('footerJavascript')
    <script src="{{ asset('assets/external/wteMap/raphael-min.js') }}"></script>
    <script src="{{ asset('assets/external/wteMap/map.js') }}"></script>
@endsection
