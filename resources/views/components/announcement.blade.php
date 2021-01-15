@if($announcements->count() > 0)
    <announcement>
        <template v-slot:title>
            {{ $announcements->first()->title }}
        </template>

        {!! $announcements->first()->text !!}
    </announcement>
@endif
