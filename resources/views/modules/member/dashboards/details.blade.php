@extends('modules.member.dashboard')

@section('dashboard')
    <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
        Your Details
    </h1>

    <div>
        <dashboard-user-details
            name="{{ request()->user()->name }}"
            email="{{ request()->user()->email }}"
            phone="{{ request()->user()->phone }}"
        ></dashboard-user-details>
    </div>
@endsection
