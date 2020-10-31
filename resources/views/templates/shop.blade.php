@extends('templates.page')

@section('inner-content')
    <basket-header-widget></basket-header-widget>
    <basket-sidebar></basket-sidebar>

    <div class="flex flex-wrap flex-1">
        <div class="w-full lg:px-2">
            @yield('primary-column')
        </div>
    </div>

    <basket-quick-link></basket-quick-link>
@endsection
