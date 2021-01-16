@if($announcements->count() > 0)
    <div class="bg-red-dark">
        <announcement>
            <template v-slot:title>
                {{ $announcements->first()->title }}
            </template>

            {!! $announcements->first()->text !!}
        </announcement>
    </div>
@endif
