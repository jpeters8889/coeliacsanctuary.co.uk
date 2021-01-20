@extends('templates.page-two-column')

@section('primary-column')
    <div class="flex flex-col" style="max-width: 1200px">
        <div class="page-box p-3">
            <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">{{ $recipe->title }}</h1>

            <p class="text-lg my-2 font-medium leading-relaxed">{{ $recipe->description }}</p>

            <div class="mt-3 p-3 text-sm mt-1 text-grey-darker bg-blue-light-20 flex justify-between">
                <div class="flex-1">
                    Added {{ formatDate($recipe->created_at) }}
                    @if($recipe->updated_at && !$recipe->updated_at->isSameDay($recipe->created_at))
                        <br/>Updated {{ formatDate($recipe->updated_at) }}
                    @endif
                    <br/>Recipe by {{ $recipe->author }}
                </div>
                <a class="text-3xl text-black" href="/recipe/{{ $recipe->slug }}/print" target="_blank">
                    <font-awesome-icon :icon="['fas', 'print']"></font-awesome-icon>
                </a>
            </div>
        </div>

        <div>
            <recipe-image src="{{ $recipe->main_image }}" alt="{{ $recipe->title }}"></recipe-image>
        </div>

        <div class="page-box p-3 flex flex-col">
            <google-ad code="2137793897"></google-ad>

            <div class="my-2 py-2 border-b border-yellow">
                <h3 class="text-base font-semibold">This recipe is...</h3>
                <ul class="flex flex-wrap -mx-2">
                    @foreach($recipe->features as $feature)
                        <li class="w-1/4 m-2 flex flex-col max-w-recipe-feature text-xs leading-none text-center">
                            <img src="{{ $feature->image }}" alt="{{ $feature->feature }}">
                            <span class="font-semibold mt-1">{{ $feature->feature }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="my-2 pb-2 border-b border-yellow flex flex-col">
                <h3 class="text-base font-semibold">Ingredients</h3>
                <article>
                    {!! $recipe->ingredients !!}
                </article>
                <ul class="mt-2">
                    <li><strong class="font-semibold">Preparation Time:</strong> {{ $recipe->prep_time }}</li>
                    <li><strong class="font-semibold">Cooking Time:</strong> {{ $recipe->cook_time }}</li>
                    <li><strong class="font-semibold">This recipe makes {{ $recipe->serving_size }}</strong></li>
                </ul>
                <div class="my-2">
                    <h3 class="text-base font-semibold mb-1">This recipe is free from...</h3>
                    <div class="flex flex-wrap">
                        @foreach(\Coeliac\Modules\Recipe\Models\RecipeAllergen::all() as $allergen)
                            <div
                                class="text-xxs font-semibold border border-blue-light flex w-1/2 xs:w-1/3 sm:w-1/4 md:w-1/5 lg:w-1/4 2xl:w-1/7">
                                <div
                                    class="bg-blue-light p-2 flex-1 border-b border-white">{{ $allergen->allergen }}</div>
                                <div class="p-2 flex items-center justify-center" style="width: 25px">
                                    @if($recipe->allergens->where('allergen', $allergen->allergen)->count() === 1)
                                        <font-awesome-icon :icon="['fas', 'check']"
                                                           class="text-green"></font-awesome-icon>
                                    @else
                                        <font-awesome-icon :icon="['fas', 'times']"
                                                           class="text-red"></font-awesome-icon>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="my-2 pb-2 flex flex-col main-body">
                <google-ad code="2137793897"></google-ad>

                <h3 class="text-base font-semibold">Method</h3>

                <article>
                    {!! $recipe->method !!}
                </article>

                <google-ad code="4702154153"></google-ad>
            </div>
        </div>

        <div class="page-box p-3 mt-3">
            <h2 class="text-2xl my-2 font-semibold font-coeliac">Your Comments</h2>

            <div class="flex flex-col -mb-3">
                <comments area="recipe" :id="{{ $recipe->id }}"></comments>
            </div>
        </div>

        <comment-form area="recipe" :id="{{ $recipe->id }}"></comment-form>

    </div>
@endsection

@section('secondary-column')
    <div class="flex flex-col">
        <widget-recipe-search class="mb-3"></widget-recipe-search>

        <widget-newsletter-signup class="mb-3"></widget-newsletter-signup>

        @if($featured)
            @include('components.featured-in', $featured)
        @endif

        @include('components.related-item', $related)
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
