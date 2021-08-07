@extends('templates.page-single-column')

@section('primary-column')
    <div class="flex flex-col" chunk>
        <div class="page-box flex flex-col space-y-3 main-body">
            <h1 class="my-4 p-3 text-3xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
                Recommend a Place
            </h1>

            <p>
                Do you know a place that needs adding to our guide? Well give us as much details as possible below and
                we'll check it out, verify it and get it added to our list!
            </p>

            <p>
                We rely on people like you providing us with information on places where people can eat out safely and
                helping us create a great eating out guide!
            </p>

            <p>
                Our eating out guide is full of independent eateries around the UK and Ireland, and we list
                <a href="/wheretoeat/nationwide">nationwide chains</a>, such as Nando's, Bella Italia separately.
            </p>

            <p>
                Don't forget to check out our <a href="/wheretoeat">eating guide</a> first to see if the place you're
                recommending is already listed.
            </p>

            <wheretoeat-pages-place-request
                :venue-types='@json($venueTypes)'
            >
            </wheretoeat-pages-place-request>
        </div>
    </div>
@endsection
