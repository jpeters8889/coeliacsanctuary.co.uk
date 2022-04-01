<?php

namespace Coeliac\Architect\Plans\WteOpeningTimes;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatOpeningTimes;
use Illuminate\Support\Collection;
use JPeters\Architect\Plans\Plan as ArchitectPlan;
use Illuminate\Database\Eloquent\Model;

class Plan extends ArchitectPlan
{
    public function vuePrefix(): string
    {
        return 'wte-opening-times';
    }

    public function getCurrentValue(Model $model)
    {
        /** @var WhereToEatOpeningTimes $openingTimes */
        $openingTimes = $model->openingTimes;

        if (!$openingTimes) {
            return null;
        }

        return (new Collection(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday']))
            ->mapWithKeys(fn($day) => [$day => $this->getOpeningTimesForDay($openingTimes, $day)]);
    }

    function getOpeningTimesForDay(WhereToEatOpeningTimes $openingTimes, string $day)
    {
        if (!$openingTimes->{$day . '_start'}) {
            return null;
        }

        return [
            $openingTimes->formatTime($day . '_start'),
            $openingTimes->formatTime($day . '_end'),
        ];
    }

    public function handleUpdate(Model $model, $column, $value, $index = null)
    {
        if (!$value) {
            return;
        }

        /** @var WhereToEat $model */
        $model->openingTimes()->updateOrCreate([], [
            'monday_start' => $value['monday'] ? "{$value['monday'][0][0]}:{$value['monday'][0][1]}:0" : null,
            'monday_end' => $value['monday'] ? "{$value['monday'][1][0]}:{$value['monday'][1][1]}:0" : null,
            'tuesday_start' => $value['tuesday'] ? "{$value['tuesday'][0][0]}:{$value['tuesday'][0][1]}:0" : null,
            'tuesday_end' => $value['tuesday'] ? "{$value['tuesday'][1][0]}:{$value['tuesday'][1][1]}:0" : null,
            'wednesday_start' => $value['wednesday'] ? "{$value['wednesday'][0][0]}:{$value['wednesday'][0][1]}:0" : null,
            'wednesday_end' => $value['wednesday'] ? "{$value['wednesday'][1][0]}:{$value['wednesday'][1][1]}:0" : null,
            'thursday_start' => $value['thursday'] ? "{$value['thursday'][0][0]}:{$value['thursday'][0][1]}:0" : null,
            'thursday_end' => $value['thursday'] ? "{$value['thursday'][1][0]}:{$value['thursday'][1][1]}:0" : null,
            'friday_start' => $value['friday'] ? "{$value['friday'][0][0]}:{$value['friday'][0][1]}:0" : null,
            'friday_end' => $value['friday'] ? "{$value['friday'][1][0]}:{$value['friday'][1][1]}:0" : null,
            'saturday_start' => $value['saturday'] ? "{$value['saturday'][0][0]}:{$value['saturday'][0][1]}:0" : null,
            'saturday_end' => $value['saturday'] ? "{$value['saturday'][1][0]}:{$value['saturday'][1][1]}:0" : null,
            'sunday_start' => $value['sunday'] ? "{$value['sunday'][0][0]}:{$value['sunday'][0][1]}:0" : null,
            'sunday_end' => $value['sunday'] ? "{$value['sunday'][1][0]}:{$value['sunday'][1][1]}:0" : null,
        ]);
    }
}
