@extends('templates.page-two-column')

@section('primary-column')
    <div class="flex flex-col" style="max-width: 1200px">
        <div class="page-box">
            <h1 class="text-2xl font-coeliac text-center font-semibold leading-tight md:text-left">
                Gluten Free Places to eat in {{ $town->town }}, {{ $county->county }}<br />
                <a class="text-xs font-sans hover:text-grey transition-color" href="/wheretoeat/{{ $county->slug }}">Back
                    to {{ $county->county }}</a>
            </h1>

            <div class="flex flex-col mt-2">
                <div class="flex flex-col bg-blue-light-50 border text-sm border-blue p-2 mb-4">
                    <p>
                        Know somewhere that offers gluten free for us to add or does somewhere need removing off our
                        list? <a class="font-semibold hover:text-grey transition-color"
                                 href="/wheretoeat/place-request">Let us know!</a>
                    </p>
                </div>

                <wheretoeat-list :county-id="{{ $county->id }}" :town-id="{{ $town->id }}">
                    <template v-slot:intro>
                        <p class="mb-4">
                            Here you can see all of the places in our Where to Eat guide that offer gluten free options in
                            {{ $town->town }}, {{ $county->county }}.
                        </p>
                        <p>
                            You can use the tabs above to filter the results to find the type of places you want.
                        </p>
{{--                        <google-ad code="5284484376"></google-ad>--}}
                    </template>
                </wheretoeat-list>

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
        <widget-wheretoeat-search class="mb-3"></widget-wheretoeat-search>

        <widget-newsletter-signup class="mb-3"></widget-newsletter-signup>

        @include('components.related-item', [$title = 'Recent Reviews', $related])
    </div>
@endsection
