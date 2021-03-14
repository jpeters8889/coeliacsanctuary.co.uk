@if(isset($promoteCompetition) && is_object($promoteCompetition))
    <div class="inner-wrapper my-2">
        <a class="block bg-yellow p-2 text-center text-white" href="/promoteCompetition/{{ $promoteCompetition->slug }}">
            <div class="flex flex-col">
                <h3 class="mb-2 font-semibold">Enter our competition, {{ $promoteCompetition->name }}</h3>
                <p>{{ $promoteCompetition->meta_description }}</p>
            </div>
        </a>
    </div>
@endif
