@extends('mailables.mjml.layouts.coeliac')

@section('main-content')
    <mj-section>
        <mj-column>
            <mj-text mj-class="inner" padding-bottom="10px">
                <h2>Thanks for registering, please confirm your email address!</h2>
            </mj-text>
            <mj-text mj-class="inner">Hi {{ $notifiable->name }}</mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            @if($newUser)
                <mj-text mj-class="inner">Thank you for registering an account on our website</mj-text>
                <mj-text mj-class="inner">&nbsp;</mj-text>
                <mj-text mj-class="inner">
                    Before you can use your account you must verify your email, just click the button below and you're
                    all set!
                </mj-text>
                <mj-text mj-class="inner">&nbsp;</mj-text>
            @else
                <mj-text mj-class="inner">
                    Thanks for updating your email address on our website, to continue to access your account please
                    verify your new email address.
                </mj-text>
                <mj-text mj-class="inner">&nbsp;</mj-text>
                <mj-text mj-class="inner">Just click the link below and you're all set!</mj-text>
                <mj-text mj-class="inner">&nbsp;</mj-text>
            @endif
            <mj-button href="{{ $verification_link }}">
                Verify my email
            </mj-button>
            <mj-text mj-class="inner">If you cant see the button above copy the link below into your browser</mj-text>
            <mj-text mj-class="inner">{{ $verification_link }}</mj-text>
            <mj-text mj-class="inner" padding-top="5px">
                If you didn't register an account on www.coeliacsanctuary.co.uk please
                <a href="{{ config('app.url') }}/contact">contact us</a>.
            </mj-text>
        </mj-column>
    </mj-section>
@endsection
