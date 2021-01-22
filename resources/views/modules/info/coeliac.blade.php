@extends('templates.page-two-column')

@section('primary-column')
    <div class="flex flex-col"chunk>
        <div class="page-box">
            <h1 class="text-2xl font-coeliac text-center font-semibold leading-tight md:text-left">
                About Coeliac Disease
                <a class="text-xs font-sans hover:text-grey transition-color" href="/info"><br/>More Information</a>
            </h1>

            <div class="flex flex-col mt-4">
                @foreach($accordions as $accordion)
                    <accordion group="info" name="{{ $accordion->id }}">
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
                    </accordion>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('secondary-column')
    <div class="flex flex-col">
        <widget-newsletter-signup class="mb-3"></widget-newsletter-signup>

        @include('components.related-item', [$related, $title = 'Recent Blogs'])
    </div>
@endsection
