@extends('templates.page-two-column')

@section('primary-column')
    <div class="flex flex-col"chunk>
        <div class="page-box">
            <h1 class="text-2xl font-coeliac text-center font-semibold leading-tight md:text-left">
                Find Coeliac information, events, storecupboard staples, beginners shopping list and more!
            </h1>
            <div class="flex flex-col -mx-3 md:flex-row">
                <div class="bg-blue-light-50 rounded-lg m-3 p-3">
                    <a title="Coeliac Information" href="/info/coeliac" class="flex flex-col items-center text-center">
                        <img src="{{ asset('assets/images/misc/info-index-coeliac.png') }}" alt="">
                        <h2 class="text-lg font-semibold mb-1">Coeliac Information</h2>
                        <p>New to Coeliac? Find some general information here!</p>
                    </a>
                </div>

                <div class="bg-blue-light-50 rounded-lg m-3 p-3">
                    <a title="Shopping List" href="/info/shopping-list" class="flex flex-col items-center text-center">
                        <img src="{{ asset('assets/images/misc/info-index-shopping.png') }}" alt="">
                        <h2 class="text-lg font-semibold mb-1">Shopping List</h2>
                        <p>Just being diagnosed? Not sure what you need? We've got you covered</p>
                    </a>
                </div>

                <div class="bg-blue-light-50 rounded-lg m-3 p-3">
                    <a title="Storecupboard Checklist" href="/info/storecupboard-check" class="flex flex-col items-center text-center">
                        <img src="{{ asset('assets/images/misc/info-index-storecupboard.png') }}" alt="">
                        <h2 class="text-lg font-semibold mb-1">Storecupboard Checklist</h2>
                        <p>Have you got everything you need? Find out here</p>
                    </a>
                </div>

                <div class="bg-blue-light-50 rounded-lg m-3 p-3">
                    <a title="Gluten Challenge" href="/info/gluten-challenge" class="flex flex-col items-center text-center">
                        <img src="{{ asset('assets/images/misc/info-index-challenge.png') }}" alt="">
                        <h2 class="text-lg font-semibold mb-1">Gluten Challenge</h2>
                        <p>Need to do the formidable Gluten Challenge? Find all the details here</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('secondary-column')
    <div class="flex flex-col">
        <x-widget class="mb-3" title="Sign up to our newsletter">
            <global-ui-newsletter-signup />
        </x-widget>

        <global-ui-google-ad code="7266831645"></global-ui-google-ad>
    </div>
@endsection
