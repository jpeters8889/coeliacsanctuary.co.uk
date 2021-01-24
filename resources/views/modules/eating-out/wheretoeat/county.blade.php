@extends('templates.page-two-column')

@section('primary-column')
    <div class="flex flex-col" chunk>
        <div class="page-box">
            <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
                Gluten Free Places to eat in {{ $county }}<br/>
            </h1>

            <h6 class="text-center -mt-4 pt-1">
                <a class="text-sm font-semibold font-sans hover:text-blue-dark transition-color" href="/wheretoeat">Back to Map/List</a>
            </h6>

            <div class="flex flex-col mt-2">
                <p>
                    In the list below you can see cities, towns and villages in {{ $county }} that we know offer gluten
                    free options, whether these are places to eat, attractions or hotels / B&Bs.
                </p>

                <p class="mt-2">
                    Most of the places to eat listed in our guide are contributed by people like you, other Coeliac's or
                    people with a gluten intolerance who know of local places in their local area and are kind enough to let
                    us know.
                </p>

                <p class="mt-2">
                    You won't find any nationwide chains in our normal eating out guide simply due to how many places these
                    chains have, the other independent eateries will get lost! Instead, we list
                    <a class="font-semibold hover:text-blue-dark transition-colour" href="/wheretoeat/nationwide">nationwide
                        chains</a> on a separate page.
                </p>

                <div class="mt-2 flex flex-col bg-blue-light-50 border text-sm border-blue p-2">
                    <p>
                        Know somewhere that offers gluten free for us to add or does somewhere need removing off our
                        list? <a class="font-semibold hover:text-grey transition-color"
                                 href="/wheretoeat/place-request">Let us know!</a>
                    </p>
                </div>

                <table class="mt-4 w-full leading-none">
                    <tr class="text-left border-b-2 border-blue">
                        <th class="border-r-2 border-blue p-1 pl-0">Town</th>
                        <th class="p-1 pr-0">Eateries</th>
                    </tr>
                    @foreach($towns as $town)
                        <tr class="town border-b-2 border-blue">
                            <td class="border-r-2 border-blue p-1 pl-0">
                                <a href="/wheretoeat/{{ $slug }}/{{ $town->slug }}"
                                   class="font-semibold text-blue transition-color hover:text-grey">
                                    {{ $town->town }}
                                </a>
                            </td>
                            <td class="p-1 pr-0">
                                {{ $town->snippet }}
                            </td>
                        </tr>
                    @endforeach
                </table>

                <google-ad code="5284484376"></google-ad>
            </div>
        </div>

        <div class="page-box mt-2">
            <h2 class="text-2xl font-coeliac text-center font-semibold leading-tight md:text-left">
                Coeliac Sanctuary - On the Go App
            </h2>

            <p class="mt-2">
                Do you use our Eating Out guide often? Why not check out our <strong>Coeliac Sanctuary - On the
                    Go</strong> App to help you easily find places near you to eat Gluten Free!
            </p>

            <link-button title="Coeliac Sanctuary - On the Go App"
                         class="px-4 py-2 rounded-lg font-semibold my-2"
                         href="/wheretoeat/coeliac-sanctuary-on-the-go"
            >
                Find out more...
            </link-button>
        </div>
    </div>

    <div class="page-box mt-2">
        <h2 class="text-2xl font-coeliac text-center font-semibold leading-tight mb-2 md:text-left">
            Gluten Free Reviews in {{ $county }}
        </h2>

        @if($reviews->count() > 0)
            <div class="w-full flex flex-col -mb-4 sm:flex-row">
                @foreach($reviews as $review)
                    <div
                        class="w-full sm:w-1/2 rounded-lg overflow-hidden flex flex-col shadow-md mb-4 bg-blue-gradient {{ $loop->first ? 'sm:mr-3' : '' }}">
                        <div>
                            <img src="{{ $review->main_image }}" alt="{{ $review->title }}"/>
                        </div>
                        <div class="p-2 flex flex-col h-full">
                            <a href="/review/{{ $review->slug }}">
                                <h3 class="font-bold hover:underline">
                                    {{ $review->title }}, {{ $review->eatery->town->town }}
                                </h3>
                            </a>
                            <p class="flex-1">{{ $review->meta_description }}</p>
                            <div>
                                <link-button class="py-2 px-4 mt-2" rounded href="/review/{{ $review->slug }}">
                                    Read more...
                                </link-button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="page-box mt-2">
        <div class="flex flex-col bg-blue-light-50 border text-sm border-blue p-2">
            <p>
                Know somewhere that offers gluten free for us to add or does somewhere need removing off our
                list? <a class="font-semibold hover:text-grey transition-color"
                         href="/wheretoeat/place-request">Let us know!</a>
            </p>
        </div>
    </div>
@endsection

@section('secondary-column')
    <div class="flex flex-col">
        <widget-wheretoeat-search class="mb-3"></widget-wheretoeat-search>

        <widget-newsletter-signup class="mb-3"></widget-newsletter-signup>

        @include('components.related-item', [$title = 'Recent Reviews', $related])
    </div>
@endsection
