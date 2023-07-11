<?php

namespace Coeliac\Architect\Plans\WteNationwideBranches;

use Coeliac\Modules\EatingOut\WhereToEat\Models\NationwideBranch;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Illuminate\Database\Eloquent\Builder;
use JPeters\Architect\Plans\BulkBlueprintVariants;
use Illuminate\Database\Eloquent\Model;

class Plan extends BulkBlueprintVariants
{
    protected string $addButtonLabel = 'Add Branch';

    public bool $deferUpdate = true;

    protected bool $hideIfEmpty = true;

    public function shouldAutomaticallyCreateModels(): bool
    {
        return false;
    }

    public function handleUpdate(Model $model, $column, $value, $index = null)
    {
        /* @var WhereToEat $model */

        $branches = json_decode($value, true);

        collect($branches)
            ->filter(fn ($branch) => isset($branch['town_id']))
            ->each(function ($branch, $branchIndex) use ($model) {
                /** @var Model<NationwideBranch> $branchModel */
                $branchModel = $model->branches()
                    ->when(
                        ((bool)$branch['id']) ?? false,
                        fn (Builder $query) => $query->findOrNew($branch['id']),
                        fn (Builder $query) => $query->newModelInstance()
                    );

                $branchModel->wheretoeat_id = $model->id;

                foreach ($this->plans as $plan) {
                    /* @var \JPeters\Architect\Plans\Plan $plan */
                    $plan->handleUpdate($branchModel, $plan->getColumn(), $branch[$plan->getColumn()], $branchIndex);
                }

                $branchModel->save();
            });
    }

    public function getCurrentValue(Model $model)
    {
        /* @var WhereToEat $model */
        return $model->branches()
            ->with('town')
            ->get()
            ->transform(fn (NationwideBranch $branch) => [
                'id' => $branch->id,
                'name' => $branch->name,
                'live' => $branch->live,
                'town_id' => $branch->town,
                'county_id' => $branch->county_id,
                'country_id' => $branch->country_id,
                'address' => [
                    'address' => cs_br2nl($branch->address),
                    'lat' => $branch->lat,
                    'lng' => $branch->lng,
                ],
            ]);
    }
}
