@extends('templates.page-single-column')

@section('primary-column')
    <div class="min-h-[400px]">
        <wheretoeat-page-eatery-details :eatery='@JSON($eatery)' :branch='@JSON($branch)'>
            <div class="flex flex-col space-y-3">
                <div class="page-box page-box-no-padding flex flex-col space-y-3">
                    <div class="flex justify-between items-center bg-grey-light p-3">
                        <div class="w-1/3 h-[1rem] bg-grey-dark bg-opacity-50 animate-pulse"></div>

                        <div class="flex justify-center relative">
                            <div class="w-8 h-8 rounded bg-grey-dark bg-opacity-50 animate-pulse mr-2"></div>
                            <div class="w-8 h-8 rounded bg-grey-dark bg-opacity-50 animate-pulse mr-2"></div>
                            <div class="w-8 h-8 rounded bg-grey-dark bg-opacity-50 animate-pulse mr-2"></div>
                            <div class="w-8 h-8 rounded bg-grey-dark bg-opacity-50 animate-pulse"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between px-3">
                            <div class="h-10 w-1/2 bg-grey-dark bg-opacity-50 animate-pulse"></div>
                            <div class="w-6 h-6 pt-2 xs:w-7 xs:h-7 bg-blue-light bg-opacity-80 animate-pulse"></div>
                        </div>
                        <div class="w-1/3 h-5 font-semibold mx-3 bg-grey-dark bg-opacity-50 animate-pulse mt-1"></div>
                        <div class="w-1/4 h-4 font-semibold mx-3 bg-grey-dark bg-opacity-50 animate-pulse mt-1"></div>
                    </div>
                    <ul class="flex flex-wrap gap-2 items-center space-x-1">
                        <li class="bg-blue-light bg-opacity-25 rounded my-1 leading-none h-[28px] w-16 animate-pulse"></li>
                        <li class="bg-blue-light bg-opacity-25 rounded my-1 leading-none h-[28px] w-16 animate-pulse"></li>
                        <li class="bg-blue-light bg-opacity-25 rounded my-1 leading-none h-[28px] w-16 animate-pulse"></li>
                    </ul>
                </div>

                <div class="page-box">
                    <div class="w-full h-[1rem] bg-grey-dark bg-opacity-50 animate-pulse mb-2"></div>
                    <div class="w-1/3 h-[1rem] bg-grey-dark bg-opacity-50 animate-pulse mb-2"></div>

                    <ul class="flex flex-wrap space-x-12">
                        <li class="w-full items-center flex">
                            <div class="mr-2 flex-shrink-0 w-8">
                                <div class="w-8 h-8 pt-2 xs:w-7 xs:h-7 bg-blue-light bg-opacity-80 animate-pulse"></div>
                            </div>
                            <div class="w-1/3 h-[1.5rem] bg-grey-dark bg-opacity-50 animate-pulse"></div>
                        </li>
                    </ul>
                </div>

                <div class="page-box">
                    <div class="w-full h-[1rem] bg-grey-dark bg-opacity-50 animate-pulse mb-2"></div>
                    <div class="w-full h-[1rem] bg-grey-dark bg-opacity-50 animate-pulse mb-2"></div>
                    <div class="w-full h-[1rem] bg-grey-dark bg-opacity-50 animate-pulse mb-2"></div>
                    <div class="w-1/3 h-[1rem] bg-grey-dark bg-opacity-50 animate-pulse mb-2"></div>
                </div>

                <div>
                    <div class="border border-blue bg-blue-lightest rounded mx-3 lg:mx-0 animate-pulse h-16"></div>
                </div>

                <div class="page-box">
                    <div class="w-full h-32"></div>
                </div>
            </div>
        </wheretoeat-page-eatery-details>
    </div>

    <global-ui-google-ad code="5284484376"></global-ui-google-ad>

    <div class="page-box mt-2">
        <h2 class="text-2xl font-coeliac text-center font-semibold leading-tight md:text-left">
            Coeliac Sanctuary - On the Go App
        </h2>

        <p class="mt-2">
            Do you use our Eating Out guide often? Why not check out our <strong>Coeliac Sanctuary - On the
                Go</strong> App to help you easily find places near you to eat Gluten Free!
        </p>

        <global-ui-link-button title="Coeliac Sanctuary - On the Go App"
                               class="px-4 py-2 rounded-lg font-semibold my-2"
                               href="/wheretoeat/coeliac-sanctuary-on-the-go"
        >
            Find out more...
        </global-ui-link-button>
    </div>
@endsection
