@extends('templates.shop')

@section('primary-column')
    <div class="flex flex-col">
        <div class="page-box">
            <h1 class="my-4 p-3 text-3xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
                {{ $product->title }}
            </h1>

            <h6 class="text-center -mt-4 pt-1">
                <a class="text-sm font-semibold font-sans hover:text-blue-dark transition-color" href="{{ $category->link }}">
                    Back to {{ $category->title }}
                </a>
            </h6>

            <div class="flex flex-col my-4 sm:flex-row">
                <product-images :product-id="{{ $product->id }}"
                                class="hidden sm:block sm:w-1/2 md:w-1/3 lg:w-1/4"></product-images>

                <div class="main-body w-full mt-4 sm:w-1/2 sm:mt-0 sm:ml-4 md:w-2/3 lg:w-3/4 xl:w-4/5">
                    <p>{{ $product->description }}</p>
                    <p><a href="#product-description">Read more...</a></p>
                    <product-images :product-id="{{ $product->id }}"
                                    class="sm:hidden my-4"></product-images>
                    <product-add-basket :product-id="{{ $product->id }}" class="mb-4"></product-add-basket>
                </div>
            </div>


            <div class="main-body">
                <p id="product-description">
                    {!! $product->long_description !!}
                </p>
            </div>
        </div>

        <div class="page-box">
            <h1 class="text-2xl font-coeliac text-center font-semibold leading-tight md:text-left">
                Customer Feedback
            </h1>

            <div class="main-body">
                <p>
                    Thinking of purchasing some of our products, take a look at what some of our previous customers have
                    said about them!
                </p>

                @foreach($feedback as $item)
                    <div class="bg-blue-light-20 border-l-8 border-yellow p-2 mb-4">
                        <em>{{ $item->feedback }}</em><br/>
                        <span class="text-blue">{{ $item->name }} - <a href="{{ $item->product->link }}">{{ $item->product->title }}</a></span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
