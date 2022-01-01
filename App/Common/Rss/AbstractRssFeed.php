<?php

declare(strict_types=1);

namespace Coeliac\Common\Rss;

use Carbon\Carbon;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Collection;

abstract class AbstractRssFeed
{
    private Collection $items;
    private ResponseFactory $responseFactory;

    public function __construct(ResponseFactory $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    abstract protected function formatItem(Model $item): array;

    abstract protected function feedTitle(): string;

    abstract protected function linkRoot(): string;

    abstract protected function feedDescription(): string;

    protected function makeData(): array
    {
        $items = [];

        $this->items->each(function (Model $item) use (&$items) {
            $items[] = $this->formatItem($item);
        });

        $lastUpdated = $this->items->first() ? $this->items->first()->created_at : Carbon::now();

        return [
            'title' => $this->feedTitle(),
            'link' => Container::getInstance()->make(Repository::class)->get('app.url').'/'.$this->linkRoot(),
            'description' => $this->feedDescription(),
            'date' => $lastUpdated->toRfc822String(),
            'items' => $items,
        ];
    }

    public function render(Collection $items)
    {
        $this->items = $items;

        return $this->responseFactory->view('static.feed', $this->makeData())->content();
    }
}
