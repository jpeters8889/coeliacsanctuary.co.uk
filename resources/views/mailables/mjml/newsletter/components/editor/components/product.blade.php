<div class="flex relative">
    <input type="hidden" wire.model="productId"/>

    @if($productId)
        <div class="flex space-x-2">
            <div style="width: 20%">
                <img src="{{ $product->main_image }}"/>
            </div>
            <div style="width: 80%">
                <h2 class="text-xl">{{ $product->title }}</h2>
                <p class="text-base">{{ $product->meta_description }}</p>
                <p class="text-base">&pound;{{ $product->currentPrice / 100 }}</p>
            </div>
        </div>
    @else
        <input type="text" wire:model.debounce="search" placeholder="Search products..." class="text-2xl w-full"/>
    @endif

    @if($search !== '')
        <div class="absolute bg-white min-h-[8rem] mt-2 shadow text-base w-full z-50"
             style="top: 100%; max-height: 500px; overflow: scroll;"
        >
            <ul class="">
                @forelse($results as $product)
                    <li class="flex p-2 space-x-2 hover:bg-gray-200 transition cursor-pointer @unless($loop->last) border-b @endunless" wire:click="selectProduct({{ $product->id }})">
                        <div style="width: 20%">
                            <img src="{{ $product->main_image }}"/>
                        </div>
                        <div style="width: 80%">
                            <h2 class="text-xl">{{ $product->title }}</h2>
                            <p>{{ $product->meta_description }}</p>
                            <p class="text-base">&pound;{{ $product->currentPrice / 100 }}</p>
                        </div>
                    </li>
                @empty
                    <li>No products found...</li>
                @endforelse
            </ul>
        </div>
    @endif
</div>
