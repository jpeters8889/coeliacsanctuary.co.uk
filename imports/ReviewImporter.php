<?php

declare(strict_types=1);

namespace Imports;

use Coeliac\Common\Models\Image;
use Intervention\Image\ImageManager;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

class ReviewImporter extends Import
{
    public function handle()
    {
        /** @var ImageManager $imageManager */
        $imageManager = app(ImageManager::class);

        $seeds = $this->seedDatabase->table('reviews')->get();

        $bar = $this->command->makeProgressBar(count($seeds));
        $bar->start();

        foreach ($seeds as $seed) {
            try {
                if (Review::query()->where('slug', $seed->alias)->count() > 0) {
                    continue;
                }

                $oldWte = $this->seedDatabase->table('wheretoeat')->where('id', $seed->wteID)->first();
                $wteRow = WhereToEat::query()
                ->leftJoin('wheretoeat_towns', 'town_id', 'wheretoeat_towns.id')
                ->leftJoin('wheretoeat_counties', 'wheretoeat.county_id', 'wheretoeat_counties.id')
                ->where('wheretoeat_towns.legacy', $oldWte->town)
                ->where('wheretoeat.name', $oldWte->name)
                ->first(['wheretoeat.id', 'wheretoeat_counties.slug']);

                /** @var Review $review */
                $review = Review::query()->create([
                'wheretoeat_id' => $wteRow->id,
                'title' => stripslashes($seed->title),
                'slug' => stripslashes($seed->alias.'-'.$wteRow->slug),
                'legacy_slug' => $seed->alias,
                'body' => stripslashes($seed->review),
                'overall_rating' => $seed->overallRating,
                'knowledge_rating' => $seed->knowledgeRating,
                'presentation_taste_rating' => $seed->presTasteRating,
                'value_rating' => $seed->valueRating,
                'general_rating' => $seed->generalRating,
                'meta_tags' => stripslashes($seed->metaKW),
                'meta_description' => stripslashes($seed->metaDesc),
                'live' => $seed->live,
                'created_at' => $seed->created_at,
                'updated_at' => $seed->updated_at,
            ]);

                $imageAssociations = [];
                $imgSeeds = $this->seedDatabase->table('review_images')->where('revID', $seed->id)->get();

                foreach ($imgSeeds as $imgSeed) {
                    try {
                        $imageFilename = '/assets/images/reviews/'.$seed->alias.'/'.str_replace(' ', '%20', $imgSeed->image);

                        $imageManager->make('https://www.coeliacsanctuary.co.uk'.$imageFilename)
                        ->save($image = public_path('imports/'.$imgSeed->image));

                        switch ($imgSeed->type) {
                        case 'main':
                            $typeId = 2;
                            break;
                        case 'social':
                            $typeId = 3;
                            break;
                        default:
                            $typeId = 1;
                            break;
                    }

                        /** @var Image $newImage */
                        $newImage = Image::query()->create([
                        'file_name' => $this->uploadImage('reviews/'.$seed->alias, $image),
                        'directory' => 'reviews/'.$seed->alias,
                        'created_at' => $imgSeed->created_at,
                        'updated_at' => $imgSeed->updated_at,
                    ]);

                        $review->associateImage($newImage, $typeId);

                        $imageAssociations[$imageFilename] = $newImage->image_url;
                        unlink($image);
                    } catch (\Exception $e) {
                    }
                }

                $review->update([
                'body' => $this->formatHtml($review->body, $review->slug, $imageAssociations),
            ]);

                $bar->advance();
            } catch (\Exception $e) {
            }
        }

        $bar->finish();
    }
}
