<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe\Models;

use Carbon\Carbon;
use Coeliac\Base\Models\BaseModel;
use Coeliac\Common\Comments\Commentable;
use Coeliac\Common\Contracts\HasComments;
use Coeliac\Common\Traits\ArchitectModel;
use Coeliac\Common\Traits\ClearsCache;
use Coeliac\Common\Traits\DisplaysImages;
use Coeliac\Common\Traits\HasRichText;
use Coeliac\Common\Traits\Imageable;
use Coeliac\Common\Traits\Linkable;
use Coeliac\Modules\Collection\Traits\IsCollectionItem;
use Coeliac\Modules\Member\Traits\CanBeAddedToScrapbook;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

/**
 * @extends BaseModel<Recipe>
 *
 * @property Carbon $created_at
 * @property Collection<RecipeAllergen> $allergens
 * @property mixed $live
 * @property mixed $title
 * @property mixed $author
 * @property mixed $meta_description
 * @property mixed $prep_time
 * @property mixed $cook_time
 * @property mixed $serving_size
 * @property RecipeNutrition $nutrition
 * @property mixed $ingredients
 * @property mixed $body
 * @property mixed $meta_tags
 * @property Collection<RecipeFeature> $features
 * @property string $method
 * @property string $description
 * @property string $link
 * @property int $id
 * @property Collection $meals
 * @property string $meta_keywords
 * @property string $legacy_slug
 * @property string $slug
 *
 * @method transform(array $array)
 */
class Recipe extends BaseModel implements HasComments
{
    use ArchitectModel;
    use CanBeAddedToScrapbook;
    use ClearsCache;
    use Commentable;
    use DisplaysImages;
    use HasRichText;
    use Imageable;
    use IsCollectionItem;
    use Linkable;
    use Searchable;

    protected function linkRoot(): string
    {
        return 'recipe';
    }

    protected $appends = ['main_image', 'square_image'];

    protected $hidden = ['images'];

    public function allergens(): BelongsToMany
    {
        return $this->belongsToMany(
            RecipeAllergen::class,
            'recipe_assigned_allergens',
            'recipe_id',
            'allergen_type_id'
        )->withTimestamps();
    }

    public function containsAllergens(): EloquentCollection
    {
        return RecipeAllergen::query()
            ->get()
            ->reject(fn (RecipeAllergen $allergen) => $this->allergens->where('allergen', $allergen->allergen)->count() > 0);
    }

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(
            RecipeFeature::class,
            'recipe_assigned_features',
            'recipe_id',
            'feature_type_id'
        )->withTimestamps();
    }

    public function meals(): BelongsToMany
    {
        return $this->belongsToMany(
            RecipeMeal::class,
            'recipe_assigned_meals',
            'recipe_id',
            'meal_type_id'
        )->withTimestamps();
    }

    public function nutrition(): HasOne
    {
        return $this->hasOne(RecipeNutrition::class)->latest();
    }

    public function toSearchableArray(): array
    {
        return $this->transform([
            'title' => $this->title,
            'description' => $this->description,
            'ingredients' => $this->ingredients,
            'metaTags' => $this->meta_tags,
            'freefrom' => $this->allergens()->get()->transform(static function ($allergen) {
                return $allergen->allergen;
            })->join(', '),
            'features' => $this->features()->get()->transform(static function ($feature) {
                return $feature->feature;
            })->join(', '),
        ]);
    }

    public function shouldBeSearchable(): bool
    {
        return (bool)$this->live;
    }

    public function getScoutKey(): mixed
    {
        return $this->id;
    }

    protected static function bodyField(): string
    {
        return 'method';
    }

    public function getArchitectIngredientsAttribute(): string
    {
        return cs_br2nl($this->ingredients);
    }

    public function setArchitectIngredientsAttribute(string $value): void
    {
        $this->ingredients = cs_nl2br($value);
    }

    protected function richTextType(): string
    {
        return 'Recipe';
    }

    protected function toRichText(): array
    {
        return [
            'name' => $this->title,
            'image' => $this->main_image,
            'author' => [
                '@type' => 'Person',
                'name' => $this->author,
            ],
            'datePublished' => $this->created_at->format('Y-m-d'),
            'description' => $this->meta_description,
            'prepTime' => $this->formatTimeToIso($this->prep_time),
            'cookTime' => $this->formatTimeToIso($this->cook_time),
            'recipeYield' => $this->serving_size,
            'nutrition' => [
                '@type' => 'NutritionInformation',
                'calories' => $this->nutrition->calories,
                'carbohydrateContent' => $this->nutrition->carbs,
                'fatContent' => $this->nutrition->fat,
                'proteinContent' => $this->nutrition->protein,
                'sugarContent' => $this->nutrition->sugar,
                'fiberContent' => $this->nutrition->fibre,
            ],
            'recipeIngredient' => Str::explodeIntoCollection($this->ingredients, '<br />'),
            'recipeInstructions' => Str::explodeIntoCollection($this->method, '<br /><br />'),
            'suitableForDiet' => $this->richTextSuitableFor(),
            'averageRating' => '',
            'keywords' => $this->meta_tags,
            'recipeCategory' => 'Gluten Free',
            'recipeCuisine' => '',
            'video' => '',
        ];
    }

    protected function richTextSuitableFor(): array
    {
        $suitableFor = ['GlutenFreeDiet'];

        if (! $this->allergens->contains('Dairy')) {
            $suitableFor[] = 'LowLactoseDiet';
        }

        if ($this->nutrition->calories < 400) {
            $suitableFor[] = 'LowCalorieDiet';
        }

        if ($this->features->contains('Vegan')) {
            $suitableFor[] = 'VeganDiet';
        }

        if ($this->features->contains('Vegetarian')) {
            $suitableFor[] = 'VegetarianDiet';
        }

        return $suitableFor;
    }

    protected static function usesImages(): bool
    {
        return true;
    }

    protected function cacheKey(): string
    {
        return 'recipes';
    }
}
