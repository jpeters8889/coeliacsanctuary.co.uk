@extends('templates.page-single-column')

@section('primary-column')
    <div class="flex flex-col" chunk>
        <div class="page-box">
            <h1 class="my-4 p-3 text-3xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
                Gluten Free Search Results for {{ $search->term }}<br/>
                <h6 class="text-center -mt-4 pt-1">
                    <a class="text-sm font-semibold font-sans hover:text-blue-dark transition-color" href="/wheretoeat">
                        Back to the Eating Out guide
                    </a>
                </h6>
            </h1>

            <p class="mt-4">
                Here are all the places we have that within <strong>{{ $search->range }} miles</strong> of
                <strong>{{ $search->term }}</strong>
            </p>
        </div>

        <wheretoeat-page-list search-term="{{ $search->term }}"
                              search-range="{{ $search->range }}"></wheretoeat-page-list>

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
