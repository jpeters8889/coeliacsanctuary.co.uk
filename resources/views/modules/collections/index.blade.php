@extends('templates.page')

@section('inner-content')
    {{--    <global-ui-google-ad code="7619961534"></google-ad>--}}

    <div class="page-box mb-3">
        <h1 class="my-4 mb-0 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
            Coeliac Sanctuary Collections
        </h1>
    </div>

    <module-list-index module="collection" title="Collections" url-prefix="collection" :show-filter-bar="false"/>

    {{--    <global-ui-google-ad code="6662103082"></google-ad>--}}
@endsection
