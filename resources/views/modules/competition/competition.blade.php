@extends('templates.page-single-column')

@section('primary-column')
    <div class="flex flex-col">
        <div class="page-box p-3">
            <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
                {{ $competition->name }}
            </h1>
        </div>

        <div class="page-box p-3 mt-4">
            <article>
                {!! $competition->description !!}

                @if($competition->isOpenForEntries())
                    <a href="#enter-competition"
                       class="block text-black hover:no-underline my-2 p-2 bg-blue-50 rounded-lg border border-blue text-center text-large font-semibold">
                        Enter our fantastic competition below!
                    </a>
                @endif
            </article>
        </div>

        <div class="page-box mt-4">
            <img src="{{ $competition->first_image }}"
                 alt="{{ $competition->name }}" width="100%" loading="lazy"/>
        </div>

        <div class="page-box mt-4" id="enter-competition">
            @if(!$competition->isOpenForEntries())
                <p>
                    Sorry, but this competition has ended, keep checking for our next amazing competition!
                </p>
            @else
                <competition uuid="{{ $competition->uuid }}"
                    :facebook-like="{{ $competition->enable_facebook_like }}"
                    :facebook-share="{{ $competition->enable_facebook_share }}"
                    :twitter-follow="{{ $competition->enable_twitter_follow }}"
                    :twitter-tweet="{{ $competition->enable_twitter_tweet }}"
                    :shop-purchase="{{ $competition->enable_shop_purchase }}"
                ></competition>
            @endif
        </div>
    </div>
@endsection
