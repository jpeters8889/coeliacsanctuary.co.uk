@extends('templates.page-single-column')

@section('primary-column')
    <div class="flex flex-col mt-4">
        <div class="page-box">
            <form class="flex flex-col space-y-4" method="post" action="/wte-csv-search/process" enctype="multipart/form-data">
                @csrf
                <div class="flex space-x-2">
                    <label class="flex font-semibold">CSV</label>
                    <input type="file" name="csv" accept="text/csv"/>
                </div>

                @error('csv')
                <div class="text-red font-semibold">{{ $message }}</div>
                @enderror

                <div>
                    <button type="submit" class="w-auto bg-blue px-4 py-2 rounded">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
