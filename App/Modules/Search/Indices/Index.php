<?php

declare(strict_types=1);

namespace Coeliac\Modules\Search\Indices;

use Laravel\Scout\Builder;
use Illuminate\Support\Str;
use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Collection;

abstract class Index
{
    protected string $term;

    public function __construct(string $term)
    {
        $this->term = $term;
    }

    abstract protected function model(): Builder;

    protected function withRelations(): array
    {
        return ['images', 'images.image'];
    }

    public function handle(): Collection
    {
        $results = $this->model()
            ->with([
                'getRankingInfo' => true,
            ])
            ->get()
            ->load($this->withRelations());

        $results = $this->afterSearching($results);

        $results->transform(fn (BaseModel $result) => $this->transformResult($result));

        return $results;
    }

    protected function afterSearching(Collection $results): Collection
    {
        return $results;
    }

    protected function transformResult(BaseModel $result): array
    {
        return array_merge([
            'word' => $result->scoutMetadata()['_rankingInfo']['firstMatchedWord'] ?? 0,
            'score' => $result->scoutMetadata()['_rankingInfo']['userScore'] ?? 0,
            'type' => $this->resultType(),
            'id' => $result->getKey(),
            'link' => $result->link,
            'title' => $result->title,
            'description' => $result->meta_description,
            'image' => $result->main_image ?? $result->first_image,
        ], $this->mergeIntoResult($result));
    }

    protected function resultType()
    {
        return Str::lower(Str::plural(class_basename($this)));
    }

    protected function mergeIntoResult(BaseModel $result): array
    {
        return [];
    }
}
