@extends('templates.page-two-column')

@section('primary-column')
    <div class="flex flex-col"chunk>
        <div class="page-box">
            <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
                Gluten Free Shopping List
            </h1>

            <h6 class="text-center -mt-4 pt-1">
                <a class="text-sm font-semibold font-sans hover:text-blue-dark transition-color" href="/info">
                    More Coeliac Information
                </a>
            </h6>

            <div class="flex flex-col mt-4">
                <p>
                    We know how hard it is to figure out what to buy when you are first diagnosed, so we have compiled a
                    beginners shopping list to help new coeliac sufferers figure out what to buy, although you could
                    still use it as a reference even if you were diagnosed years ago! We have included a mix of all
                    sorts including some sweet treats, as we all know in the beginning it's that that keeps us going!
                </p>

                <div class="bg-blue-shopping shadow-xl w-98 my-4">
                    <h2 class="p-4 pb-2 border-b border-red font-coeliac font-semibold text-2xl">
                        Shopping List
                    </h2>
                    <ul>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest  ">
                            <h3 class="text-lg font-coeliac text-blue-other font-semibold">
                                Fresh fruit and veg
                            </h3>
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            All naturally gluten free
                        </li>

                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest  ">
                            <h3 class="text-lg font-coeliac text-blue-other font-semibold">
                                Cereal
                            </h3>
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Some home brands are gluten free
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Gluten free versions in free from sections
                        </li>

                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest  ">
                            <h3 class="text-lg font-coeliac text-blue-other font-semibold">
                                Pure Oats
                            </h3>
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Coeliacs can only have "pure oats"
                        </li>

                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest  ">
                            <h3 class="text-lg font-coeliac text-blue-other font-semibold">
                                Millet Flakes
                            </h3>
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Alternative to oats found in health shops
                        </li>

                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest  ">
                            <h3 class="text-lg font-coeliac text-blue-other font-semibold">
                                Bread
                            </h3>
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Many varieties in free from sections.
                        </li>

                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest  ">
                            <h3 class="text-lg font-coeliac text-blue-other font-semibold">
                                Quinoa
                            </h3>
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Excellent cous cous replacement
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Or rice alternative
                        </li>

                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest  ">
                            <h3 class="text-lg font-coeliac text-blue-other font-semibold">
                                Pasta
                            </h3>
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Many GF options in free from sections
                        </li>

                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest  ">
                            <h3 class="text-lg font-coeliac text-blue-other font-semibold">
                                Pudding Rice
                            </h3>
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Naturally gluten free sweet treat
                        </li>

                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest  ">
                            <h3 class="text-lg font-coeliac text-blue-other font-semibold">
                                Biscuits
                            </h3>
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Lots of GF options in free from
                        </li>

                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest  ">
                            <h3 class="text-lg font-coeliac text-blue-other font-semibold">
                                Chocolate
                            </h3>
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Some Cadbury's is fine
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Always check the wrappers!
                        </li>

                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest  ">
                            <h3 class="text-lg font-coeliac text-blue-other font-semibold">
                                Coconut Macaroons
                            </h3>
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Lovely sweet treat
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Mrs Crimbles are available most places
                        </li>

                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest  ">
                            <h3 class="text-lg font-coeliac text-blue-other font-semibold">
                                Heinz Baked Beans
                            </h3>
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            These are GF unlike some other brands
                        </li>

                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest  ">
                            <h3 class="text-lg font-coeliac text-blue-other font-semibold">
                                Heinz Ketchup
                            </h3>
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Same as the beans!
                        </li>

                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest  ">
                            <h3 class="text-lg font-coeliac text-blue-other font-semibold">
                                Hellmans Mayonnaise
                            </h3>
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Same as beans and ketchup!
                        </li>

                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest  ">
                            <h3 class="text-lg font-coeliac text-blue-other font-semibold">
                                Kallo Organic Stock Cubes
                            </h3>
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Some stocks contain wheat so watch out
                        </li>

                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest  ">
                            <h3 class="text-lg font-coeliac text-blue-other font-semibold">
                                Gravy Granules
                            </h3>
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Same as with stock, we suggest kallo
                        </li>

                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest  ">
                            <h3 class="text-lg font-coeliac text-blue-other font-semibold">
                                Sausages
                            </h3>
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Check for wheat
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Black farmer, Heck are fine
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Some supermarkets also have options
                        </li>

                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest  ">
                            <h3 class="text-lg font-coeliac text-blue-other font-semibold">
                                Burgers
                            </h3>
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Same as with sausages
                        </li>

                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest  ">
                            <h3 class="text-lg font-coeliac text-blue-other font-semibold">
                                Flour
                            </h3>
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Doves is widely available in free from
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Can also get M&S multipurpose GF flours
                        </li>

                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest  ">
                            <h3 class="text-lg font-coeliac text-blue-other font-semibold">
                                Xanthan Gum
                            </h3>
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            If you can tolerate...
                        </li>
                        <li class="pl-4 p-2 pb-1 border-b border-dotted border-grey-darkest">
                            Acts as a binding agent in baking
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('secondary-column')
    <div class="flex flex-col">
        <x-widget class="mb-3" title="Sign up to our newsletter">
            <global-ui-newsletter-signup />
        </x-widget>

        <global-ui-google-ad code="7266831645"></global-ui-google-ad>

        @include('components.related-item', [$related, $title = 'Recent Blogs'])
    </div>
@endsection
