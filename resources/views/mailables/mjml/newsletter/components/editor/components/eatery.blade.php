<div class="flex relative">
    <input type="hidden" wire.model="eateryId"/>

    @if($eateryId)
        <div class="">
            <h2 class="text-xl">{{ $eatery->name }}</h2>
            <h3 class="text-lg">{{ $eatery->full_location }}</h3>
        </div>
    @else
        <div class="flex items-center justify-between space-x-2 w-full">
            <input type="text" wire:model.debounce="search" placeholder="Search eateries..." class="text-2xl w-full"/>
            <a class="text-base cursor-pointer" wire:click.prevent="randomEatery()">Random</a>
        </div>
    @endif

    @if($search !== '')
        <div class="absolute bg-white min-h-[8rem] mt-2 shadow text-base w-full z-50"
             style="top: 100%; max-height: 500px; overflow: scroll;"
        >
            <ul class="">
                @forelse($results as $eatery)
                    <li class="flex p-2 space-x-2 hover:bg-gray-200 transition cursor-pointer @unless($loop->last) border-b @endunless"
                        wire:click="selectEatery({{ $eatery->id }})"
                    >
                        <div style="width: 80%">
                            <h2 class="text-xl">{{ $eatery->full_name }}</h2>
                        </div>
                    </li>
                @empty
                    <li>No eateries found...</li>
                @endforelse
            </ul>
        </div>
    @endif
</div>
