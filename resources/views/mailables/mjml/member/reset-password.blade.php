@extends('mailables.mjml.layouts.coeliac')

@section('main-content')
    <mj-section>
        <mj-column>
            <mj-text mj-class="inner" padding-bottom="10px">
                <h2>Reset your password!</h2>
            </mj-text>
            <mj-text mj-class="inner">Hi {{ $notifiable->name }}</mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-text mj-class="inner">You have requested a password reset on your Coeliac Sanctuary account.</mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-text mj-class="inner">
                To reset your password click the link below and create a new password.
            </mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>

            <mj-button href="{{ $reset_url }}">
                Reset my Password!
            </mj-button>
            <mj-text mj-class="inner" padding-top="5px">
                If you didn't request the resetting of your password please.
                <a href="{{ config('app.url') }}/contact">contact us</a>.
            </mj-text>
        </mj-column>
    </mj-section>
@endsection
