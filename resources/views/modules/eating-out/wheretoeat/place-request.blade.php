@extends('templates.page-two-column')

@section('primary-column')
    <div class="flex flex-col" style="max-width: 1200px">
        <div class="page-box">
            <h1 class="text-2xl font-coeliac text-center font-semibold leading-tight md:text-left">
                Place Request<br />
                <a class="text-xs font-sans hover:text-grey transition-color" href="/wheretoeat">Back
                    to Map/List</a>
            </h1>

            <p>
                Do you know a place that needs adding to our guide? Or maybe one we have listed doesn't offer gluten
                free anymore. Let us know
            </p>

            <wheretoeat-place-request-form></wheretoeat-place-request-form>
        </div>
    </div>
@endsection

@section('secondary-column')
    <div class="flex flex-col">
        <widget-newsletter-signup class="mb-3"></widget-newsletter-signup>

        <widget>
            <template v-slot:title>Random Reviews</template>

            <template v-slot:body>
                @foreach($related as $relatedRecipe)
                    <div
                        class="w-full rounded-lg overflow-hidden flex flex-col shadow-md mb-4 bg-blue-gradient-30 {{ !$loop->last ? 'sm:mb-3' : '' }}">
                        <div>
                            <img src="{{ $relatedRecipe->main_image }}" alt="{{ $relatedRecipe->title }}" />
                        </div>
                        <div class="p-2 flex flex-col h-full">
                            <a href="{{ $relatedRecipe->link }}">
                                <h3 class="font-bold hover:underline">{{ $relatedRecipe->title }}</h3>
                            </a>
                            <p class="flex-1">{{ $relatedRecipe->meta_description }}</p>
                        </div>
                    </div>
                @endforeach
            </template>
        </widget>
    </div>
@endsection
