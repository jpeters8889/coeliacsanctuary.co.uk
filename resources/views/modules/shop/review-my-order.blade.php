@extends('templates.page-single-column')

@section('inner-content')
    <div class="space-y-3">
        <div class="page-box">
            <h1 class="my-4 p-3 text-3xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
                Review My Order
            </h1>

            <div class="space-y-2">
                <p>
                    Thank you for your recent order, <strong>{{ $id }}</strong>, I hope you
                    received your order quickly, and that it met your expectations!
                </p>
                <p>
                    I'd really appreciate it if you could take a few moments of your time to review any products you
                    ordered, any feedback you provide will be great and will help me maintain the high quality of
                    service I try to provide, and even improve my products and service.
                </p>
                <p>
                    Your reviews will also be displayed on the products page so other potential buyers can see how other
                    people find our products and their experience with them!
                </p>
                @if(count($products) > 1)
                    <p>
                        You can leave feedback for as many or as few of the products you ordered, when your finished,
                        just
                        hit the <strong>"Submit My Review"</strong> button at the bottom!
                    </p>
                @endif

                <p class="font-semibold">
                    If you haven't received your order yet, please
                    <contact-trigger class="text-blue-dark underline cursor-pointer" inline>get in touch</contact-trigger>
                    quoting your order number above, and I'll endeavour to rectify this. Our review invitation emails
                    are automatically sent at least 10 days after your order was marked as dispatched (This will vary for
                    orders outside the UK) and in 99% of cases you should have received it by now, but things can sometimes
                    get delayed with Royal Mail.
                </p>
                <p>
                    Thank you again, Alison - Coeliac Sanctuary Owner.
                </p>
            </div>
        </div>

        <shop-review-my-order
                invitation="{{ $invitation }}"
                :products="@json($products)"
                name="{{ $name }}"
        />
    </div>
@endsection
