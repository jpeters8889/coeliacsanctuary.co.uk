@extends('mailables.mjml.layouts.coeliac')

@section('main-content')
    <mj-section>
        <mj-column>
            <mj-text mj-class="inner" padding-bottom="10px">
                <h2>Your Daily Update</h2>
            </mj-text>
            <mj-text mj-class="inner">Hi {{ $notifiable->name }}</mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
            <mj-text mj-class="inner">
                We've added some new content to Coeliac Sanctuary since you last visited, here's a roundup of everything
                that you're subscribed to in your daily update!
            </mj-text>
            <mj-text mj-class="inner">&nbsp;</mj-text>
        </mj-column>
    </mj-section>

    @if($updates->get('blogs'))
        <mj-section>
            <mj-colum>
                <mj-text mj-class="inner" padding-bottom="10px">
                    <h2>Coeliac Sanctuary Blogs</h2>
                </mj-text>

                <mj-text mj-class="inner">
                    Here's the latest blogs added that match your the tags you're subscribed to.
                </mj-text>
                <mj-text mj-class="inner">&nbsp;</mj-text>
                <mj-text mj-class="inner">
                    We've added blogs that are tagged with:
                    <strong>{{ $updates->get('blogs')->get('subscriptions')->join(', ')}}</strong>.
                </mj-text>
            </mj-colum>
        </mj-section>

        @foreach($updates->get('blogs')->get('items') as $item)
            <mj-section>
                <mj-column width="30%">
                    <mj-image padding-right="10px" padding-bottom="5px" width="0" src="{{ $item['image'] }}"></mj-image>
                </mj-column>
                <mj-column width="70%">
                    <mj-text>
                        <a href="{{ $item['link'] }}">{{ $item['title'] }}</a>
                    </mj-text>
                    <mj-text>
                        {!! $item['description'] !!}
                    </mj-text>
                </mj-column>
            </mj-section>
        @endforeach
    @endif

    @if($updates->get('eateries'))
        <mj-section>
            <mj-colum>
                <mj-text mj-class="inner" padding-bottom="10px">
                    <h2>Places To Eat</h2>
                </mj-text>

                <mj-text mj-class="inner">
                    Here's the latest places to eat added in areas that you're subscribed to, including:
                    <strong>{{ $updates->get('eateries')->get('subscriptions')->join(', ')}}</strong>.
                </mj-text>
            </mj-colum>
        </mj-section>

        @foreach($updates->get('eateries')->get('items') as $item)
            <mj-section>
                <mj-column>
                    <mj-text>
                        {{ $item['title'] }}<br/>
                        <a href="{{ $item['link'] }}">{{ $item['location'] }}</a>
                    </mj-text>
                    <mj-text>
                        {!! $item['description'] !!}
                    </mj-text>
                    <mj-text>{{ $item['address'] }}</mj-text>
                </mj-column>
            </mj-section>
        @endforeach
    @endif

@endsection

@section('footer')
    <mj-text align="center">
        This email was sent to {{ $notifiable->email }} because the Coeliac Website has been updated in areas you are
        subscribed to. You can <a href="{{ $managePreferences }}">change your preferences or unsubscribe</a> at any time.
    </mj-text>
@endsection
