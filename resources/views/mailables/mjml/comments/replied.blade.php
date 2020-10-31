@extends('mailables.mjml.layouts.coeliac')

@section('main-content')
    <mj-section>
        <mj-column>
            <mj-text mj-class="inner" padding-bottom="10px">
                <h2>Your comment has had a reply!</h2>
            </mj-text>
            <mj-text mj-class="inner">Hi {{ $comment->name }}</mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-text mj-class="inner">Thank you for leaving a comment on our {{ $comment->what }}, {{ $comment->commentable->title }}</mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-text mj-class="inner">We have replied to your comment, our reply is...</mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-text mj-class="inner">{{ $reply->comment_reply }}</mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-button href="{{ config('app.url') }}{{ $comment->commentable->link }}">
                View {{ $comment->what }}
            </mj-button>
        </mj-column>
    </mj-section>
@endsection
