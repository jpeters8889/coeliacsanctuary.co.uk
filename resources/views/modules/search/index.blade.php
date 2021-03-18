@extends('templates.page-single-column')

@section('primary-column')
    <div class="page-box min-h-map">
        <search-page term="{{ $term }}"></search-page>
    </div>
@endsection
