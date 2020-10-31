<?php

declare(strict_types=1);

namespace Imports;

use Carbon\Carbon;
use Coeliac\Common\Models\Image;
use Intervention\Image\ImageManager;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopCategory;

class ShopProductImport extends Import
{
    public function handle()
    {
        /** @var ImageManager $imageManager */
        $imageManager = app(ImageManager::class);

        $shippingMethods = [
            'small' => 1,
            'letter' => 2,
            'large' => 3,
            'smallParcel' => 4,
            'parcel' => 5,
            'largeParcel' => 6,
        ];

        $seeds = $this->shopDatabase->table('products')->whereNull('linkTo')->get();

        $bar = $this->command->makeProgressBar(count($seeds));
        $bar->start();

        foreach ($seeds as $seed) {
            /** @var ShopProduct $product */
            $product = ShopProduct::query()->create([
                'title' => $seed->title,
                'pinned' => $seed->pinned,
                'meta_description' => $seed->metaDesc,
                'meta_keywords' => $seed->metaKw,
                'slug' => $seed->alias,
                'shipping_method_id' => $shippingMethods[$seed->shipAs],
                'created_at' => $seed->created_at,
                'updated_at' => $seed->updated_at,
                'description' => stripslashes($seed->desc),
                'long_description' => stripslashes($seed->longDesc),
            ]);

            $product->variants()->create([
                'live' => $seed->live,
                'title' => $seed->size ?? '',
                'weight' => $seed->weight,
                'quantity' => $seed->quantity,
                'created_at' => $seed->created_at,
                'updated_at' => $seed->updated_at,
            ]);

            $sale = false;
            if ($seed->oldPrice !== '') {
                $sale = true;
            }

            $product->prices()->create([
                'price' => $seed->price * 100,
                'start_at' => Carbon::now()->subHour(),
                'created_at' => $seed->created_at,
                'updated_at' => $seed->updated_at,
                'sale_price' => $sale,
            ]);

            //sale price
            if ($sale) {
                $product->prices()->create([
                    'price' => $seed->oldPrice * 100,
                    'start_at' => \Carbon\Carbon::now()->subHour(),
                    'created_at' => $seed->created_at,
                    'updated_at' => $seed->updated_at,
                ]);
            }

            $imageSeeds = $this->shopDatabase->table('prods_pics')->where('prodID', $seed->id)->get();

            foreach ($imageSeeds as $imgSeed) {
                try {
                    $imageManager->make('https://www.coeliacsanctuary.co.uk/shop/assets/products/'.$seed->alias.'/'.$imgSeed->photo)
                        ->save($image = public_path('/imports/'.$imgSeed->photo));

                    $product->associateImage(Image::query()->create([
                        'file_name' => $this->uploadImage('products/'.$seed->alias, $image),
                        'directory' => 'products/'.$seed->alias,
                        'created_at' => $imgSeed->created_at,
                        'updated_at' => $imgSeed->updated_at,
                    ]), Image::IMAGE_CATEGORY_SHOP_PRODUCT);

                    unlink($image);
                } catch (\Exception $e) {
                }
            }

            $cats = explode(',', $seed->cat);

            foreach ($cats as $cat) {
                $oldCat = $this->shopDatabase->table('cats')->where('id', $cat)->first();

                ShopCategory::query()
                    ->where('title', $oldCat->title)
                    ->where('slug', $oldCat->alias)
                    ->first()
                    ->products()
                    ->attach($product);
            }

            $bar->advance();
        }

        $bar->finish();

        $variants = $this->shopDatabase->table('products')->whereNotNull('linkTo')->get();

        $this->command->info('Onto the variants...');

        $bar = $this->command->makeProgressBar(count($variants));
        $bar->start();

        foreach ($variants as $seed) {
            $oldProduct = $this->shopDatabase->table('products')->where('id', $seed->linkTo)->first();

            ShopProduct::query()
                ->where('title', $oldProduct->title)
                ->where('slug', $oldProduct->alias)
                ->first()
                ->variants()
                ->create([
                    'live' => $seed->live,
                    'title' => $seed->size,
                    'weight' => $seed->weight,
                    'quantity' => $seed->quantity,
                    'created_at' => $seed->created_at,
                    'updated_at' => $seed->updated_at,
                ]);

            $bar->advance();
        }

        $bar->finish();
    }
}
