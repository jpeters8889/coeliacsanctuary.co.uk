@extends('templates.page')

@section('inner-content')
    {{--    <google-ad code="2925914349"></google-ad>--}}

    <div class="min-h-screen bg-white">
        <module-list-index module="reviews" title="Reviews" url-prefix="review">
            <div class="p-3">
                <div
                    class="flex justify-between items-center p-2 text-2xl bg-blue-gradient-30 border-b-4 border-yellow rounded-t-lg leading-none">
                    <h1 class="font-semibold font-coeliac pt-2">Coeliac Sanctuary Reviews</h1>
                </div>

                <div class="top-0 left-0 flex justify-center items-center w-full h-full z-max bg-transparent absolute">
                    <div class="rounded-full spin border-blue-light border-8 w-1/2"
                         style="border-top-color: #80CCFC; height: 50%; max-width: 50px; max-height: 50px;">
                    </div>
                </div>
            </div>
        </module-list-index>
    </div>

    {{--    <google-ad code="3472709255"></google-ad>--}}
@endsection
