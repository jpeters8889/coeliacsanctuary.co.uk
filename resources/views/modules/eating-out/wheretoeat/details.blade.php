@extends('templates.page-single-column')

@section('primary-column')
    <wheretoeat-page-eatery-details :eatery='@JSON($eatery)'></wheretoeat-page-eatery-details>

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
@endsection
