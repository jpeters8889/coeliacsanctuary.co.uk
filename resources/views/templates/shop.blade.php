@extends('templates.page')

@section('inner-content')
    <shop-basket-page-header-widget></shop-basket-page-header-widget>
    <shop-basket-ui-sidebar></shop-basket-ui-sidebar>

    <div class="flex flex-wrap flex-1">
        <div class="w-full lg:px-2">
            @yield('primary-column')
        </div>
    </div>

    <shop-basket-ui-floating-link></shop-basket-ui-floating-link>
@endsection
