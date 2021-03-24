@extends('modules.member.dashboard')

@section('dashboard')
    <div>
        <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
            Daily Updates
        </h1>

        <p>
            Here you can manage any parts of our website that you are subscribed to, for anything that you are
            subscribed to, you will receive an email when an item is added, we'll never email you more than once a day,
            and only when new things are added to areas you're subscribed to.
        </p>

        <p class="mt-2">
            You can subscribe to <a href="/blog" class="font-semibold hover:text-blue-dark" target="_blank">blog
                tags</a>, and counties and towns in our <a
                class="font-semibold hover:text-blue-dark" href="/wheretoeat">Eating Out guide</a>.
        </p>

        <member-dashboard-page-daily-updates />
    </div>
@endsection
