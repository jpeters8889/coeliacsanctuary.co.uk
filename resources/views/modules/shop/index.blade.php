@extends('templates.shop')

@section('primary-column')
    <div class="flex flex-col">
        <div class="page-box">
            <h1 class="text-2xl font-coeliac text-center font-semibold leading-tight md:text-left">
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

                <div class="flex flex-col sm:flex-row sm:flex-wrap -mt-4">
                    @foreach($categories as $category)
                        <div
                            class="w-full border-b border-blue-light-50 py-4 flex flex-col text-center sm:w-1/2 sm:p-4 @if($loop->odd) sm:border-r @endif xl:w-1/3 @if($loop->iteration % 3 !== 0) xl:border-r @else xl:border-r-0 @endif">
                            <a href="{{ $category->link }}">
                                <img data-src="{{ $category->first_image }}" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E" loading="lazy" class="lazy" alt="{{ $category->title }}" />
                            </a>
                            <h2 class="text-xl mb-2">
                                <a href="{{ $category->link }}">
                                    {{ $category->title }}
                                </a>
                            </h2>
                            <p style="margin-bottom: 0">{{ $category->description }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
