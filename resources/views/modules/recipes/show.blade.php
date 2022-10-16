@extends('templates.page-single-column')

@section('primary-column')
    <div class="flex flex-col space-y-3 max-w-images mx-auto">
        <div class="page-box shadow">
            <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">{{ $recipe->title }}</h1>

            <p class="text-lg my-2 font-medium leading-relaxed">{!! $recipe->description !!}</p>

            <div class="flex flex-col lg:flex-row lg:space-x-2">
                <div class="w-full lg:w-1/2">
                    @if(count($recipe->features) > 0)
                        <h3 class="font-semibold text-base text-grey-darkest">This recipe is...</h3>
                        <ul class="flex flex-row flex-wrap text-sm leading-tight">
                            @foreach($recipe->features as $feature)
                                <li>
                                    <a class="font-semibold text-blue-dark hover:text-grey-darker"
                                       href="{{ '/recipe?o='.base64_encode('filter[feature]='.$feature->feature) }}"
                                    >
                                        {{ $feature->feature  }}</a>@if(!$loop->last),&nbsp;@endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="w-full lg:w-1/2 bg-red-light bg-opacity-15 rounded p-3">
                    <h3 class="font-semibold text-base text-grey-darkest">This recipe contains:</h3>
                    <ul class="flex flex-row flex-wrap text-sm leading-tight">
                        @foreach($recipe->containsAllergens() as $allergen)
                            <li class="font-semibold text-blue-dark">
                                {{ $allergen->allergen  }}@if(!$loop->last),&nbsp;@endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="bg-grey-light border-t border-grey-off-light -m-3 mt-3 p-3 flex justify-between">
                <div class="flex-1">
                    Added
                    <time datetime="{{ $recipe->created_at }}">{{ formatDate($recipe->created_at) }}</time>
                    @if($recipe->updated_at && !$recipe->updated_at->isSameDay($recipe->created_at))
                        <br/>Updated
                        <time datetime="{{ $recipe->updated_at }}">{{ formatDate($recipe->updated_at) }}</time>
                    @endif
                    <br/>Recipe by {{ $recipe->author }}
                </div>
                <a class="text-3xl text-black" href="/recipe/{{ $recipe->slug }}/print" target="_blank">
                    <font-awesome-icon :icon="['fas', 'print']"></font-awesome-icon>
                </a>
            </div>
        </div>

        <div class="shadow">
            <global-ui-recipe-image src="{{ $recipe->main_image }}" alt="{{ $recipe->title }}"></global-ui-recipe-image>
        </div>



        @if($featured)
            <div class="page-box p-3 shadow">
                <h3 class="font-semibold text-base text-grey-darkest">This recipe was featured in:</h3>
                <ul class="flex flex-row flex-wrap text-sm leading-tight">
                    @foreach($featured as $feature)
                        <li>
                            <a class="font-semibold text-blue-dark hover:text-grey-darker" href="{{ $feature->link }}">
                                {{ $feature->title  }}</a>@if(!$loop->last),&nbsp;
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

{{--        <global-ui-google-ad code="2137793897"></global-ui-google-ad>--}}

        <div class="page-box p-3 shadow flex flex-col space-y-3 pb-0">
            <h2 class="font-semibold text-lg text-blue-dark">Ingredients</h2>

            <div>{!! $recipe->ingredients !!}</div>

            <ul class="bg-grey-light border-t border-grey-off-light -m-3 mt-3 p-3">
                <li><strong class="font-semibold">Preparation Time:</strong> {{ $recipe->prep_time }}</li>
                <li><strong class="font-semibold">Cooking Time:</strong> {{ $recipe->cook_time }}</li>
                <li><strong class="font-semibold">This recipe makes {{ $recipe->serving_size }}</strong></li>
            </ul>
        </div>

        <global-ui-google-ad code="2137793897"></global-ui-google-ad>

        <div class="page-box p-3 shadow main-body flex flex-col space-y-3">
            <h3 class="font-semibold text-lg text-blue-dark">Method</h3>

            <article>
                {!! $recipe->method !!}
            </article>

            <h3 class="text-base font-semibold mt-4 mb-2">
                Nutritional Information (Per {{ $recipe->per }})
            </h3>

            <table class="recipe-table">
                <tr>
                    <th>Calories</th>
                    <th>Carbs</th>
                    <th>Fibre</th>
                    <th>Fat</th>
                    <th>Sugar</th>
                    <th>Protein</th>
                </tr>
                <tr>
                    <td>{{ $recipe->nutrition->calories }}</td>
                    <td>{{ $recipe->nutrition->carbs }}<sub>g</sub></td>
                    <td>{{ $recipe->nutrition->fibre }}<sub>g</sub></td>
                    <td>{{ $recipe->nutrition->fat }}<sub>g</sub></td>
                    <td>{{ $recipe->nutrition->sugar }}<sub>g</sub></td>
                    <td>{{ $recipe->nutrition->protein }}<sub>g</sub></td>
                </tr>
            </table>
        </div>

        <div class="page-box p-3 mt-3">
            <h2 class="text-2xl my-2 font-semibold font-coeliac">Your Comments</h2>

            <div class="flex flex-col -mb-3">
                <module-comments area="recipe" :id="{{ $recipe->id }}"></module-comments>
            </div>
        </div>

        <modules-comment-form area="recipe" :id="{{ $recipe->id }}"></modules-comment-form>

{{--        <global-ui-google-ad code="7206823714"></global-ui-google-ad>--}}

    </div>
@endsection

@section('alternateMetas')
    <meta property="article:publisher" content="https://www.facebook.com/coeliacsanctuary"/>
    <meta property="article:section" content="Food"/>
    <meta property="article:published_time" content="{{ $recipe->created_at }}"/>
    <meta property="article:modified_time" content="{{ $recipe->updated_at }}"/>
    <meta property="article:author" content="Coeliac Sanctuary"/>
    <meta property="article:tag" content="{{ $recipe->meta_keywords }}"/>
@endsection

@section('footerJavascript')
    <script type="application/ld+json">
        @json($recipe->richText)
    </script>
@endsection
