<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class OpeningTime implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if(!$value) {
            return null;
        }

        dd('here');

        $bits = explode(':',$value);

        return [
            (int) $bits[0],
            (int) ($bits[1] ?? 0),
            (int) ($bits[2] ?? 0),
        ];
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if(!$value) {
            return null;
        }

        $value = explode(':', $value);

        $time = [
            $value[0],
            $value[1] ?? 0,
            $value[2] ?? 0,
        ];

        return implode(':', $time);
    }
}
