@extends('templates.shop')

@section('primary-column')
    <div class="flex flex-col">
        <div class="page-box">
            <h1 class="text-2xl font-coeliac text-center font-semibold leading-tight md:text-left">
                Checkout
                <a class="text-xs font-sans hover:text-grey transition-color" href="/shop"><br />Back
                    to Shop Home</a>
            </h1>

            @if(config('app.env') !== 'production')
                <div class="w-11/12 mx-auto bg-yellow p-4 rounded-lg mb-4 text-center">
                    <p>
                        <h2 class="text font-semibold mb-2">Payments are in test mode, use the following credentials.</h2>
                    </p>
                    <div class="flex flex-col sm:flex-row justify-between">
                        <div class="mb-2 sm:w-1/2 sm:text-left">
                            <h3 class="font-semibold mb-2">Card Payments</h3>
                            <p class="text-sm">
                                <span class="font-semibold">Number</span> 4242 4242 4242 4242 <span class="font-semibold">OR</span><br/>
                                4000 0027 6000 3184<br />
                                <span class="font-semibold">CVC</span> 123<br />
                                <span class="font-semibold">Exp</span> 12/{{ date('y') }}
                            </p>
                        </div>
                        <div class="sm:w-1/2 sm:text-left">
                            <h3 class="font-semibold mb-2">PayPal</h3>
                            <p class="text-sm">
                                <span class="font-semibold">Email</span> contact-buyer@coeliacsanctuary.co.uk<br />
                                <span class="font-semibold">Password</span>
                                Coeliac123
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <basket-page></basket-page>
        </div>
    </div>
@endsection
