@extends('templates.page-single-column')

@section('primary-column')
    <div class="page-box p-4 mt-4">
        <p class="mb-4 text-lg">
            Forgot your password? Just enter the email associated with your account below and we'll send you a link to
            reset it!
        </p>
        <member-forgot-password-form></member-forgot-password-form>
    </div>
@endsection
