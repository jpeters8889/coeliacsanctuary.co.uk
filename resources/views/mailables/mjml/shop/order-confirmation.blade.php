@extends('mailables.mjml.layouts.coeliac')

@section('main-content')
    <mj-section>
        <mj-column>
            <mj-text mj-class="inner" padding-bottom="10px">
                <h2>Thank you for your order</h2>
            </mj-text>
            <mj-text mj-class="inner">Hi {{ $order->address->name }}</mj-text>
            <mj-text mj-class="inner">Thank you for your recent order on the Coeliac Sanctuary shop, this email is your order confirmation.</mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-text mj-class="inner">
                <h3>Order Details</h3>
            </mj-text>
            <mj-text mj-class="inner">
                <strong>Order Number:</strong> {{ $order->order_key }}<br/>
                <strong>Order Date:</strong> {{ $order->payment->created_at->format('d/m/Y') }}<br/>
                <strong>Payment Method:</strong> {{ $order->payment->type->type === 'Stripe' ? 'Card' : $order->payment->type->type }}
            </mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-text mj-class="inner">
                <h3>Your Items</h3>
            </mj-text>
        </mj-column>
    </mj-section>

    <!-- BEGIN PRODUCTS -->
    @foreach($order->items as $item)
    <mj-section>
        <mj-column width="15%">
            <mj-image padding-right="10px" padding-bottom="5px" width="0" src="{{ $item->product->first_image }}"></mj-image>
        </mj-column>
        <mj-column width="65%">
            <mj-text>
                <a href="{{ $item->product->link }}">{{ $item->quantity }}X {{ $item->product_title }}</a>
            </mj-text>
        </mj-column>
        <mj-column width="20%">
            <mj-text align="right">{{ formatPrice($item->product_price) }}</mj-text>
        </mj-column>
    </mj-section>
    @endforeach
    <!-- END: PRODUCTS -->

    <!-- BEGIN: TOTALS -->
    <mj-section>
        <mj-column>
            <mj-table padding="0">
                <tr padding="5px 0">
                    <td padding="5px 0" width="80">Subtotal</td>
                    <td padding="5px 0" align="right" width="20%">{{ formatPrice($order->payment->subtotal) }}</td>
                </tr>
                <!-- DISCOUNT -->
                <tr padding="5px 0">
                    <td padding="5px 0" width="80">Discount</td>
                    <td padding="5px 0" align="right" width="20%">{{ formatPrice($order->payment->discount) }}</td>
                </tr>
                <!-- END DISCOUNT -->
                <tr padding="5px 0">
                    <td padding="5px 0" width="80%">Postage</td>
                    <td padding="5px 0" align="right" width="20%">{{ formatPrice($order->payment->postage) }}</td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
                <tr padding="5px 0">
                    <td padding="5px 0" width="80%"><strong><h2>TOTAL</h2></strong></td>
                    <td padding="5px 0" align="right" width="20%">
                        <h2>{{ formatPrice($order->payment->total) }}</h2>
                    </td>
                </tr>
            </mj-table>
        </mj-column>
    </mj-section>
    <!-- END: TOTALS -->

    <mj-section>
        <mj-column>
            <mj-text>
                <hr color="#DBBC25"></hr>
            </mj-text>
        </mj-column>
    </mj-section>
    <mj-section padding="0 10px">
        <mj-column>
            <mj-text>
                <h3>Shipping Address</h3>
            </mj-text>
            <mj-text>&nbsp;</mj-text>
            <mj-text>
                <span style="line-height:1.4">{!! $order->address->formattedAddress !!}</span>
            </mj-text>
        </mj-column>

    </mj-section>
@endsection
