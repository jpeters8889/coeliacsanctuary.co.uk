<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers\Dashboards;

use Carbon\Carbon;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Member\Models\Scrapbook;
use Coeliac\Modules\Member\Models\ScrapbookItem;
use Coeliac\Modules\Member\Requests\ScrapbookAddItemRequest;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Support\Collection;

class ScrapbookItemController extends BaseController
{
    /** @return Collection<int, array{id: int, added: Carbon, item: array{area: string, title: string, image: string, description: string, link: string}}> */
    public function list(Gate $gate, Scrapbook $scrapbook): Collection
    {
        $gate->authorize('manage-scrapbook', $scrapbook);

        return $scrapbook->items()
            ->latest()
            ->get()
            ->map(fn (ScrapbookItem $item) => [
                'id' => $item->id,
                'added' => $item->created_at,
                'item' => [
                    'area' => class_basename($item->item),
                    'title' => (string) $item->item->getAttribute('title'),
                    'image' => (string) $item->item->getAttribute('main_image'),
                    'description' => (string) $item->item->getAttribute('meta_description'),
                    'link' => (string) $item->item->getAttribute('link'),
                ],
            ]);
    }

    public function create(ScrapbookAddItemRequest $request, Scrapbook $scrapbook): void
    {
        $request->resolveItem()->addToScrapbook($scrapbook);
    }

    public function delete(Gate $gate, Scrapbook $scrapbook, ScrapbookItem $item): void
    {
        $gate->authorize('manage-scrapbook', $scrapbook);

        $item->delete();
    }
}
