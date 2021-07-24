@extends('templates.shop')

@section('primary-column')
    <div class="flex flex-col p-2">
        <div class="bg-blue-gradient w-full rounded-lg p-2 shadow">
            <div class="flex flex-col xs:flex-row xs:justify-between xs:pt-4 mb-4">
                @guest
                    <div class="flex xs:flex-col xs:flex-1">
                        <div class="px-4 relative xs:px-0">
                            <div class="w-5 h-5 rounded-full absolute text-white bg-yellow"
                                 style="left: 50%; top: 50%; transform: translate(-50%, -50%)">
                            </div>
                            <div class="border-4 border-yellow h-full"></div>
                        </div>
                        <div class="flex-1 py-3 xs:text-center font-semibold text-black">
                            Your Details
                        </div>
                    </div>
                @endguest

                <div class="flex xs:flex-col xs:flex-1">
                    <div class="px-4 relative xs:px-0">
                        <div class="w-5 h-5 rounded-full absolute text-white bg-yellow"
                             style="left: 50%; top: 50%; transform: translate(-50%, -50%)">
                        </div>
                        <div class="border-4 border-yellow h-full"></div>
                    </div>
                    <div class="flex-1 py-3 xs:text-center font-semibold text-black">
                        Shipping Address
                    </div>
                </div>

                <div class="flex xs:flex-col xs:flex-1">
                    <div class="px-4 relative xs:px-0">
                        <div class="w-5 h-5 rounded-full absolute text-white bg-yellow"
                             style="left: 50%; top: 50%; transform: translate(-50%, -50%)">
                        </div>
                        <div class="border-4 border-yellow h-full"></div>
                    </div>
                    <div class="flex-1 py-3 xs:text-center font-semibold text-black">
                        Payment
                    </div>
                </div>

                <div class="flex xs:flex-col xs:flex-1">
                    <div class="px-4 relative xs:px-0">
                        <div class="w-5 h-5 rounded-full absolute text-white bg-yellow"
                             style="left: 50%; top: 50%; transform: translate(-50%, -50%)">
                        </div>
                        <div class="border-4 border-yellow h-full"></div>
                    </div>
                    <div class="flex-1 py-3 xs:text-center font-semibold text-black">
                        Confirmation
                    </div>
                </div>
            </div>

            <h2 class="text-2xl text-center font-semibold mb-2 py-2 border-t border-b border-white-50">Order Complete!</h2>

            <div class="flex flex-col lg:flex-row">

                @if(\Illuminate\Support\Facades\Auth::guest() && $order->user->user_level_id === \Coeliac\Modules\Member\Models\UserLevel::SHOP)
                <member-register-order-complete-cta name="{{ $order->user->name }}" email="{{ $order->user->email }}"></member-register-order-complete-cta>
                @endif

                <div class="text-center lg:flex-1 lg:text-left">
                    <p>
                        Your Order has been completed, you will receive an email confirmation shortly. If you don't
                        receive a confirmation email please check your Spam or Junk folders. If you still haven't
                        received it please get in touch.
                    </p>

                    <p class="mt-4">
                        <a title="Return to Shop" href="/shop" class="font-semibold hover:underline">Return to Shop</a>
                        or go back to the
                        <a title="Main Website" href="/" class="font-semibold hover:underline">main website</a>.
                    </p>
                </div>
            </div>
        </div>

        <section class="page-box mt-4">
            <h2 class="font-coeliac font-semibold text-2xl">Latest Blogs</h2>
            <div class="flex flex-col mt-2 sm:flex-row">
                @foreach($latestBlogs as $blog)
                    <div
                        class="w-full sm:w-1/2 rounded-lg overflow-hidden flex flex-col shadow-md mb-4 bg-blue-gradient {{ $loop->first ? 'sm:mr-3' : '' }}">
                        <div>
                            <img loading="lazy" class="lazy" data-src="{{ $blog->main_image }}"
                                 src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"
                                 alt="{{ $blog->title }}"/>
                        </div>
                        <div class="p-2 flex flex-col h-full">
                            <a href="/blog/{{ $blog->slug }}">
                                <h3 class="font-bold hover:underline">{{ $blog->title }}</h3>
                            </a>
                            <p class="flex-1">{{ $blog->meta_description }}</p>
                            <div>
                                <global-ui-link-button class="py-2 px-4 mt-2" rounded href="/blog/{{ $blog->slug }}">
                                    Read more...
                                </global-ui-link-button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Latest Recipes -->
        <section class="page-box mt-4">
            <h2 class="font-coeliac font-semibold text-2xl">Latest Recipes</h2>
            <div class="flex flex-col mt-2 sm:flex-row">
                @foreach($latestRecipes as $recipe)
                    <div
                        class="w-full sm:w-1/3 rounded-lg overflow-hidden flex flex-col shadow-md mb-4 bg-blue-gradient {{ !$loop->last ? 'sm:mr-3' : '' }}">
                        <div>
                            <img loading="lazy" class="lazy" data-src="{{ $recipe->square_image }}"
                                 src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"
                                 alt="{{ $recipe->title }}"/>
                        </div>
                        <div class="p-2 flex flex-col h-full">
                            <a href="/recipe/{{ $recipe->slug }}">
                                <h3 class="font-bold hover:underline">{{ $recipe->title }}</h3>
                            </a>
                            <p class="flex-1">{{ $recipe->meta_description }}</p>
                            <div>
                                <global-ui-link-button class="py-2 px-4 mt-2" rounded href="/recipe/{{ $recipe->slug }}">
                                    Read more...
                                </global-ui-link-button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Latest Reviews -->
        <section class="page-box mt-4">
            <h2 class="font-coeliac font-semibold text-2xl">Latest Reviews</h2>
            <div class="flex flex-col mt-2 sm:flex-row">
                @foreach($latestReviews as $review)
                    <div
                        class="w-full sm:w-1/2 rounded-lg overflow-hidden flex flex-col shadow-md mb-4 bg-blue-gradient {{ $loop->first ? 'sm:mr-3' : '' }}">
                        <div>
                            <img loading="lazy" class="lazy" data-src="{{ $review->main_image }}"
                                 src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"
                                 alt="{{ $review->title }}"/>
                        </div>
                        <div class="p-2 flex flex-col h-full">
                            <a href="/review/{{ $review->slug }}">
                                <h3 class="font-bold hover:underline">{{ $review->title }}</h3>
                            </a>
                            <p class="flex-1">{{ $review->meta_description }}</p>
                            <div>
                                <global-ui-link-button class="py-2 px-4 mt-2" rounded href="/review/{{ $review->slug }}">
                                    Read more...
                                </global-ui-link-button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection

@section('footerJavascript')
    <script type="text/javascript">
        import OrderCompleteCreateAccount from "~/Members/Register/OrderCompleteCta";
        window.gtag('event', 'purchase', @json($gtagData));
        export default {
            components: {OrderCompleteCreateAccount}
        }
    </script>
@endsection
