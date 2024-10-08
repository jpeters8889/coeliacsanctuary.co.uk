<?php

namespace Database\Factories;

use Carbon\Carbon;
use Coeliac\Common\Models\TemporaryFileUpload;

class TemporaryFileUploadFactory extends Factory
{
    protected $model = TemporaryFileUpload::class;

    public function definition()
    {
        return [
            'filename' => $name = $this->faker->word,
            'path' => $name,
            'source' => 'test',
            'filesize' => 1024,
            'mime' => $this->faker->mimeType(),
            'delete_at' => Carbon::now()->addDay(),
        ];
    }
}
