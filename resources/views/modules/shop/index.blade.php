@extends('templates.shop')

@section('primary-column')
    <div class="flex flex-col space-y-3">
        <div class="page-box">
            <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
                Coeliac Sanctuary Shop
            </h1>

            <div class="flex flex-col mt-4 main-body">
                <p>
                    Welcome to the Coeliac Sanctuary Shop, here you can find a range of helpful items including Coeliac
                    travel cards to help you explain Coeliac and the need for gluten free, available in 50 languages, we
                    cover most of the world, so wherever you are visiting you can eat safely. We also do wristbands in
                    various sizes, lanyards which are perfect for parties, water and freezer proof gluten free stickers
                    and a few other bits and bobs!
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-y-3 sm:grid-cols-3 sm:gap-x-3">
            @foreach($categories as $category)
                <div class="bg-white shadow w-full p-4 flex flex-col text-center rounded-lg space-y-2 group">
                    <a href="{{ $category->link }}">
                        <img data-src="{{ $category->first_image }}"
                             src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"
                             loading="lazy" class="lazy" alt="{{ $category->title }}"/>
                    </a>

                    <h2 class="text-lg font-semibold text-blue-dark group-hover:text-grey transition-all">
                        <a href="{{ $category->link }}">
                            {{ $category->title }}
                        </a>
                    </h2>

                    <p style="margin-bottom: 0">{{ $category->description }}</p>
                </div>
            @endforeach
        </div>
    </div>
@endsection
