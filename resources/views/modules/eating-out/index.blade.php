@extends('templates.page-two-column')

@section('primary-column')
    <div class="flex flex-col"chunk>
        <div class="page-box">
            <h1 class="text-2xl font-coeliac text-center font-semibold leading-tight md:text-left">
                Find Gluten Free places to eat and visit, reviews, and more
            </h1>
            <div class="flex flex-col -mx-3 md:flex-row">
                <div class="bg-blue-light-50 rounded-lg m-3 p-3">
                    <a title="UK and Ireland Gluten Free Eateries" href="/wheretoeat" class="flex flex-col items-center text-center">
                        <img src="{{ asset('assets/images/misc/wte_index_eateries.png') }}" alt="">
                        <h2 class="text-lg font-semibold mb-1">UK/Ireland Eateries</h2>
                        <p>Find Gluten Free places to eat, attractions and hotels!</p>
                    </a>
                </div>

                <div class="bg-blue-light-50 rounded-lg m-3 p-3">
                    <a title="Gluten Free Reviews" href="/review" class="flex flex-col items-center text-center">
                        <img src="{{ asset('assets/images/misc/wte_index_reviews.png') }}" alt="">
                        <h2 class="text-lg font-semibold mb-1">Reviews</h2>
                        <p>Read honest reviews of places from the Coeliac Sanctuary team!</p>
                    </a>
                </div>

                <div class="bg-blue-light-50 rounded-lg m-3 p-3">
                    <a title="Coeliac Sanctuary - On the Go Mobile App" href="/wheretoeat/coeliac-sanctuary-on-the-go" class="flex flex-col items-center text-center">
                        <img src="{{ asset('assets/images/misc/wte_index_app.png') }}" alt="">
                        <h2 class="text-lg font-semibold mb-1">Coeliac Sanctuary - On the Go App</h2>
                        <p>Get all of our Gluten Free places to eat in your pocket!</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('secondary-column')
    <div class="flex flex-col">
        <x-widget class="mb-3" title="Sign up to our newsletter">
            <widget-newsletter-signup />
        </x-widget>

        <google-ad code="7266831645"></google-ad>
    </div>
@endsection
