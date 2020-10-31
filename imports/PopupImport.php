<?php

declare(strict_types=1);

namespace Imports;

use Coeliac\Common\Models\Image;
use Coeliac\Common\Models\Popup;
use Intervention\Image\ImageManager;

class PopupImport extends Import
{
    public function handle()
    {
        /** @var ImageManager $imageManager */
        $imageManager = app(ImageManager::class);

        $seeds = $this->seedDatabase->table('popup')->get();

        $bar = $this->command->makeProgressBar(count($seeds));
        $bar->start();

        foreach ($seeds as $seed) {
            $imageManager->make('https://www.coeliacsanctuary.co.uk/assets/images/popups/'.str_replace(' ', '%20', $seed->img))
                ->save($image = public_path('imports/'.$seed->img));

            Popup::query()->create([
                'text' => $seed->text,
                'link' => $seed->link,
                'display_every' => $seed->display_every,
                'live' => $seed->live,
                'created_at' => $seed->created_at,
                'updated_at' => $seed->updated_at,
            ])->associateImage(Image::query()->create([
                'file_name' => $this->uploadImage('popups', $image),
                'directory' => 'popups',
                'created_at' => $seed->created_at,
                'updated_at' => $seed->updated_at,
            ]), Image::IMAGE_CATEGORY_POPUP);

            unlink($image);

            $bar->advance();
        }

        $bar->finish();
    }
}
