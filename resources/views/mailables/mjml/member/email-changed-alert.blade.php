@extends('mailables.mjml.layouts.coeliac')

@section('main-content')
    <mj-section>
        <mj-column>
            <mj-text mj-class="inner" padding-bottom="10px">
                <h2>You've changed your email address</h2>
            </mj-text>
            <mj-text mj-class="inner">Hi {{ $notifiable->name }}</mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-text mj-class="inner">
                We're just writing to let you know that you have changed the email address
                associated with your account on Coeliac Sanctuary to {{ $notifiable->email }}
            </mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-text mj-class="inner">
                Since you have a new email address we have limited your account until you verify your new email address,
                please check your inbox for your new account and follow the instructions there.
            </mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-text mj-class="inner" padding-top="5px">
                If you didn't change your email address on www.coeliacsanctuary.co.uk please
                <a href="{{ config('app.url') }}/contact">contact us</a> urgently.
            </mj-text>
        </mj-column>
    </mj-section>
@endsection
