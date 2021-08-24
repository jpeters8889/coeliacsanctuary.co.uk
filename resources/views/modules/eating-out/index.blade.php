@extends('templates.page-single-column')

@section('primary-column')
    <div class="flex flex-col" chunk>
        <div class="page-box">
            <h1 class="my-4 p-3 text-3xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
                Find Gluten Free places to eat and visit, reviews, and more
            </h1>

            <div class="grid grid-cols 1 gap-y-3 lg:gap-y-0 sm:gap-x-3 sm:grid-cols-2 lg:grid-cols-4">
                <div class="bg-blue-light bg-opacity-50 rounded-lg p-3">
                    <a title="UK and Ireland Gluten Free Eateries" href="/wheretoeat"
                       class="flex flex-col items-center text-center">
                        <img src="{{ asset('assets/images/misc/wte_index_eateries.png') }}" alt="">
                        <h2 class="text-lg font-semibold mb-1">Eating Out Guide</h2>
                        <p>
                            Coeliac Sanctuary's Eating Out guide, listing places all over the UK who can cater to
                            Coeliac and gluten free diets, including attractions and hotels.
                        </p>
                    </a>
                </div>

                <div class="bg-blue-light bg-opacity-50 rounded-lg p-3">
                    <a title="UK and Ireland Gluten Free Eateries" href="/wheretoeat/browse"
                       class="flex flex-col items-center text-center">
                        <img src="{{ asset('assets/images/misc/wte_index_map.png') }}" alt="">
                        <h2 class="text-lg font-semibold mb-1">Eating Out Interactive Map</h2>
                        <p>
                            Not sure where to go? Check out our interactive map showing all of the gluten places to eat
                            across the UK and Ireland.
                        </p>
                    </a>
                </div>

                <div class="bg-blue-light bg-opacity-50 rounded-lg p-3">
                    <a title="Gluten Free Reviews" href="/review" class="flex flex-col items-center text-center">
                        <img src="{{ asset('assets/images/misc/wte_index_reviews.png') }}" alt="">
                        <h2 class="text-lg font-semibold mb-1">Our Reviews</h2>
                        <p>Read honest reviews of places we've visited from the Coeliac Sanctuary team!</p>
                    </a>
                </div>

                <div class="bg-blue-light bg-opacity-50 rounded-lg p-3">
                    <a title="Coeliac Sanctuary - On the Go Mobile App" href="/wheretoeat/coeliac-sanctuary-on-the-go"
                       class="flex flex-col items-center text-center">
                        <img src="{{ asset('assets/images/misc/wte_index_app.png') }}" alt="">
                        <h2 class="text-lg font-semibold mb-1">Coeliac Sanctuary - On the Go App</h2>
                        <p>Get all of our Gluten Free places to eat in your pocket!</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
