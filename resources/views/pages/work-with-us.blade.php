@extends('templates.page-two-column')

@section('primary-column')
    <div class="flex flex-col"chunk>
        <div class="page-box">
            <h1 class="text-2xl font-coeliac text-center font-semibold leading-tight md:text-left">
                Work With Coeliac Sanctuary
            </h1>

            <div class="flex flex-col mt-4 main-body">
                <p>
                    Over the last 4 years I have had the pleasure of working with some fantastic companies. Please don't
                    hesitate to contact me if you want to work with me, whether you want me to help promote your brand,
                    create an exciting new recipe or something else, I love a challenge and will have a go at anything!
                    I am always looking for brands who would love to work with me, specifically in the area of Coeliac,
                    gluten free living and free from.
                </p>
                <p>
                    Coeliac Sanctuary is forever growing and currently averages over 30,000 visitors a month and has a
                    social media following of over 20,000 spread across Facebook, Instagram and Twitter.
                </p>
                <h3>Here is just a few companies I have had the pleasure of working with in the past!</h3>
                <div class="flex flex-col my-2 py-2 border-t border-b border-blue-light-50">
                    <h2 class="font-semibold font-coeliac text-3xl">Juvela</h2>
                    <p>
                        <img
                            src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"
                            data-src="{{ asset('assets/images/misc/work-with-us/juvela-logo.jpg') }}" alt="Juvela Logo"
                            loading="lazy" class="lazy w-full float-right ml-2 mb-2 xs:w:1/2 sm:w-1/4"/>
                        I teamed up with Juvela to help promote their bread being released into Tesco as well as
                        developing recipes and promoting their taster events amongst a selection of other projects.
                    </p>
                    <ul>
                        <li>
                            <a href="/recipe/chocolate-orange-bread-and-butter-pudding" target="_blank">
                                Bread and Butter Pudding Recipe
                            </a>
                        </li>
                        <li>
                            <a href="/blog/five-super-simple-sandwich-suggestions">
                                Five Simple Sandwich Suggestions
                            </a>
                        </li>
                        <li>
                            <a href="/blog/juvela-bread-in-selected-tesco-stores">
                                Juvela Bread in selected Tesco Stores
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="flex flex-col my-2 py-2 border-b border-blue-light-50">
                    <h2 class="font-semibold font-coeliac text-3xl">Hull Pie Company</h2>
                    <p>
                        <img data-src="{{ asset('assets/images/misc/work-with-us/pie-logo.png') }}"
                             src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"
                             alt="Hull Pie Company Logo" class="w-full float-right ml-2 mb-2 xs:w:1/2 sm:w-1/4 lazy"/>
                        When the Hull Pie Company started selling gluten free pies we happily worked with them to share
                        their new products and also ran a competition to win some of their pies.
                    </p>
                    <ul>
                        <li>
                            <a href="/blog/hull-pie-ltd-gluten-free-pies-and-competition" target="_blank">
                                Hull Pie Ltd Gluten Free Pies
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="flex flex-col my-2 py-2 border-b border-blue-light-50">
                    <h2 class="font-semibold font-coeliac text-3xl">Schwartz</h2>
                    <p>
                        <img data-src="{{ asset('assets/images/misc/work-with-us/schwartz-logo.png') }}"
                             src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"
                             alt="Schwartz Logo" class="w-full float-right ml-2 mb-2 xs:w:1/2 sm:w-1/4 lazy"/>
                        I joined up with Schwartz to taste test their gluten free flavour packets and promote them via a
                        blog and sharing their recipes.
                    </p>
                    <ul>
                        <li>
                            <a href="/blog/official-launch-of-schwartz-gluten-free-flavour-sachets" target="_blank">
                                Official Launch of Schwartz Gluten Free Flavour Sachets
                            </a>
                        </li>
                        <li>
                            <a href="/recipe/schwartz-stuffed-peppers" target="_blank">
                                Schwartz Stuffed Peppers
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="flex flex-col my-2 py-2 border-b border-blue-light-50">
                    <h2 class="font-semibold font-coeliac text-3xl">Morrisons</h2>
                    <p>
                        <img data-src="{{ asset('assets/images/misc/work-with-us/morrisons-logo.png') }}"
                             src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"
                             alt="Morrisons Logo" class="w-full float-right ml-2 mb-2 xs:w:1/2 sm:w-1/4 lazy"/>
                        When Morrisons wanted bloggers to taste test their Christmas range in August and promote their
                        new products I was happy to help them out.
                    </p>
                    <ul>
                        <li>
                            <a href="/blog/morrisons-behind-the-shelves" target="_blank">
                                Morrisons - Behind the Shelves
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('secondary-column')
    <div class="flex flex-col">
        <widget-newsletter-signup class="mb-3"></widget-newsletter-signup>

        @include('components.related-item', [$related, $title = 'Recent Blogs'])
    </div>
@endsection
