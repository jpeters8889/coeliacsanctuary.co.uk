@extends('templates.page-single-column')

@section('primary-column')
    <div class="flex flex-col flex-1" style="max-width: 1200px">
        <contact-trigger :open="true" redirect="/"></contact-trigger>
    </div>
@endsection
