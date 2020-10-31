<?php

declare(strict_types=1);

namespace Imports;

use Coeliac\Common\Models\Image;
use Intervention\Image\ImageManager;
use Coeliac\Modules\Shop\Models\ShopCategory;

class ShopCategoryImport extends Import
{
    public function handle()
    {
        /** @var ImageManager $imageManager */
        $imageManager = app(ImageManager::class);

        $seeds = $this->shopDatabase->table('cats')->get();

        $bar = $this->command->makeProgressBar(count($seeds));

        foreach ($seeds as $seed) {
            /** @var ShopCategory $category */
            $category = ShopCategory::query()->create([
                'title' => $seed->title,
                'description' => $seed->desc,
                'slug' => $seed->alias,
                'meta_keywords' => $seed->metaKW,
                'meta_description' => $seed->metaDesc,
                'created_at' => $seed->created_at,
                'updated_at' => $seed->updated_at,
            ]);

            try {
                $imageManager->make('https://www.coeliacsanctuary.co.uk/shop/assets/cats/'.$seed->alias.'/'.$seed->img)
                    ->save($image = public_path('imports/'.$seed->img));

                $category->associateImage(Image::query()->create([
                    'file_name' => $this->uploadImage('categories/'.$seed->alias, $image),
                    'directory' => 'categories/'.$seed->alias,
                    'created_at' => $seed->created_at,
                    'updated_at' => $seed->updated_at,
                ]), Image::IMAGE_CATEGORY_SHOP_CATEGORY);

                unlink($image);
            } catch (\Exception $e) {
                $this->command->info($e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
    }
}
