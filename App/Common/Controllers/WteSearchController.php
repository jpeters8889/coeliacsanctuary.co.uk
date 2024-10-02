<?php

namespace Coeliac\Common\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Imports\WteNationwideImport;
use Coeliac\Common\Imports\WteSearchExport;
use Coeliac\Common\Imports\WteSearchImport;
use Coeliac\Common\Response\Page;
use Coeliac\Modules\EatingOut\WhereToEat\Models\NationwideBranch;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class WteSearchController extends BaseController
{
    public function get(Page $page): Response
    {
        return $page
            ->noBreadcrumbs()
            ->setPageTitle('Wte Search')
            ->render('wte-search.get');
    }

    public function process(Request $request, Page $page): Response
    {
        $this->validate($request, ['csv' => ['required', 'mimes:csv,txt']]);

        $importer = new WteSearchImport();

        $csv = $importer->toCollection($request->file('csv'));

        $results = $importer->collection($csv->first());

        return $page
            ->noBreadcrumbs()
            ->setPageTitle('Wte Search')
            ->render('wte-search.process', [
                'items' => $results,
            ]);
    }

    public function download(Request $request): BinaryFileResponse
    {
        $this->validate($request, ['collection' => 'required', 'json']);

        $items = collect(json_decode($request->input('collection'), true))->map(fn(array $item) => [
            'Chip Shop' => Arr::get($item, 'name'),
            'Town' => Arr::get($item, 'town.name'),
            'County' => Arr::get($item, 'county.name'),
            'Country' => Arr::get($item, 'country.name'),
            'Exists' => Arr::get($item, 'exists') ? 'Yes' : 'No',
            'Is Live' => Arr::get($item, 'exists') && Arr::get($item, 'live') === 0 ? 'No' : '',
            'Found Error' => Arr::get($item, 'error') ? 'Yes' : 'No',
            'Error Message' => Arr::get($item, 'message')
        ]);

        return Excel::download(new WteSearchExport($items), 'results.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}
