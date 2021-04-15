@extends('mailables.mjml.layouts.coeliac')

@section('main-content')
    <mj-section>
        <mj-column>
            <mj-text mj-class="inner" padding-bottom="10px">
                <h2>You've changed your password!</h2>
            </mj-text>
            <mj-text mj-class="inner">Hi {{ $notifiable->name }}</mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-text mj-class="inner">
                We're just writing to let you know that you have changed the password
                associated with your account on Coeliac Sanctuary.
            </mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-text mj-class="inner" padding-top="5px">
                If you didn't change your password on www.coeliacsanctuary.co.uk please
                <a href="{{ config('app.url') }}/contact">contact us</a> urgently.
            </mj-text>
        </mj-column>
    </mj-section>
@endsection
