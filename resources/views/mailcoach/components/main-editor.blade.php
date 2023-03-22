<div>
    <div>
        {!! $template !!}
    </div>

    <x-mailcoach::modal :open="false" name="add-block" :dismissable="true" :medium="true">
        <div class="grid grid-cols-3 w-full gap-2" x-data="{}">
            <div class="w-1/4 rounded p-2 bg-gray-200 flex flex-col justify-center items-center"
                 x-on:click="Livewire.emit('addBlock','single');Alpine.store('modals').close('add-block')"
            >
                <div class="flex">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-12 h-12"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M14.25 9.75L16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z"
                        />
                    </svg>
                </div>

                Single Column
            </div>

            <div class="w-1/4 rounded p-2 bg-gray-200 flex flex-col justify-center items-center"
                 x-on:click="Livewire.emit('addBlock','double');Alpine.store('modals').close('add-block')"
            >
                <div class="flex">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-12 h-12"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M14.25 9.75L16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z"
                        />
                    </svg>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-12 h-12"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M14.25 9.75L16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z"
                        />
                    </svg>
                </div>

                Double Column
            </div>

            <div class="w-1/4 rounded p-2 bg-gray-200 flex flex-col justify-center items-center"
                 x-on:click="Livewire.emit('addBlock','triple');Alpine.store('modals').close('add-block')"
            >
                <div class="flex">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-8 h-8"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M14.25 9.75L16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z"
                        />
                    </svg>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-8 h-8"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M14.25 9.75L16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z"
                        />
                    </svg>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-8 h-8"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M14.25 9.75L16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z"
                        />
                    </svg>
                </div>

                Triple Column
            </div>
        </div>
    </x-mailcoach::modal>

    <x-mailcoach::modal :open="false" name="add-component" :dismissable="true" :medium="true">
        <div class="grid grid-cols-3 w-full gap-2" x-data="{
            addComponent: (component) => {
                window.dispatchEvent(new CustomEvent('add-component', {bubbles: true, detail: {component}}));
            },
        }"
        >
            <div class="w-1/4 rounded p-2 bg-gray-200 flex flex-col justify-center items-center"
                 x-on:click="addComponent('title')"
            >
                <div class="flex">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"/>
                    </svg>
                </div>

                Title
            </div>

            <div class="w-1/4 rounded p-2 bg-gray-200 flex flex-col justify-center items-center"
                 x-on:click="addComponent('subtitle')"
            >
                <div class="flex">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-4 h-6"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15"/>
                    </svg>
                </div>

                Subtitle
            </div>

            <div class="w-1/4 rounded p-2 bg-gray-200 flex flex-col justify-center items-center" x-on:click="addComponent('button')">
                <div class="flex h-6 text-xl">
                    <i class="fas fa-rectangle-wide"></i>
                </div>

                Button
            </div>

            <div class="w-1/4 rounded p-2 bg-gray-200 flex flex-col justify-center items-center" x-on:click="addComponent('text')">
                <div class="flex">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12"
                        />
                    </svg>
                </div>

                Text
            </div>

            <div class="w-1/4 rounded p-2 bg-gray-200 flex flex-col justify-center items-center" x-on:click="addComponent('text-with-button')">
                <div class="flex">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4.5h14.25M3 9h9.75M3 13.5h9.75m4.5-4.5v12m0 0l-3.75-3.75M17.25 21L21 17.25" />
                    </svg>
                </div>

                Text with Button
            </div>

            <div class="w-1/4 rounded p-2 bg-gray-200 flex flex-col justify-center items-center" x-on:click="addComponent('hr')">
                <div class="flex">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"
                        />
                    </svg>
                </div>

                Horizontal Rule
            </div>

            <div class="w-1/4 rounded p-2 bg-gray-200 flex flex-col justify-center items-center" x-on:click="addComponent('image')">
                <div class="flex">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"
                        />
                    </svg>
                </div>

                Image
            </div>

            <div class="w-1/4 rounded p-2 bg-gray-200 flex flex-col justify-center items-center" x-on:click="addComponent('image-with-button')">
                <div class="flex h-6 text-xl">
                    <i class="fas fa-image-polaroid"></i>
                </div>

                Image with Button
            </div>

            <div class="w-1/4 rounded p-2 bg-gray-200 flex flex-col justify-center items-center" x-on:click="addComponent('blog')">
                <div class="flex h-6 text-xl">
                    <i class="fas fa-newspaper"></i>
                </div>

                Blog
            </div>

            <div class="w-1/4 rounded p-2 bg-gray-200 flex flex-col justify-center items-center" x-on:click="addComponent('recipe')">
                <div class="flex h-6 text-xl">
                    <i class="fas fa-hamburger"></i>
                </div>

                Recipe
            </div>

            <div class="w-1/4 rounded p-2 bg-gray-200 flex flex-col justify-center items-center" x-on:click="addComponent('product')">
                <div class="flex h-6 text-xl">
                    <i class="fas fa-shopping-basket"></i>
                </div>

                Product
            </div>

            <div class="w-1/4 rounded p-2 bg-gray-200 flex flex-col justify-center items-center" x-on:click="addComponent('eatery')">
                <div class="flex h-6 text-xl">
                    <i class="fas fa-utensils"></i>
                </div>

                Eatery
            </div>
        </div>
    </x-mailcoach::modal>

</div>
