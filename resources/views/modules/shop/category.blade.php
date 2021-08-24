@extends('templates.shop')

@section('primary-column')
    <div class="flex flex-col space-y-3">
        <div class="page-box">
            <h1 class="my-4 p-3 text-3xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
                {{ $category->title }}
            </h1>

            <h6 class="text-center -mt-4 pt-1">
                <a class="text-sm font-semibold font-sans hover:text-blue-dark transition-all" href="/shop">
                    Back to Shop Home
                </a>
            </h6>

            <div class="flex flex-col mt-4">
                <p>{{ $category->description }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-y-3 sm:grid-cols-3 sm:gap-x-3">
            @foreach($products as $product)
                <div class="w-full shadow bg-white p-4 flex flex-col text-center rounded space-y-2 group">
                    <a href="{{ $product->link }}">
                        <img data-src="{{ $product->first_image }}"
                             src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"
                             loading="lazy" class="lazy" alt="{{ $product->title }}"/>
                    </a>

                    <h2 class="text-lg text-blue-dark font-semibold group-hover:text-grey transition-all">
                        <a href="{{ $product->link }}">
                            {{ $product->title }}
                        </a>
                    </h2>

                    <p class="text-2xl font-semibold leading-none mb-2">
                        {{ formatPrice($product->currentPrice) }}
                    </p>

                    <p class="mb-2">{!! $product->description !!}</p>

                    <div class="flex flex-col leading-none xs:flex-row xs:justify-around">
                        <a href="{{ $product->link }}"
                           class="font-semibold border border-blue rounded p-2 bg-blue-light bg-opacity-50 text-black hover:bg-opacity-20 transition-all mb-2">
                            Find out more
                        </a>

                        @if($product->variants->count()===1)
                            @if($product->variants[0]->quantity>0)
                                <shop-basket-ui-add-product :product-id="{{ $product->id }}"
                                                            :variant-id="{{ $product->variants[0]->id }}">
                                    <button
                                        class="xs:ml-1 w-full font-semibold border border-blue rounded p-2 bg-blue-light bg-opacity50 text-black hover:bg-opacity-20 transition-all mb-2">
                                        Add to Basket
                                    </button>
                                </shop-basket-ui-add-product>
                            @else
                                <button disabled
                                        class="xs:ml-1 font-semibold border border-blue-light rounded p-2 bg-opacity-20 text-grey cursor-not-allowed mb-2">
                                    Out of stock
                                </button>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
