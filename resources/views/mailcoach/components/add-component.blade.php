<div>
    <div class="flex items-center justify-center py-2" x-data="{
        toggleModal: () => {
            if (Alpine.store('modals').isOpen('add-component')) {
                Alpine.store('modals').close('add-component');
                window.activeBlock = null;
                window.activeIndex = null;

                return;
              }

              Alpine.store('modals').open('add-component');
              window.activeBlock = '{{ $blockId }}';
              window.activeIndex = '{{ $index }}';
        },
        addComponent: (event) => {
            if(window.activeBlock !== '{{ $blockId }}' || window.activeIndex !== '{{ $index }}') {
                return;
            }

             const component = event.detail.component;

            Livewire.emit('addComponent', '{{ $blockId }}', component, {{ $index }});
            Alpine.store('modals').close('add-component');
        }
    }" x-on:add-component.window="addComponent"
    >
        <div class="w-36 h-24 rounded-lg bg-gray-200 p-2 flex flex-col items-center justify-center transition cursor-pointer"
             x-on:click="toggleModal"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="w-6 h-6"
            >
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z"
                />
            </svg>

            <p class="text-sm text-center m-0">Add Component</p>
        </div>
    </div>
</div>
