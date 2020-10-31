@extends('mailables.mjml.layouts.coeliac')

@section('main-content')
    <mj-section>
        <mj-column>
            <mj-text mj-class="inner" padding-bottom="10px">
                <h2>Your comment has been approved</h2>
            </mj-text>
            <mj-text mj-class="inner">Hi {{ $comment->name }}</mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-text mj-class="inner">Thank you for leaving a comment on our {{ $comment->what }}, {{ $comment->commentable->title }}</mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-text mj-class="inner">Your comment has been approved and is visible for everyone to see!</mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-button href="{{ config('app.url') }}{{ $comment->commentable->link }}">
                View {{ $comment->what }}
            </mj-button>
        </mj-column>
    </mj-section>
@endsection
