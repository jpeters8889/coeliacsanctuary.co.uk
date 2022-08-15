@extends('templates.shop')

@section('footerJavascript')
    <script type="text/javascript">
        gtag('event', 'view_item', {
            items: [
                {
                    id: {{ $product->id }},
                    name: "{{ $product->title }}",
                }
            ]
        });
    </script>

    <script type="application/ld+json">
        @json($product->richText)
    </script>
@endsection

@section('primary-column')
    <div class="space-y-3">
        <div class="page-box">
            <div class="mb-3">
                <h1 class="my-4 p-3 text-3xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
                    {{ $product->title }}
                </h1>

                <div
                    class="items-start flex space-x-3 -mt-4 pt-1 flex text-sm font-semibold font-sans @if($hasReviews) justify-between @else justify-center @endif"
                >
                    <a class="flex space-x-1 items-center flex-shrink-0" href="#reviews-wrapper">
                        <global-ui-stars
                            stars="{{ $reviews['average'] }}"
                            size="text-base md:text-lg"
                            half-star="star-half-alt"
                            show-all
                        ></global-ui-stars>
                        <span>{{ $reviews['count'] }} Ratings</span>
                    </a>

                    <a class="hover:text-blue-dark transition-all @if($hasReviews) text-right @endif"
                       href="{{ $category->link }}"
                    >
                        Back to {{ $category->title }}
                    </a>
                </div>
            </div>

            <div class="main-body flex flex-col md:flex-row">
                @if($product->images)
                    <div class="md:w-1/2 lg:w-1/3 lg:max-w-basket-sidebar flex-shrink-0 mr-2">
                        <img
                            src="{{ $product->first_image }}"
                            alt=""
                            class="mb-3 w-auto mx-auto"
                            style="max-height: 300px"
                        />
                    </div>
                @endif

                <div>
                    <p>{{ $product->description }}</p>

                    <div class="relative w-full border border-grey-off-light rounded shadow p-3 flex flex-col">
                        <shop-product-add-basket :product-id="{{ $product->id }}">
                            <div class="animate-pulse flex flex-col space-y-2">
                                <div class="w-1/3 h-5 bg-blue-dark bg-opacity-50"></div>
                                <div class="w-1/2 h-6 bg-grey bg-opacity-50"></div>
                                <div class="w-5/8 h-5 bg-blue-dark bg-opacity-50"></div>
                                <div
                                    class="w-full h-8 border-grey border bg-grey-off-light bg-opacity-50 rounded"
                                ></div>
                                <div class="w-1/2 h-6 bg-blue-dark bg-opacity-50"></div>
                                <div
                                    class="w-full h-8 border-grey border bg-grey-off-light bg-opacity-50 rounded"
                                ></div>
                                <div class="w-full h-10 bg-blue-light bg-opacity-50 rounded"></div>
                            </div>
                        </shop-product-add-basket>
                    </div>
                </div>
            </div>

        </div>

        <div class="page-box main-body">
            <p id="product-description">
                {!! $product->long_description !!}
            </p>
        </div>


        <div class="page-box" id="reviews-wrapper">
            <h1 class="text-2xl font-coeliac text-center font-semibold leading-tight md:text-left">
                Customer Feedback
            </h1>

            <div class="main-body">
                <p>
                    Thinking of purchasing some of our products, take a look at what some of our previous customers have
                    said about them!
                </p>

                <shop-product-reviews :id="{{ $product->id }} "/>
            </div>
        </div>
    </div>
@endsection
