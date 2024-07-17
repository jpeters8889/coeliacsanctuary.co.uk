@extends('templates.page-single-column')

@section('primary-column')
    <div class="flex flex-col mt-4">
        <div class="page-box">
            <table class="text-xs">
                <tr class="bg-blue-light bg-opacity-10">
                    <th class="border-r border-l border-blue p-1">Found Result</th>
                    <th class="border-r border-blue p-1">WTE ID</th>
                    <th class="border-r border-blue p-1">Name</th>
                    <th class="border-r border-blue p-1">Town</th>
                    <th class="border-r border-blue p-1">County</th>
                    <th class="border-r border-blue p-1">Country</th>
                    <th class="border-r border-blue p-1">Live</th>
                </tr>

                @foreach($items as $row)
                    <tr @if($row->get('error')) class="bg-yellow bg-opacity-50" @else class="border-b border-blue" @endif>
                        <td class="align-top border-r border-l border-blue p-1 bg-opacity-30 @if($row->get('exists')) bg-green @else bg-red @endif">
                            {{ $row->get('exists') ? 'Yes' : 'No' }}
                        </td>
                        <td class="align-top border-r border-l border-blue p-1">{{ $row->get('wheretoeat_id') }}</td>
                        <td class="align-top border-r border-blue p-1">{{ $row->get('name') }}</td>
                        <td class="align-top border-r border-blue p-1">{{ $row->get('town')['name'] }} </td>
                        <td class="align-top border-r border-blue p-1">{{ $row->get('county')['name'] }}</td>
                        <td class="align-top border-r border-blue p-1">{{ $row->get('country')['name'] }}</td>
                        <td class="align-top border-r border-blue p-1 bg-opacity-30 @if($row->get('exists') && $row->get('live') === 0) bg-red text-red font-semibold @endif">
                            {{ $row->get('exists') && $row->get('live') === 0 ? 'No' : '' }}
                        </td>
                    </tr>
                    @if($row->get('error'))
                        <tr class="bg-yellow bg-opacity-50 border-b border-blue">
                            <td colspan="7" class="border-l border-r border-blue p-1">
                                {{ $row->get('message') }}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </table>

            <form class="flex flex-col space-y-4" method="post" action="/wte-csv-search/process/download"
                  enctype="multipart/form-data"
            >
                @csrf
                <input type="hidden" name="collection" value="{{ $items->toJson() }}"/>

                <button class="py-4 px-8 text-lg bg-blue rounded">
                    Download
                </button>
            </form>
        </div>
    </div>
@endsection
