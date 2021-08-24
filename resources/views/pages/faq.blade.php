@extends('templates.page-single-column')

@section('primary-column')
    <div class="flex flex-col" chunk>
        <div class="page-box">
            <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
                Frequently Asked Questions
            </h1>

            <div class="flex flex-col mt-4 min-h-screen">
                <p class="mb-4">
                    We get asked a few common questions now and then, so we thought we'd put them on our website,
                    hopefully this helps with any questions you might have!
                </p>

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
