@extends('templates.page-single-column')

@section('primary-column')
    <div class="page-box min-h-map">
        <site-search term="{{ $term }}"></site-search>
    </div>
@endsection
