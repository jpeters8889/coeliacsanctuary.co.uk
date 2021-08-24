@extends('templates.shop')

@section('primary-column')
    <div class="flex flex-col space-y-3">
        <div class="page-box">
            <h1 class="my-4 p-3 text-3xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
                Complete your Order
            </h1>

            <h6 class="text-center -mt-4 pt-1">
                <a class="text-sm font-semibold font-sans hover:text-blue-dark transition-all" href="/shop">
                    Back to Shop Home
                </a>
            </h6>
        </div>

        @if(config('app.env') !== 'production')
            <div class="page-box text-center">
                <h2 class="text font-semibold mb-2">Payments are in test mode, use the following credentials.</h2>

                <div class="flex flex-col sm:flex-row justify-between">
                    <div class="mb-2 sm:w-1/2 sm:text-left">
                        <h3 class="font-semibold mb-2">Card Payments</h3>
                        <p class="text-sm">
                            <span class="font-semibold">Number</span> 4242 4242 4242 4242 <span
                                class="font-semibold">OR</span><br/>
                            4000 0027 6000 3184<br/>
                            <span class="font-semibold">CVC</span> 123<br/>
                            <span class="font-semibold">Exp</span> 12/{{ date('y') }}
                        </p>
                    </div>
                    <div class="sm:w-1/2 sm:text-left">
                        <h3 class="font-semibold mb-2">PayPal</h3>
                        <p class="text-sm">
                            <span class="font-semibold">Email</span> contact-buyer@coeliacsanctuary.co.uk<br/>
                            <span class="font-semibold">Password</span>
                            Coeliac123
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <shop-basket-page></shop-basket-page>
    </div>
@endsection
