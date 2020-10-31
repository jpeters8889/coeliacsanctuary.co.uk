@extends('templates.page')

@section('inner-content')
    <div class="flex flex-wrap flex-1">
        <div class="w-full lg:w-2/3 lg:px-2 xl:w-3/4">
            @yield('primary-column')
        </div>

        <div class="w-full flex-1 mt-2 lg:mt-0 lg:w-1/3 lg:pr-2 xl:w-1/4">
            @yield('secondary-column')
        </div>
    </div>
@endsection
