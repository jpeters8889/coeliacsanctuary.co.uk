@extends('templates.shop')

@section('primary-column')
    <div class="flex flex-col">
        <div class="page-box">
            <h1 class="my-4 p-3 text-3xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
                {{ $category->title }}
            </h1>

            <h6 class="text-center -mt-4 pt-1">
                <a class="text-sm font-semibold font-sans hover:text-blue-dark transition-color" href="/shop">
                    Back to Shop Home
                </a>
            </h6>

            <div class="flex flex-col mt-4">
                <p class="mb-4">{{ $category->description }}</p>

                <div class="flex flex-col sm:flex-row sm:flex-wrap -mt-4">
                    @foreach($products as $product)
                        <div
                            class="w-full border-b border-blue-light-50 py-4 flex flex-col text-center sm:w-1/2 sm:p-4 @if($loop->odd) sm:border-r @endif lg:w-1/3 @if($loop->iteration % 3 !== 0) lg:border-r @else lg:border-r-0 @endif">
                            <a href="{{ $product->link }}">
                                <img data-src="{{ $product->first_image }}" src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E" loading="lazy" class="lazy" alt="{{ $product->title }}" />
                            </a>
                            <h2 class="text-xl mb-2 font-semibold text-blue hover:text-grey transition-color">
                                <a href="{{ $product->link }}">
                                    {{ $product->title }}
                                </a>
                            </h2>
                            <p class="text-2xl font-semibold leading-none mb-2">
                                {{ formatPrice($product->currentPrice) }}
                            </p>
                            <p class="mb-2">{{ $product->description }}</p>
                            <div class="flex flex-col leading-none xs:flex-row xs:justify-around">
                                <a href="{{ $product->link }}"
                                   class="font-semibold border border-blue rounded p-2 bg-blue-light-50 text-black hover:bg-blue-light-20 transition-bg mb-2">
                                    Find out more
                                </a>

                                @if($product->variants->count()===1)
                                    @if($product->variants[0]->quantity>0)
                                        <add-basket-trigger :product-id="{{ $product->id }}"
                                                            :variant-id="{{ $product->variants[0]->id }}">
                                            <button
                                                class="xs:ml-1 w-full font-semibold border border-blue rounded p-2 bg-blue-light-50 text-black hover:bg-blue-light-20 transition-bg mb-2">
                                                Add to Basket
                                            </button>
                                        </add-basket-trigger>
                                        @else
                                        <button disabled
                                            class="xs:ml-1 font-semibold border border-blue-light rounded p-2 bg-blue-light-20 text-grey cursor-not-allowed mb-2">
                                            Out of stock
                                        </button>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
