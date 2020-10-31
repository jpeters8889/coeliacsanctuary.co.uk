@php
    $announcements = collect([]);
    $breadcrumbs = [
        'crumbs' => [
            [
                'link' => '/',
                'title' => 'Coeliac Sanctuary',
            ],
        ],
        'location' => 'Ooops',
    ];
    $page = json_decode(json_encode([
        'title' => 'Ooops',
        'metas' => [
            'description' => '',
            'keywords' => '',
        ],
        'url' => request()->url(),
        'social' => json_decode(json_encode([
            'facebook' => false,
            'twitter' => false,
        ]))
    ]));
    $tracking = false;
@endphp

@extends('templates.page-single-column')

@section('primary-column')
    <div class="flex flex-col">
        <div class="page-box">
            <div class="bg-blue-gradient-30 p-6 rounded-lg text-center">
                <h1 class="text-2xl">
                    @yield('title', 'Page not found')
                </h1>
                <p>
                    @yield('message', "Sorry, we can't find the page you're looking for...")
                </p>
            </div>
        </div>
    </div>
@endsection
