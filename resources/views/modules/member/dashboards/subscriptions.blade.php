@extends('modules.member.dashboard')

@section('dashboard')
    <div>
        <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
            Your Subscriptions
        </h1>

        <p>
            Here you can manage any parts of our website that you are subscribed to, for anything that you are
            subscribed to, you will receive an email when an item is added.
        </p>

        <p class="mt-2">
            You can subscribe to <a href="/blog"class="font-semibold hover:text-blue-dark" target="_blank">blog tags</a>, and counties and towns in our <a
               class="font-semibold hover:text-blue-dark" href="/wheretoeat">Eating Out guide</a>.
        </p>

        <dashboard-subscriptions/>
    </div>
@endsection
