<x-widget class="mb-3" title="As Featured In">
    @foreach($featured as $feature)
        <div
            class="w-full rounded-lg overflow-hidden flex flex-col shadow-md bg-blue-gradient-30 {{ !$loop->last ? 'mb-4 sm:mb-3' : 'mb-1' }}">
            <div>
                <a href="{{ $feature->link }}">
                    <img data-src="{{ $feature->main_image }}" alt="{{ $feature->title }}" loading="lazy" class="lazy"
                         src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"/>
                </a>
            </div>
            <div class="p-2 flex flex-col h-full">
                <a href="{{ $feature->link }}">
                    <h3 class="font-bold hover:underline">{{ $feature->title }}</h3>
                </a>
                <p class="flex-1">{{ $feature->meta_description }}</p>
            </div>
        </div>
    @endforeach
</x-widget>
