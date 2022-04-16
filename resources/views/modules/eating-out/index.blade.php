@extends('templates.page-single-column')

@section('primary-column')
    <div class="flex flex-col" chunk>
        <div class="page-box">
            <h1 class="my-4 p-3 text-3xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
                Find Gluten Free places to eat and visit, reviews, and more
            </h1>

            <div class="flex flex-col space-y-3">
                <div class="bg-blue-light bg-opacity-50 rounded-lg p-3">
                    <a title="UK and Ireland Gluten Free Eateries"
                       href="/wheretoeat"
                       class="flex space-x-2">
                        <div class="w-1/4 max-w-[150px]">
                            <img src="{{ asset('assets/images/misc/wte_index_eateries.png') }}" alt=""/>
                        </div>

                        <div class="flex-1">
                            <h2 class="text-lg font-semibold mb-1">Eating Out Guide</h2>
                            <p>
                                Coeliac Sanctuary's Eating Out guide, listing places all over the UK who can cater to
                                Coeliac and gluten free diets, including attractions and hotels.
                            </p>
                        </div>
                    </a>
                </div>

                <div class="bg-blue-light bg-opacity-50 rounded-lg p-3">
                    <a title="UK and Ireland Gluten Free Eateries"
                       href="/wheretoeat/browse"
                       class="flex space-x-2">
                        <div class="w-1/4 max-w-[150px]">
                            <img src="{{ asset('assets/images/misc/wte_index_map.png') }}" alt=""/>
                        </div>

                        <div class="flex-1">
                            <h2 class="text-lg font-semibold mb-1">Eating Out Interactive Map</h2>
                            <p>
                                Not sure where to go? Check out our interactive map showing all of the gluten places to
                                eat
                                across the UK and Ireland.
                            </p>
                        </div>
                    </a>
                </div>

                <div class="bg-blue-light bg-opacity-50 rounded-lg p-3">
                    <a title="UK and Ireland Gluten Free Eateries"
                       href="/wheretoeat/nationwide"
                       class="flex space-x-2">
                        <div class="w-1/4 max-w-[150px]">
                            <img src="{{ asset('assets/images/misc/wte_index_eateries.png') }}" alt=""/>
                        </div>

                        <div class="flex-1">
                            <h2 class="text-lg font-semibold mb-1">Gluten Free Nationwide Chains</h2>
                            <p>Nationwide chains across the UK that can cater to gluten free diets</p>
                        </div>
                    </a>
                </div>

                <div class="bg-blue-light bg-opacity-50 rounded-lg p-3">
                    <a title="Coeliac Sanctuary - On the Go Mobile App"
                       href="/wheretoeat/coeliac-sanctuary-on-the-go"
                       class="flex space-x-2">
                        <div class="w-1/4 max-w-[150px]">
                            <img src="{{ asset('assets/images/misc/wte_index_app.png') }}" alt=""/>
                        </div>

                        <div class="flex-1">
                            <h2 class="text-lg font-semibold mb-1">Coeliac Sanctuary - On the Go App</h2>
                            <p>Get all of our Gluten Free places to eat in your pocket!</p>
                        </div>
                    </a>
                </div>

                <div class="bg-blue-light bg-opacity-50 rounded-lg p-3">
                    <a title="Coeliac Sanctuary - On the Go Mobile App"
                       href="/wheretoeat/recommend-a-place"
                       class="flex space-x-2">
                        <div class="w-1/4 max-w-[150px]">
                            <img src="{{ asset('assets/images/misc/wte_index_reviews.png') }}" alt=""/>
                        </div>

                        <div class="flex-1">
                            <h2 class="text-lg font-semibold mb-1">Recommend a place</h2>
                            <p>Do you know of somewhere missing from our eating out guide? Let us know!</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
