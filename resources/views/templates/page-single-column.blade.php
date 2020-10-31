@extends('templates.page')

@section('inner-content')
    <div class="flex flex-wrap flex-1">
        <div class="w-full lg:px-2">
            @yield('primary-column')
        </div>
    </div>
@endsection
