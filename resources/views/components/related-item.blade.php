<widget>
    <template v-slot:title>{{ $title ?? 'You might also like...' }}</template>

    <template v-slot:body>
        @foreach($related as $item)
            <div
                class="w-full rounded-lg overflow-hidden flex flex-col shadow-md bg-blue-gradient-30 {{ !$loop->last ? 'mb-4 sm:mb-3' : 'mb-1' }}">
                <div>
                    <a href="{{ $item->link }}">
                        @if($item instanceof \Coeliac\Modules\Recipe\Models\Recipe)
                            <recipe-image src="{{ $item->main_image }}" alt="{{ $item->title }}"></recipe-image>
                        @else
                            <img data-src="{{ $item->main_image }}" alt="{{ $item->title }}" loading="lazy" class="lazy"
                                 src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"/>
                        @endif
                    </a>
                </div>
                <div class="p-2 flex flex-col h-full">
                    <a href="{{ $item->link }}">
                        <h3 class="font-bold hover:underline">{{ $item->title }}</h3>
                    </a>
                    <p class="flex-1">{{ $item->meta_description }}</p>
                </div>
            </div>
        @endforeach
    </template>
</widget>
