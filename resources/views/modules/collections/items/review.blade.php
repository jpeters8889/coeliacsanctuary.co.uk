<div class="flex flex-col sm:flex-row">
    <div class="flex flex-col mb-2 sm:mb-0 sm:mr-2 sm:w-1/4">
        <a href="{{ $review->link }}" target="_blank">
            <img data-src="{{ $review->main_image }}"
                 src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"
                 alt="{{ $review->title }}" loading="lazy" class="lazy"/>
        </a>
    </div>

    <div class="p-2 flex flex-col sm:flex-1 sm:py-0">
        <a href="{{ $review->link }}" target="_blank"
           class="text-2xl text-blue-darkest hover:text-grey-dark transition-color font-semibold font-coeliac leading-tight">
            <h2>{{ $review->title }}, {{ $review->eatery->town->town }}</h2>
        </a>

        <p class="flex-1">{{ $description }}</p>

        <div class="flex justify-between">
            <p class="text-xs mt-2">Originally Posted: {{ formatDate($review->created_at) }}</p>
            <a class="py-1 px-2 rounded-lg font-semibold bg-blue-gradient-30 text-xs"
               href="/review" target="_blank">
                Review
            </a>
        </div>
    </div>
</div>
