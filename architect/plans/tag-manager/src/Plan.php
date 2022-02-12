<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\TagManager;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Coeliac\Modules\Blog\Models\BlogTag;
use JPeters\Architect\Plans\Plan as ArchitectPlan;

class Plan extends ArchitectPlan
{
    protected $tagSource;

    public bool $deferUpdate = true;

    public function vuePrefix(): string
    {
        return 'tag-manager';
    }

    public function getCurrentValue(Model $model)
    {
        $column = $this->getColumn();

        switch ($column) {
            case 'blog_tags':
                $tagInfo = [
                    'model' => BlogTag::class,
                    'column' => 'tag',
                    'relationship' => 'tags',
                ];
                break;
            default:
                throw new Exception('Unknown tags');
        }

        return $model
            ->{$tagInfo['relationship']}()
            ->get()
            ->transform(static function (Model $model) use ($tagInfo) {
                return $model->{$tagInfo['column']};
            })
            ->implode(',');
    }

    public function handleUpdate(Model $model, $column, $value, $index = null)
    {
        switch ($column) {
            case 'blog_tags':
                $tagInfo = [
                    'model' => BlogTag::class,
                    'column' => 'tag',
                    'relationship' => 'tags',
                ];
                break;
            default:
                throw new Exception('Unknown tags');
        }

        $model->{$tagInfo['relationship']}()->delete();

        Str::explodeIntoCollection($value)->each(static function ($tag) use ($model, $tagInfo) {
            /** @var Model $tagModel */
            $tagRow = $tagInfo['model']::query()
                ->firstOrCreate(
                    [$tagInfo['column'] => $tag],
                    ['slug' => Str::slug($tag)]
                );

            $model->{$tagInfo['relationship']}()->attach($tagRow);
        });
    }

    public function useTagSource($tagSource)
    {
        $this->tagSource = $tagSource;

        return $this;
    }

    public function getMetas(): array
    {
        return array_merge(parent::getMetas() ?? [], [
            'tagSource' => $this->tagSource,
        ]);
    }
}
