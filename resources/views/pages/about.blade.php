@extends('templates.page-two-column')

@section('primary-column')
    <div class="flex flex-col"chunk>
        <div class="page-box">
            <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
                About Coeliac Sanctuary
            </h1>

            <div class="flex flex-col mt-4 main-body">
                <p>
                    Coeliac Sanctuary started life in June 2014, initially it was going to be just a kind of document
                    for Alison, Coeliac Sanctuary's founder, to add places to eat and keep note of places eaten at as a
                    kind of diary to remember what restaurants had been like, but being a web designer and struggling
                    with the job she was in at the time she decided to make a website to both increase her knowledge and
                    make a resource to refer to when eating out.
                </p>
                <p>
                    At the time she came up with the idea for the site, she didn't know what it was going to be called,
                    playing around with Coeliac Asylum to start with. The idea revolved around the fact she thought she
                    was going crazy when doctors couldn't find any cause for abdominal pains and anxiety, she thought
                    the website would take a black, grey and orange colour scheme to play on the dark side of being
                    undiagnosed.
                </p>
                <p>
                    It was only when toying with other ideas for names Coeliac Sanctuary was suggested. With that it
                    made Alison think of a Seal Sanctuary, hence why the logo and mascot of Coeliac Sanctuary is Sealiac
                    the Seal, it took a few days but having some training in graphic design Alison drew up the logo and
                    decided to scheme the website around a Seal Sanctuary; blue for pools, grey for the seal and, to tie
                    in with Coeliac, yellow for wheat. The original website used a solid blue background with wheat
                    styled headers and footers and a curved block design, this original version was released in August
                    2014.
                </p>
                <p>
                    Even though it wasn't built to be anything more than a hobby and personal resource the site took off
                    and over a year it grew massively in popularity, often getting 100s of visits a day on the site and
                    thousands of facebook followers and a fair few hundred followers spread over other social media such
                    as Twitter and Pinterest. It's popularity also lead to a newsletter being developed in February 2015
                </p>
                <p>
                    As the website continued to grow it reached a point where it needed to be redesigned to fit in with
                    current web trends, and it need to be mobile friendly, keeping the same colours and logo but a whole
                    new look, Coeliac Sanctuary 2.0 began development in April 2015, finally being released in September
                    2015 to coincide with the 1 year anniversary of the site.
                </p>
                <p>
                    Coeliac Sanctuary's journey so far has been incredible and continues to grow, for something that was
                    built just as a personal reference it bloomed into something beyond anyones expectations. Who knows
                    where it will go next.
                </p>
                <div>
                    <article-image title="Alison - Coeliac Sanctuary founder"
                                   src="{{ asset('assets/images/misc/alison.jpg') }}"></article-image>
                    <strong>Alison - Founder/Owner</strong>
                    <p>
                        In June 2014 Alison developed anxiety about her job and had been diagnosed as intolerant to
                        gluten and some dairy products, the intolerances were only discovered by a consultant after 5
                        months off work with agonising stomach pains and 100s of tests all revealing nothing. Coeliac
                        tests also came back clear but removing gluten from her diet resolved the pains causing GPs and
                        consultants to deem her intolerant. However she considers herself Coeliac and sticks to a strict
                        gluten free diet as the smallest crumb can leave her in agonising pain for days. It was because
                        of this intolerance Coeliac Sanctuary came to life.
                    </p>
                    <p>
                        In January 2015 Alison was also diagnosed with Fibromyalgia, she now finds it difficult to
                        concentrate, and simple tasks take her 10x the amount of time they used to (that's when she can
                        actually remember what she is doing!). Everything on Coeliac Sanctuary, from the building and
                        design to the maintenance and updating was done by Alison, however these days she has to have
                        help with a lot of it, but still controls everything which goes on.
                    </p>
                </div>


                <div>
                    <strong>Jamie - The sidekick, the brains, developer and tech guru</strong>
                    <article-image title="Jamie - Coeliac Sanctuary developer and tech guru"
                                   src="{{ asset('assets/images/misc/jamie.jpg') }}"
                                   position="right"></article-image>
                    <p>
                        The sidekick has always been part of the site helping out when he can, but because of Alison's
                        Fibromyalgia he has found himself having to help out more especially when it comes to the
                        building side, he is basically the extra brains of the party. Jamie works more of the back end
                        development of the site (and part time proof reader, if you left it all up to Alison everything
                        would be illegible she gets her words muddled so often) but will pop up now and then doing other
                        things, usually recipes. He helps keep the website tick, without him the website would probably
                        have been in deep doo-doo ages ago, with his know how he keeps all the pesky gremlins at bay so
                        the website can keep on rolling and handle whatever is thrown at it.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('secondary-column')
    <div class="flex flex-col">
        <x-widget class="mb-3" title="Sign up to our newsletter">
            <widget-newsletter-signup />
        </x-widget>

        <google-ad code="7266831645"></google-ad>

        @include('components.related-item', [$related, $title = 'Recent Blogs'])
    </div>
@endsection
