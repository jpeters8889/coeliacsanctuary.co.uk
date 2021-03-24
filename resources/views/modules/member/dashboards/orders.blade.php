@extends('modules.member.dashboard')

@section('dashboard')
    <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
        Your Purchase History
    </h1>

    @if($user->hasVerifiedEmail())
        <div>
            <member-dashboard-page-recent-orders></member-dashboard-page-recent-orders>
        </div>
    @else
        <div>
            You need to verify your email address before you can view your order history.
        </div>
    @endif
@endsection
