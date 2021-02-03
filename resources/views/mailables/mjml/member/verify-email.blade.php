@extends('mailables.mjml.layouts.coeliac')

@section('main-content')
    <mj-section>
        <mj-column>
            <mj-text mj-class="inner" padding-bottom="10px">
                <h2>Thanks for registering, please confirm your email address!</h2>
            </mj-text>
            <mj-text mj-class="inner">Hi {{ $notifiable->name }}</mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-text mj-class="inner">Thank you for registering an account on our website</mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-text mj-class="inner">Before you can use your account you must verify your email, just click the button below and you're all set!</mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-button href="{{ config('app.url') }}{{ $verification_link }}">
                Verify my email
            </mj-button>
            <mj-text mj-class="inner">
                If you didn't register an account on www.coeliacsanctuary.co.uk please
                <a href="{{ config('app.url') }}/contact">contact us</a>.
            </mj-text>
        </mj-column>
    </mj-section>
@endsection
