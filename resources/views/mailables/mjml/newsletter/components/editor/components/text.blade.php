<textarea
        wire:model.lazy="content"
        placeholder="Type your content..."
        class="w-full text-base"
        x-data="{ resize: () => { $el.style.height = '5px'; $el.style.height = $el.scrollHeight + 'px' } }"
        x-init="resize()"
        @input="resize()"
        style="min-height: 100px;"
></textarea>
