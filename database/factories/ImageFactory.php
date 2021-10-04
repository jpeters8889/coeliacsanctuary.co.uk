<?php

namespace Database\Factories;

use Coeliac\Common\Models\Image;
use Illuminate\Support\Str;

class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition()
    {
        return [
            'file_name' => Str::random(),
            'directory' => '',
        ];
    }
}
