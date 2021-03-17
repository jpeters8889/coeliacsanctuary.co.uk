@extends('layouts.coeliac')

@section('content')
    @include('components.announcement')

    <!-- Header -->
    <div class="w-full flex flex-col h-screen hero-background xs:h-95vh max-h-hero">
        <div class="w-full flex flex-col h-full bg-blue-gradient-90">
            <div class="flex items-center" style="min-height: 50px">
                <global-layout-top-bar transparent>
                    <global-layout-mobile-nav class="mr-2 md:hidden"></global-layout-mobile-nav>
                    <a href="/">
                        <global-layout-coeliac-icon class="js-mob-icon text-white md:hidden" style="height: 1.875rem"></global-layout-coeliac-icon>
                    </a>
                    <coeliac-nav class="hidden md:block"></coeliac-nav>
                    <header-search class="h-full flex items-center md:absolute md:right-0 md:top-0 md:mr-2"></header-search>
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

                    <coeliac-home-heros></coeliac-home-heros>

                    <div class="flex-1 flex flex-col justify-center items-center inner-wrapper">
                        <div class="xxs:hidden bg-white-80 p-4 w-full md:w-3/4">
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
                                   class="bg-yellow px-6 py-2 font-semibold leading-none inline-block text-xl transition-width">
                                    Visit our Shop
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="items-baseline flex justify-center mt-4 w-full" style="min-height: 32px">
                        <div class="text-3xl leading-none text-white-80 pulse">
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
        <section class="page-box mt-4">
            <h2 class="font-coeliac font-semibold text-2xl text-center">Welcome to Coeliac Sanctuary</h2>
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
                <contact-trigger inline class="text-blue cursor-pointer font-semibold hover:underline">contact us
                </contact-trigger>
                !
            </p>
        </section>

        <!-- Latest Blogs -->
        <section class="page-box mt-4">
            <h2 class="font-coeliac font-semibold text-2xl">Latest Coeliac Blogs</h2>
            <p>
                Our motto is that we're more than just a gluten free blog, but blogs are still the heart and soul of
                Coeliac Sanctuary, we'll write about a bit of everything, from coeliac news, new products, guides, and
                more, we're sure you'll find something you'll love here!
            </p>
            <div class="flex flex-col mt-2 sm:flex-row">
                @foreach($latestBlogs as $blog)
                    <div
                        class="w-full sm:w-1/2 rounded-lg overflow-hidden flex flex-col shadow-md mb-4 bg-blue-gradient {{ $loop->first ? 'sm:mr-3' : '' }}">
                        <div>
                            <a href="/blog/{{ $blog->slug }}">
                                <img loading="lazy" class="lazy" data-src="{{ $blog->main_image }}"
                                     src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"
                                     alt="{{ $blog->title }}"/>
                            </a>
                        </div>
                        <div class="p-2 flex flex-col h-full">
                            <a href="/blog/{{ $blog->slug }}">
                                <h3 class="font-bold hover:underline">{{ $blog->title }}</h3>
                            </a>
                            <p class="flex-1">{{ $blog->meta_description }}</p>
                            <div>
                                <link-button class="py-2 px-4 mt-2" rounded href="/blog/{{ $blog->slug }}">
                                    Read more...
                                </link-button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <google-ad code="9266309021"></google-ad>

        <!-- Latest Recipes -->
        <section class="page-box mt-4">
            <h2 class="font-coeliac font-semibold text-2xl">Latest Coeliac Recipes</h2>
            <p>
                Why not check out some of our fabulous, gluten free, coeliac recipes! All of our recipes are tried and
                tested by us, and as much as we can will always use simple, easy to get ingredients, readily available
                in most supermarkets!
            </p>
            <div class="flex flex-col mt-2 sm:flex-row">
                @foreach($latestRecipes as $recipe)
                    <div
                        class="w-full sm:w-1/3 rounded-lg overflow-hidden flex flex-col shadow-md mb-4 bg-blue-gradient {{ !$loop->last ? 'sm:mr-3' : '' }}">
                        <div>
                            <a href="/recipe/{{ $recipe->slug }}">
                                <img loading="lazy" class="lazy"
                                     src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"
                                     data-src="{{ $recipe->square_image }}" alt="{{ $recipe->title }}"/>
                            </a>
                        </div>
                        <div class="p-2 flex flex-col h-full">
                            <a href="/recipe/{{ $recipe->slug }}">
                                <h3 class="font-bold hover:underline">{{ $recipe->title }}</h3>
                            </a>
                            <p class="flex-1">{{ $recipe->meta_description }}</p>
                            <div>
                                <link-button class="py-2 px-4 mt-2" rounded href="/recipe/{{ $recipe->slug }}">
                                    Read more...
                                </link-button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Latest Reviews -->
        <section class="page-box mt-4">
            <h2 class="font-coeliac font-semibold text-2xl">Latest Coeliac Reviews</h2>
            <p>
                Being coeliac, eating out isn't always easy, if you're anything like us you'll research and plan way
                before you'll go anywhere, thats why we have our comprehensive
                <a href="/wheretoeat" class="font-semibold hover:underline">Where to Eat</a> guide, and we'll always try
                to produce a honest review detailing our experience, so you know its safe for you to eat there too!
            </p>
            <div class="flex flex-col mt-2 sm:flex-row">
                @foreach($latestReviews as $review)
                    <div
                        class="w-full sm:w-1/2 rounded-lg overflow-hidden flex flex-col shadow-md mb-4 bg-blue-gradient {{ $loop->first ? 'sm:mr-3' : '' }}">
                        <div>
                            <a href="/review/{{ $review->slug }}">
                                <img loading="lazy" class="lazy"
                                     src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"
                                     data-src="{{ $review->main_image }}" alt="{{ $review->title }}"/>
                            </a>
                        </div>
                        <div class="p-2 flex flex-col h-full">
                            <a href="/review/{{ $review->slug }}">
                                <h3 class="font-bold hover:underline">{{ $review->title }}</h3>
                            </a>
                            <p class="flex-1">{{ $review->meta_description }}</p>
                            <div>
                                <link-button class="py-2 px-4 mt-2" rounded href="/review/{{ $review->slug }}">
                                    Read more...
                                </link-button>
                            </div>
                        </div>
                    </div>
                @endforeach
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
                            <number-counter class="text-3xl sm:text-2xl" :to="{{ $stat['count'] }}"></number-counter>
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
