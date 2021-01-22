@extends('templates.page-single-column')

@section('primary-column')
    <div class="flex flex-col flex-1"chunk>
        <contact-trigger :open="true" redirect="/"></contact-trigger>
    </div>
@endsection
