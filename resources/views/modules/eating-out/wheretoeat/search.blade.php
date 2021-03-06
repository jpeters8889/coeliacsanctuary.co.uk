@extends('templates.page-two-column')

@section('primary-column')
    <div class="flex flex-col"chunk>
        <div class="page-box">
            <h1 class="text-2xl font-coeliac text-center font-semibold leading-tight md:text-left">
                Gluten Free Search Results for {{ $search->term }}<br />
                <a class="text-xs font-sans hover:text-grey transition-color" href="/wheretoeat">Back to Map/List</a>
            </h1>

            <div class="flex flex-col mt-2">
                <div class="flex flex-col bg-blue-light-50 border text-sm border-blue p-2 mb-4">
                    <p>
                        Know somewhere that offers gluten free for us to add or does somewhere need removing off our
                        list? <a class="font-semibold hover:text-grey transition-color"
                                 href="/wheretoeat/place-request">Let us know!</a>
                    </p>
                </div>

                <wheretoeat-page-list search-term="{{ $search->term }}" search-range="{{ $search->range }}">
                    <template v-slot:intro>
                        <p class="mb-4">
                            Here are your search term for places within <strong>{{ $search->range }} miles</strong> of
                            <strong>{{ $search->term }}</strong>
                        </p>
                        <p>
                            You can use the tabs above to filter the results to find the type of places you want.
                        </p>
                    </template>
                </wheretoeat-page-list>

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

            <global-ui-link-button title="Coeliac Sanctuary - On the Go App"
                         class="px-4 py-2 rounded-lg font-semibold my-2"
                         href="/wheretoeat/coeliac-sanctuary-on-the-go"
            >
                Find out more...
            </global-ui-link-button>
        </div>
    </div>
@endsection

@section('secondary-column')
    <div class="flex flex-col">
        <<x-widget class="mb-3" title="Search Places">
            <search-ui-wheretoeat-widget />
        </x-widget>

        <x-widget class="mb-3" title="Sign up to our newsletter">
            <global-ui-newsletter-signup/>
        </x-widget>

        <global-ui-google-ad code="7266831645"></global-ui-google-ad>

        @include('components.related-item', [$title = 'Recent Reviews', $related])
    </div>
@endsection
