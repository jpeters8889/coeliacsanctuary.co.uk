@extends('templates.page-two-column')

@section('primary-column')
    <div class="flex flex-col" style="max-width: 1200px">
        <div>
            <recipe-image src="{{ $recipe->main_image }}" alt="{{ $recipe->title }}"></recipe-image>
        </div>

        <div class="page-box p-3 flex flex-col">
            <div class="bg-blue-gradient-30 -mx-3 my-2 p-3 flex-flex-col">
                <h1 class="text-3xl font-coeliac text-center font-semibold leading-tight lg:text-left flex justify-between">
                    <span>{{ $recipe->title }}</span>
{{--                    <a href="/recipe/{{ $recipe->slug }}/print" target="_blank">--}}
{{--                        <font-awesome-icon :icon="['fas', 'print']"></font-awesome-icon>--}}
{{--                    </a>--}}
                </h1>
                <p class="my-1 font-medium">{{ $recipe->description }}</p>
                <p class="text-sm mt-1 text-grey-darker">
                    Added {{ formatDate($recipe->created_at) }}
                    @if($recipe->updated_at && !$recipe->updated_at->isSameDay($recipe->created_at))
                        <br />Updated {{ formatDate($recipe->updated_at) }}
                    @endif
                    <br />Recipe by {{ $recipe->author }}
                </p>
            </div>

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
                <div>
                    {!! $recipe->ingredients !!}
                </div>
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
                                <div class="bg-blue-light p-2 flex-1 border-b border-white">{{ $allergen->allergen }}</div>
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

                <div>
                    {!! $recipe->method !!}
                </div>

                <google-ad code="4702154153"></google-ad>
            </div>
        </div>

        <div class="page-box p-3 mt-3">
            <h2 class="text-2xl my-2 font-semibold font-coeliac">Your Comments</h2>

            <div class="flex flex-col -mb-3">
                @forelse($recipe->comments as $comment)
                    <div class="flex flex-col bg-blue-gradient-30 p-3 border-l-8 border-yellow shadow mb-3">
                        <div class="mb-2">{!! $comment->comment !!}</div>
                        <div class="flex text-xs font-medium text-grey">
                            <div class="mr-2">{{ $comment->name }}</div>
                            <div>{{ formatDate($comment->created_at) }}</div>
                        </div>
                        @if($comment->reply)
                            <div class="flex mt-2 flex-col mt-3 bg-white-80 p-3">
                                <strong>Alison @ Coeliac Sanctuary replied to this comment
                                    on {{ formatDate($comment->reply->created_at) }}</strong>
                                <p>{!! $comment->reply->comment_reply !!}</p>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="mb-3">
                        <strong class="font-semibold">There's no comments on this Recipe, why not leave one?</strong>
                    </div>
                @endforelse
            </div>
        </div>

        <comment-form area="recipe" :id="{{ $recipe->id }}"></comment-form>

    </div>
@endsection

@section('secondary-column')
    <div class="flex flex-col">
        <widget-recipe-search class="mb-3"></widget-recipe-search>

        <widget-newsletter-signup class="mb-3"></widget-newsletter-signup>

        @include('components.related-item', $related)
    </div>
@endsection

@section('alternateMetas')
    <meta property="article:publisher" content="https://www.facebook.com/coeliacsanctuary" />
    <meta property="article:section" content="Food" />
    <meta property="article:published_time" content="{{ $recipe->created_at }}" />
    <meta property="article:modified_time" content="{{ $recipe->updated_at }}" />
    <meta property="article:author" content="Coeliac Sanctuary" />
    <meta property="article:tag" content="{{ $recipe->meta_keywords }}" />
@endsection

@section('footerJavascript')
    <script type="application/ld+json">
        @json($recipe->richText)
    </script>
@endsection
