@extends('modules.member.dashboard')

@section('dashboard')
    <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
        Your Details
    </h1>

    <div>
        <member-dashboard-modal-user-details
            name="{{ request()->user()->name }}"
            email="{{ request()->user()->email }}"
            phone="{{ request()->user()->phone }}"
        ></member-dashboard-modal-user-details>
    </div>
@endsection
