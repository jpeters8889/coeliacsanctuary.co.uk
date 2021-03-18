<div class="flex flex-col sm:flex-row">
    <div class="flex flex-col mb-2 sm:mb-0 sm:mr-2 sm:w-1/4">
        <a href="{{ $recipe->link }}" target="_blank">
            <global-ui-recipe-image src="{{ $recipe->main_image }}" alt="{{ $recipe->title }}"></global-ui-recipe-image>
        </a>
    </div>

    <div class="p-2 flex flex-col sm:flex-1 sm:py-0">
        <a href="{{ $recipe->link }}" target="_blank"
           class="text-2xl text-blue-darkest hover:text-grey-dark transition-color font-semibold font-coeliac leading-tight">
            <h2>{{ $recipe->title }}</h2>
        </a>

        <p class="flex-1">{{ $description }}</p>

        <div class="flex justify-between">
            <p class="text-xs mt-2">Originally Posted: {{ formatDate($recipe->created_at) }}</p>
            <a class="py-1 px-2 rounded-lg font-semibold bg-blue-gradient-30 text-xs" target="_blank"
               href="/recipe">
                Recipe
            </a>
        </div>
    </div>
</div>
