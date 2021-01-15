@if($announcements->count() > 0)
    <announcement>
        <div class="bg-red-dark p-1 text-center text-white">
            <div class="flex flex-col">
                <div class="mb-2 font-semibold">
                    {{ $announcements->first()->title }}
                </div>
                <a class="cursor-pointer text-white-80 text-sm hover:text-white hover:underline transition-color"
                   @click="showModal = true">
                    Read more
                </a>
            </div>
        </div>

        <template v-slot:body>
            {!! $announcements->first()->text !!}
        </template>
    </announcement>
@endif
