<?php

declare(strict_types=1);

namespace Imports;

use Coeliac\Common\Models\Image;
use Intervention\Image\ImageManager;
use Coeliac\Common\Models\FeaturedImage;

class FeaturedImagesImport extends Import
{
    public function handle()
    {
        $this->command->info('Importing Featured Images');

        /** @var ImageManager $imageManager */
        $imageManager = app(ImageManager::class);
        $seeds = $this->seedDatabase->table('featured_images')->get();

        $bar = $this->command->makeProgressBar(count($seeds));
        $bar->start();

        foreach ($seeds as $seed) {
            $imageManager->make('https://www.coeliacsanctuary.co.uk/assets/images/heros/'.$seed->mobileImg)->save($path2 = public_path('imports/'.$seed->mobileImg));

            FeaturedImage::query()->create([
                'title' => stripslashes($seed->title),
                'description' => stripslashes($seed->desc),
                'link' => $seed->link,
                'order' => $seed->order,
                'active' => $seed->active,
                'created_at' => $seed->created_at,
                'updated_at' => $seed->updated_at,
            ])
                ->associateImage(Image::query()->create([
                    'file_name' => $this->uploadImage('heros', $path2),
                    'directory' => 'heros',
                    'created_at' => $seed->created_at,
                    'updated_at' => $seed->updated_at,
                ]), Image::IMAGE_CATEGORY_HERO);

            unlink($path2);

            $bar->advance();
        }

        $bar->finish();
    }
}
