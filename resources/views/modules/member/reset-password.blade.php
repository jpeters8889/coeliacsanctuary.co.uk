@extends('templates.page-single-column')

@section('primary-column')
    <div class="page-box p-2 py-8 mt-4">
        <member-reset-password-form token="{{ $token }}"></member-reset-password-form>
    </div>
@endsection
