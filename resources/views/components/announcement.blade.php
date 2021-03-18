@if($announcements->count() > 0)
    <div class="bg-red-dark">
        <global-layout-announcement>
            <template v-slot:title>
                {{ $announcements->first()->title }}
            </template>

            {!! $announcements->first()->text !!}
        </global-layout-announcement>
    </div>
@endif
