@if($announcements->count() > 0)
    <div class="bg-red-dark" style="min-height: 72px">
        <announcement>
            <template v-slot:title>
                {{ $announcements->first()->title }}
            </template>

            {!! $announcements->first()->text !!}
        </announcement>
    </div>
@endif
