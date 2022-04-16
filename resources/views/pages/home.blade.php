@extends('layouts.coeliac')

@section('content')
    @include('components.announcement')

    <!-- Header -->
    <div class="w-full flex flex-col h-screen hero-background xs:h-95vh max-h-hero">
        <div class="w-full flex flex-col h-full bg-gradient-to-br from-blue/90 to-blue-light/90">
            <div class="flex items-center" style="min-height: 50px">
                <global-layout-top-bar transparent>
                    <global-layout-mobile-nav class="mr-2 md:hidden"></global-layout-mobile-nav>
                    <a href="/">
                        <global-layout-coeliac-icon class="js-mob-icon text-white md:hidden"
                                                    style="height: 1.875rem"></global-layout-coeliac-icon>
                    </a>
                    <coeliac-nav class="hidden md:block"></coeliac-nav>
                    <search-ui-header
                        class="h-full flex items-center md:absolute md:right-0 md:top-0 md:mr-2"></search-ui-header>
                </global-layout-top-bar>
            </div>
            <div class="flex flex-1 p-8">
                <div class="flex-1 flex flex-col">
                    <div class="flex flex-col justify-center items-center mb-4 space-y-2" style="min-height: 160px;">
                        <div class="w-1/2 max-h-logo flex-1">
                            <x-svg-logo></x-svg-logo>
                        </div>
                        <h1 class="text-4xl font-medium font-coeliac mb-2 text-center">Coeliac Sanctuary</h1>
                    </div>

                    <page-home-heros></page-home-heros>

                    <div class="flex-1 flex flex-col justify-center items-center inner-wrapper">
                        <div class="xxs:hidden bg-white bg-opacity-80 p-4 w-full md:w-3/4">
                            <h2 class="mb-2 px-4 text-2xl font-semibold text-center">
                                Coeliac Sanctuary Shop
                            </h2>
                            <p class="mb-2">
                                Check out our online shop for some great coeliac related goodies, including our
                                fantastic travel cards for when
                                you go abroad, our 'Gluten Free' stickers, our wristbands, and much more too!
                            </p>
                            <div class="flex justify-center">
                                <a href="/shop"
                                   class="bg-yellow px-6 py-2 font-semibold leading-none inline-block text-xl transition-all">
                                    Visit our Shop
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="items-baseline flex justify-center mt-4 w-full" style="min-height: 32px">
                        <div class="text-3xl leading-none text-white text-opacity-80 pulse">
                            <font-awesome-icon :icon="['fas', 'chevron-down']"></font-awesome-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Intro -->
    @include('components.competition')

    <div class="inner-wrapper">
        <section class="page-box mt-3">
            <h1 class="p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-blue-light">
                Welcome to Coeliac Sanctuary
            </h1>

            <p>
                Here at Coeliac Sanctuary we make it our aim to offer more than just a gluten free blog. Fancy something
                different? We have plenty of gluten free <a href="/recipe">recipes</a> which are tried and tested by our
                owner Alison. Eating out? Let us help you find places to safely eat as a Coeliac with our
                '<a href="/wheretoeat">Where to eat</a>' guide which is full of places recommended by you, our audience.
                Going abroad? We have our <a href="/shop">shop</a> where you can buy translation cards aimed at making
                eating out with a language barrier easier and safer along with many more useful items for kids and
                adults alike.
            </p>
            <p class="mt-2">
                Our website is our own official sanctuary for Coeliac's to get tips, hints and tricks. If you have any
                recommendations or recipes you would like us to try please feel free to
                <contact-trigger inline
                                 class="text-blue-dark cursor-pointer font-semibold hover:text-black transition-all">
                    contact us
                </contact-trigger>
                !
            </p>
        </section>

        <!-- Latest Blogs -->
        <section>
            <div class="page-box mt-4">
                <h1 class="font-coeliac font-semibold text-2xl">Latest Coeliac Blogs</h1>
                <p>
                    Our motto is that we're more than just a gluten free blog, but blogs are still the heart and soul of
                    Coeliac Sanctuary, we'll write about a bit of everything, from coeliac news, new products, guides,
                    and more, we're sure you'll find something you'll love here!
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 mt-2 gap-2">
                @foreach($latestBlogs as $blog)
                    <div class="bg-white w-full overflow-hidden flex flex-col shadow">
                        <div>
                            <a href="/blog/{{ $blog->slug }}">
                                <img loading="lazy" class="lazy" data-src="{{ $blog->main_image }}"
                                     src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"
                                     alt="{{ $blog->title }}"/>
                            </a>
                        </div>
                        <div class="p-2 flex flex-col h-full">
                            <a href="/blog/{{ $blog->slug }}" class="flex-1">
                                <h2 class="font-semibold hover:underline text-lg">
                                    {{ $blog->title }}
                                </h2>
                            </a>
                            <p>{{ $blog->meta_description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <global-ui-google-ad code="9266309021"></global-ui-google-ad>

        <!-- Latest Recipes -->
        <section>
            <div class="page-box p-4">
                <h1 class="font-coeliac font-semibold text-2xl">Latest Coeliac Recipes</h1>
                <p>
                    Why not check out some of our fabulous, gluten free, coeliac recipes! All of our recipes are tried
                    and tested by us, and as much as we can will always use simple, easy to get ingredients, readily
                    available in most supermarkets!
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 mt-2 gap-2">
                @foreach($latestRecipes as $recipe)
                    <div class="bg-white w-full overflow-hidden flex flex-col shadow">
                        <div>
                            <a href="/recipe/{{ $recipe->slug }}">
                                <img loading="lazy" class="lazy"
                                     src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"
                                     data-src="{{ $recipe->square_image }}" alt="{{ $recipe->title }}"/>
                            </a>
                        </div>
                        <div class="p-2 flex flex-col h-full">
                            <a href="/recipe/{{ $recipe->slug }}">
                                <h3 class="font-semibold hover:underline">{{ $recipe->title }}</h3>
                            </a>
                            <p>{{ $recipe->meta_description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Latest Reviews -->
        <section>
            <div class="page-box mt-4">
                <h1 class="font-coeliac font-semibold text-2xl">Coeliac Eating Out Guide</h1>
                <p>
                    Being coeliac, eating out isn't always easy, if you're anything like us you'll research and plan way
                    before you'll go anywhere, that's why we have our comprehensive
                    <a href="/wheretoeat" class="font-semibold hover:underline">eating out guide</a>, populated from
                    recommendations
                    by people like you, and full of reviews and ratings to help you eat out safely!
                </p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 mt-2 gap-2">
                <div class="bg-white w-full overflow-hidden flex flex-col shadow">
                    <h2 class="text-xl text-center font-semibold text-blue-dark py-2">
                        Latest Place Ratings
                    </h2>

                    @foreach($latestRatings as $rating)
                        <div class="flex border-b last:border-b-0 border-blue-light p-2">
                            <div class="flex flex-col space-y-3 w-1/2">
                                <a href="{{ $rating['slug'] }}">
                                    <h3 class="text-lg font-semibold hover:text-blue-dark">
                                        {{ $rating['name'] }}
                                    </h3>
                                </a>

                                <a href="{{ $rating['town'] }}">
                                    <span class="text-grey text-sm hover:text-grey-darker">
                                        {{ $rating['full_location'] }}
                                    </span>
                                </a>
                            </div>

                            <div class="flex flex-col justify-between w-1/2 items-end">
                                <div class="py-2">
                                    <global-ui-stars
                                        stars="{{ $rating['rating'] }}"
                                        size="text-lg"
                                        half-star="star-half-alt"
                                        show-all
                                    ></global-ui-stars>
                                </div>

                                <span class="text-sm text-grey">{{ $rating['created_at'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="bg-white w-full overflow-hidden flex flex-col shadow">
                    <h2 class="text-xl text-center font-semibold text-blue-dark py-2">
                        Latest Additions
                    </h2>

                    @foreach($latestPlaces as $place)
                        <div class="flex flex-col border-b last:border-b-0 border-blue-light p-2">
                            <a href="{{ $place['slug'] }}">
                                <h3 class="text-lg font-semibold hover:text-blue-dark">
                                    {{ $place['name'] }}
                                </h3>
                            </a>

                            <a href="{{ $place['town'] }}">
                                <span class="text-grey text-sm hover:text-grey-darker">
                                    {{ $place['location'] }}
                                </span>
                            </a>

                            <span class="text-sm text-grey">{{ $place['created_at'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
    </section>

    <section class="mt-4 flex flex-col md:flex-row">
        <div class="page-box md:w-3/5">
            <h2 class="font-coeliac font-semibold text-2xl text-center">Around the website</h2>
            <p>
                Coeliac Sanctuary is more than just a gluten free blog, from our online shop, to our recipes, eating
                out guide and more, we're a hive of all things coeliac, take a look round, and we're sure you'll
                find something you'll enjoy!
            </p>
            <div class="flex flex-wrap justify-center mt-2">
                @foreach($stats as $stat)
                    <a href="{{ $stat['link'] }}"
                       class="flex flex-col w-115px m-2 justify-center items-center bg-grey-light shadow-md rounded-lg p-2 text-blue-other">
                        <font-awesome-icon class="text-3xl mb-1" :icon="{{ $stat['icon'] }}"></font-awesome-icon>
                        <span class="flex-1 text-center leading-none">{{ $stat['label'] }}</span>
                        <global-ui-number-counter class="text-3xl sm:text-2xl"
                                                  :to="{{ $stat['count'] }}"></global-ui-number-counter>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="page-box mt-4 md:w-2/5 md:ml-2 md:mt-0">
            <h2 class="font-coeliac font-semibold text-2xl text-center">About Coeliac Sanctuary</h2>
            <p>
                <img
                    src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"
                    data-src="{{ asset('assets/images/misc/alison.jpg') }}"
                    loading="lazy" class="lazy mb-1 ml-1 w-1/2 float-right xs:w-1/3" alt="Alison"/>
                Coeliac Sanctuary is owned by Alison, who has been Coeliac since 2014. Previously working as a web
                developer and also having a love of writing, Coeliac Sanctuary blossomed from the tough time she had
                been through during illness as a way to share recipes, information and keep track of places to eat
                safely, with a shop added later selling translation cards, wristbands and more.
            </p>
            <p class="mt-2">
                <a href="/about" class="font-semibold">Read more about us!</a>
            </p>
        </div>
    </section>
    </div>
    @include('components.footer')
@endsection
