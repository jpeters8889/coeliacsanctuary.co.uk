<?php

namespace Coeliac\Common\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Imports\WteNationwideImport;
use Coeliac\Common\Response\Page;
use Coeliac\Modules\EatingOut\WhereToEat\Models\NationwideBranch;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WteImportController extends BaseController
{
    public function get(Page $page): Response
    {
        return $page
            ->noBreadcrumbs()
            ->setPageTitle('Wte Import')
            ->render('wte-import.get');
    }

    public function process(Request $request, Page $page): Response
    {
        $this->validate($request, ['csv' => ['required', 'mimes:csv,txt']]);

        $importer = new WteNationwideImport();

        $csv = $importer->toCollection($request->file('csv'));

        $results = $importer->collection($csv->first());

        return $page
            ->noBreadcrumbs()
            ->setPageTitle('Wte Import')
            ->render('wte-import.process', [
                'items' => $results,
            ]);
    }

    public function add(Request $request, Page $page): Response
    {
        $this->validate($request, ['collection' => 'required', 'json']);

        $items = collect(json_decode($request->input('collection'), true));

        $added = 0;
        $processed = 0;
        $errors = [];

        $items
            ->reject(fn($item) => $item['error'])
            ->each(function ($item) use (&$added, &$processed, &$errors) {
                $processed++;

                try {
                    if(data_get($item, 'town.id') === 'NEW') {
                        $town = WhereToEatTown::query()
                            ->firstOrCreate([
                                'town' => data_get($item, 'town.name'),
                                'county_id' => data_get($item, 'county.id'),
                            ]);

                        data_set($item, 'town.id', $town->id);
                    }

                    NationwideBranch::query()->create([
                        'wheretoeat_id' => data_get($item, 'wheretoeat_id'),
                        'name' => data_get($item, 'name'),
                        'country_id' => data_get($item, 'country.id'),
                        'county_id' => data_get($item, 'county.id'),
                        'town_id' => data_get($item, 'town.id'),
                        'address' => data_get($item, 'address.formatted'),
                        'lat' => data_get($item, 'lat'),
                        'lng' => data_get($item, 'lng'),
                        'live' => data_get($item, 'live'),
                    ]);

                    $added++;
                } catch(\Exception $exception) {
                    $errors[data_get($item, 'name')] = $exception->getMessage();
                }
            });

        return $page
            ->noBreadcrumbs()
            ->setPageTitle('Wte Import')
            ->render('wte-import.done', [
                'total' => $items->count(),
                'rejected' => $items->count() - $processed,
                'processed' => $processed,
                'added' => $added,
                'failed' => count($errors),
                'errors' => $errors,
            ]);
    }
}
