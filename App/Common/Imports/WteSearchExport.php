<?php

declare(strict_types=1);

namespace Coeliac\Common\Imports;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WteSearchExport implements FromCollection, WithHeadings
{
    use Exportable;

    public function __construct(protected Collection $collection)
    {
        //
    }

    public function collection()
    {
        return $this->collection;
    }

    public function headings(): array
    {
        return collect($this->collection->first())->keys()->map(fn(string $key) => Str::headline($key))->toArray();
    }
}
