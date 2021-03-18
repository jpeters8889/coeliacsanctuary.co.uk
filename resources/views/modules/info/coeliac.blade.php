@extends('templates.page-two-column')

@section('primary-column')
    <div class="flex flex-col" chunk>
        <div class="page-box">
            <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
                About Coeliac Disease
            </h1>

            <h6 class="text-center -mt-4 pt-1">
                <a class="text-sm font-semibold font-sans hover:text-blue-dark transition-color" href="/info">
                    More Coeliac Information
                </a>
            </h6>

            <p class="mt-4">
                Are you new to coeliac or gluten intolerance? On this page we've got a lot of common information on
                Coeliac disease, from what it is, to the gluten free lifestyle, and the risk to family and any of your
                children.
            </p>

            <div class="flex flex-col mt-4">
                @foreach($accordions as $accordion)
                    <global-ui-accordion group="info" name="{{ $accordion->id }}">
                        <template v-slot:title>
                            <h2 class="text-xl font-semibold p-1 border-b border-blue cursor-pointer flex items-center">
                                <span class="flex-1 text-grey-dark">{{ $accordion->title }}</span>
                                <font-awesome-icon class="text-blue"
                                                   :icon="['fas', 'angle-double-right']"></font-awesome-icon>
                            </h2>
                        </template>

                        <template v-slot:body>
                            <div class="main-body">
                                {!! $accordion->body !!}
                            </div>
                        </template>
                    </global-ui-accordion>
                @endforeach
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

        @include('components.related-item', [$related, $title = 'Recent Blogs'])
    </div>
@endsection
