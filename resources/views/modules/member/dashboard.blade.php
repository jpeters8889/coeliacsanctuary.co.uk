@extends('templates.page-single-column')

@section('primary-column')
    @if(!$user->hasVerifiedEmail())
        <div class="m-2 bg-red bg-opacity-20 border border-red rounded-lg p-2 text-lg text-red text-center font-semibold">
            <p>You must verify your email address to use your Dashboard!</p>
            <p class="mt-2">
                <member-ui-verify-email-resend-trigger class="cursor-pointer">Resend verification email.
                </member-ui-verify-email-resend-trigger>
            </p>
        </div>
    @endif

    <div class="page-box p-2">
        <div class="md:flex">
            <div class="md:w-1/4">
                <member-dashboard-ui-navigation></member-dashboard-ui-navigation>
            </div>

            <div class="flex-1">
                @yield('dashboard')
            </div>
        </div>
    </div>
@endsection
