@extends('mailables.mjml.layouts.coeliac')

@section('main-content')
    <mj-section>
        <mj-column>
            <mj-text mj-class="inner" padding-bottom="10px">
                <h2>Your review has been approved</h2>
            </mj-text>
            <mj-text mj-class="inner">Hi {{ $rating->name }}</mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-text mj-class="inner">Thank you for leaving a review on {{ $rating->eatery->name }}, {{ $rating->eatery->town->town }}</mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-text mj-class="inner">Your review has been approved and is visible for everyone to see!</mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
        </mj-column>
    </mj-section>
@endsection
