@extends('mailables.mjml.layouts.coeliac')

@section('main-content')
    <mj-section>
        <mj-column>
            <mj-text mj-class="inner" padding-bottom="10px">
                <h2>Your order has been cancelled</h2>
            </mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-text mj-class="inner">Hi {{ $order->address->name }}</mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-text mj-class="inner">This is confirmation that your order, #{{ $order->order_key }} has been cancelled.</mj-text>
        </mj-column>
    </mj-section>
@endsection
