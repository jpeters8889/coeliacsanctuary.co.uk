<?php

declare(strict_types=1);

namespace Coeliac\Modules\Search\Indices;

use Algolia\ScoutExtended\Builder;
use Illuminate\Support\Str;
use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Collection;
use Laravel\Scout\Searchable;

abstract class Index
{
    protected string $term;

    public function __construct(string $term)
    {
        $this->term = $term;
    }

    abstract protected function model(): Builder|\Laravel\Scout\Builder;

    protected function withRelations(): array
    {
        return ['images', 'images.image'];
    }

    public function handle(): Collection
    {
        /** @phpstan-ignore-next-line  */
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
            'link' => method_exists($result, 'link') ? $result->link() : $result->getAttribute('link'),
            'title' => $result->getAttribute('title'),
            'description' => $result->getAttribute('meta_description'),
            'image' => $result->getAttribute('main_image') ?? $result->getAttribute('first_image'),
        ], $this->mergeIntoResult($result));
    }

    protected function resultType(): string
    {
        return Str::lower(Str::plural(class_basename($this)));
    }

    protected function mergeIntoResult(BaseModel $result): array
    {
        return [];
    }
}
