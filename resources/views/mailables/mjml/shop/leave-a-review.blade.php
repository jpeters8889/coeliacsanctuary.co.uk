@extends('mailables.mjml.layouts.coeliac')

@section('main-content')
    <mj-section>
        <mj-column>
            <mj-text mj-class="inner" padding-bottom="10px">
                <h2>Review Your Purchase!</h2>
            </mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-text mj-class="inner">Hi {{ $order->address->name }}</mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-text mj-class="inner">Thanks again for your recent order, we hope it arrived with you quickly!</mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-text mj-class="inner">We'd love to read your feedback about our products, and to share your feedback on our website to help other potential buyers</mj-text>
            <mj-text mj-class="inner"> </mj-text>
            <mj-text mj-class="inner">To leave us a review, click the link below!</mj-text>
            <mj-text mj-class="inner"> </mj-text>
            <mj-button href="{{ $reviewLink }}">
                Leave A Review!
            </mj-button>
            <mj-text mj-class="inner">If you cant see the button above copy the link below into your browser</mj-text>
            <mj-text mj-class="inner">{{ $reviewLink }}</mj-text>
        </mj-column>
    </mj-section>
@endsection
