@extends('modules.member.dashboard')

@section('dashboard')
    <div>
        <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
            Your Scrapbooks
        </h1>

        <p>
            Scrapbooks are where you can save our blogs, recipes and reviews to be able to get to them later. You can
            create as many scrapbooks as you like, we've already made one for you!
        </p>

        <p class="mt-2">
            To create a new scrapbook just press the <strong class="font-semibold">Add to scrapbook (
                <font-awesome-icon :icon="['far', 'bookmark']"></font-awesome-icon>
            )</strong>
            button in the grey bar at the top of eligible pages.
        </p>

        <dashboard-scrapbooks />
    </div>
@endsection
