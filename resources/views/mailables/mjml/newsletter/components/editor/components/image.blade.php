<div>
@if($image)
        <div class="w-full p-2">
            <img src="{{ is_string($image) ? $image : $image->temporaryUrl() }}">
        </div>

        <div class="m-2 p-2 border text-base w-full flex space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-6 h-6"
            >
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244"
                />
            </svg>

            <input type="text" wire:model.lazy="link" class="flex-1"
                   placeholder="Link (Leave blank for no link)"
            />
        </div>
    @endif

<input type="file" wire:model.lazy="image" class="text-2xl w-full" accept="image/*"/>
</div>
