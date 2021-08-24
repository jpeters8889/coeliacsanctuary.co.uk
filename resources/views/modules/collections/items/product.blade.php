<div class="flex flex-col sm:flex-row">
    <div class="flex flex-col mb-2 sm:mb-0 sm:mr-2 sm:w-1/4">
        <a href="{{ $product->link }}" target="_blank">
            <img data-src="{{ $product->first_image }}"
                 src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E"
                 alt="{{ $product->title }}" loading="lazy" class="lazy"/>
        </a>
    </div>

    <div class="p-2 flex flex-col sm:flex-1 sm:py-0">
        <a href="{{ $product->link }}" target="_blank"
           class="text-2xl text-blue-darkest hover:text-grey-dark transition-all font-semibold font-coeliac leading-tight">
            <h2>{{ $product->title }}</h2>
        </a>

        <div class="flex-1">
            <p class="mb-4">{{ $description }}</p>

            <p class="mb-2">Price: {{ formatPrice($product->current_price) }}</p>

            <p><a class="text-blue font-semibold hover:text-black" href="{{ $product->link }}" target="_blank">Find out
                    more</a></p>
        </div>

        <div class="flex justify-end">
            <a class="py-1 px-2 rounded-lg font-semibold bg-gradient-to-br from-blue/30 to-blue-light/30 text-xs"
               href="/shop" target="_blank">
                Shop Product
            </a>
        </div>
    </div>
</div>
