<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe\Architect;

use JPeters\Architect\Plans\Group;
use JPeters\Architect\Plans\Boolean;
use JPeters\Architect\Plans\DateTime;
use JPeters\Architect\Plans\Textarea;
use JPeters\Architect\Plans\Textfield;
use Coeliac\Modules\Recipe\Models\Recipe;
use Illuminate\Database\Eloquent\Builder;
use Coeliac\Modules\Recipe\Models\RecipeMeal;
use Coeliac\Modules\Recipe\Models\RecipeFeature;
use Coeliac\Modules\Recipe\Models\RecipeAllergen;
use Coeliac\Architect\Plans\ImageManager\Plan as ImageManager;
use JPeters\Architect\Blueprints\Blueprint as ArchitectBlueprint;

class Blueprint extends ArchitectBlueprint
{
    public function model(): string
    {
        return Recipe::class;
    }

    public function getData(): Builder
    {
        return parent::getData()->addSelect(['*'])->with(['images']);
    }

    public function plans(): array
    {
        return [
            Textfield::generate('title'),

            Textfield::generate('search_tags')->hideOnIndex(),

            Textfield::generate('meta_tags')->hideOnIndex(),

            Textarea::generate('meta_description')
                ->hideFromIndexOnMobile()
                ->rows(2),

            Textarea::generate('description', 'Introduction')
                ->hideOnIndex()
                ->rows(4),

            Boolean::generate('live', 'Published'),

            Textfield::generate('author')->hideOnIndex(),

            Textfield::generate('prep_time')->hideOnIndex(),

            Textfield::generate('cook_time')->hideOnIndex(),

            ImageManager::generate('Images')
                ->enableImageInserts('architect_body')
                ->hideOnIndex(),

            Textarea::generate('architect_ingredients', 'Ingredients')
                ->hideOnIndex()
                ->rows(15),

            Textarea::generate('architect_body', 'Method')
                ->hideOnIndex()
                ->rows(25),

            Textfield::generate('serving_size')->hideOnIndex(),

            Textfield::generate('per', 'Nutrition per...')->hideOnIndex(),

            Group::generate('nutrition', 'Nutritional Information')
                ->hideOnIndex()
                ->setRelationship('nutrition')
                ->plans($this->getNutritionPlans()),

            Group::generate('allergens', 'Free From')
                ->hideOnIndex()
                ->setPivotRelationship('allergens')
                ->wrapPlans()
                ->plans($this->getAllergensPlans()),

            Textfield::generate('df_to_not_df', 'DF to not DF')->hideOnIndex(),

            Group::generate('meals')
                ->hideOnIndex()
                ->setPivotRelationship('meals')
                ->wrapPlans()
                ->plans($this->getMealPlans()),

            Group::generate('features')
                ->hideOnIndex()
                ->setPivotRelationship('features')
                ->wrapPlans()
                ->plans($this->getFeaturePlans()),

            DateTime::generate('created_at')->hideOnForms(),
        ];
    }

    private function getNutritionPlans(): array
    {
        return [
            Textfield::generate('calories'),
            Textfield::generate('carbs'),
            Textfield::generate('fat'),
            Textfield::generate('protein'),
            Textfield::generate('fibre'),
            Textfield::generate('sugar'),
        ];
    }

    private function getAllergensPlans(): array
    {
        return RecipeAllergen::query()
            ->get()
            ->transform(static function (RecipeAllergen $allergen) {
                return Boolean::generate($allergen->id, $allergen->allergen)->setDefault('1');
            })
            ->toArray();
    }

    private function getMealPlans(): array
    {
        return RecipeMeal::query()
            ->get()
            ->transform(static function (RecipeMeal $meal) {
                return Boolean::generate($meal->id, $meal->meal);
            })
            ->toArray();
    }

    private function getFeaturePlans(): array
    {
        return RecipeFeature::query()
            ->get()
            ->transform(static function (RecipeFeature $feature) {
                return Boolean::generate($feature->id, $feature->feature);
            })
            ->toArray();
    }

    public function filters(): array
    {
        return [
            'live' => [
                'name' => 'Published',
                'options' => [
                    1 => 'Yes',
                    0 => 'No',
                ],
                'filter' => fn (Builder $builder, $value) => $builder->where('live', $value),
            ],
        ];
    }
}
