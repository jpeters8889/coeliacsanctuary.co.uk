@extends('templates.page-single-column')

@section('primary-column')
    <div class="flex flex-col mt-4">
        <div class="page-box">
            Import Complete

            <ul>
                <li>Total Items Sent: {{ $total }}</li>
                <li>Total Items Rejected (Import not valid): {{ $rejected }}</li>
                <li>Total Items Processed: {{ $processed }}</li>
                <li>Places Added: {{ $added }}</li>
                <li>Failures: {{ $failed }}</li>
            </ul>

            @if($failed > 0)
                Failures:<br/><br/>

                <ul class="flex flex-col space-y-2 text-xs">
                    @foreach($errors as $name => $message)
                        <li><span class="font-semibold">{{ $name }}</span> - {{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@endsection
