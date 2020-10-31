<?php

declare(strict_types=1);

namespace Imports;

use Coeliac\Common\Models\Image;
use Intervention\Image\ImageManager;
use Coeliac\Modules\Recipe\Models\Recipe;
use Coeliac\Modules\Recipe\Models\RecipeMeal;
use Coeliac\Modules\Recipe\Models\RecipeFeature;
use Coeliac\Modules\Recipe\Models\RecipeAllergen;

class RecipeImport extends Import
{
    public function handle()
    {
        /** @var ImageManager $imageManager */
        $imageManager = app(ImageManager::class);

        $seeds = $this->seedDatabase->table('recipes')->get();

        $bar = $this->command->makeProgressBar(count($seeds));
        $bar->start();

        foreach ($seeds as $seed) {
            try {
                if (Recipe::query()->where('slug', $seed->alias)->count() > 0) {
                    continue;
                }

                $nutrition = json_decode($seed->nutrition);
                $allergens = json_decode($seed->allergens);
                $meals = json_decode($seed->meals);
                $features = json_decode($seed->features);

                /** @var Recipe $recipe */
                $recipe = Recipe::query()->create([
                    'title' => stripslashes($seed->title),
                    'slug' => $seed->alias,
                    'meta_tags' => stripslashes($seed->metaTags),
                    'meta_description' => stripslashes($seed->metaDesc),
                    'description' => stripslashes($seed->longDesc),
                    'ingredients' => stripslashes($seed->ingredients),
                    'method' => stripslashes($seed->method),
                    'author' => $seed->author,
                    'serving_size' => $seed->servingSize,
                    'per' => $seed->per,
                    'search_tags' => stripslashes($seed->searchTags),
                    'df_to_not_df' => stripslashes($seed->DFtoNotDF) ?? '',
                    'prep_time' => $seed->prepTime,
                    'cook_time' => $seed->cookingTime,
                    'live' => $seed->live,
                    'created_at' => $seed->created_at,
                    'updated_at' => $seed->updated_at,
                ]);

                $imageAssociations = [];

                $imgSeeds = $this->seedDatabase->table('recipe_images')->where('recipeID', $seed->id)->get();

                foreach ($imgSeeds as $imgSeed) {
                    try {
                        $imageFilename = '/assets/images/recipes/'.$seed->alias.'/'.str_replace(' ', '%20', $imgSeed->image);

                        $imageManager->make('https://www.coeliacsanctuary.co.uk'.$imageFilename)
                            ->save($image = public_path('imports/'.$imgSeed->image));

                        switch ($imgSeed->type) {
                            case 'main':
                                $typeId = 2;
                                break;
                            case 'social':
                                $typeId = 3;
                                break;
                            case 'square':
                                $typeId = 4;
                                break;
                            default:
                                $typeId = 1;
                                break;
                        }

                        /** @var Image $newImage */
                        $newImage = Image::query()->create([
                            'file_name' => $this->uploadImage('recipes/'.$seed->alias, $image),
                            'directory' => 'recipes/'.$seed->alias,
                            'created_at' => $imgSeed->created_at,
                            'updated_at' => $imgSeed->updated_at,
                        ]);

                        $recipe->associateImage($newImage, $typeId);

                        $imageAssociations[$imageFilename] = $newImage->image_url;
                        unlink($image);
                    } catch (\Exception $e) {
                    }
                }

                $recipe->nutrition()->create([
                    'calories' => $seed->calories,
                    'carbs' => $nutrition->carbs,
                    'fat' => $nutrition->fat,
                    'protein' => $nutrition->protein,
                    'fibre' => $nutrition->fibre,
                    'sugar' => $nutrition->sugar,
                    'created_at' => $seed->created_at,
                    'updated_at' => $seed->updated_at,
                ]);

                foreach ($allergens as $allergen => $value) {
                    if ($value) {
                        $recipe->allergens()->attach($this->findInArray(RecipeAllergen::class, 'allergen', $allergen));
                    }
                }

                foreach ($meals as $meal => $value) {
                    if ($value) {
                        $recipe->meals()->attach($this->findInArray(RecipeMeal::class, 'meal', $meal));
                    }
                }

                foreach ($features as $feature => $value) {
                    if ($value) {
                        $recipe->features()->attach($this->findInArray(RecipeFeature::class, 'feature', $feature));
                    }
                }

                $recipe->update([
                    'method' => $this->formatHtml($recipe->method, $recipe->slug, $imageAssociations),
                ]);

                $bar->advance();
            } catch (\Exception $e) {
            }
        }

        $bar->finish();
    }
}
