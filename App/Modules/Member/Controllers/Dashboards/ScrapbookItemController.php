<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers\Dashboards;

use Illuminate\Contracts\Auth\Access\Gate;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Member\Models\Scrapbook;
use Coeliac\Modules\Member\Models\ScrapbookItem;
use Coeliac\Modules\Member\Requests\ScrapbookAddItemRequest;

class ScrapbookItemController extends BaseController
{
    public function list(Gate $gate, Scrapbook $scrapbook)
    {
        $gate->authorize('manage-scrapbook', $scrapbook);

        return $scrapbook->items()
            ->latest()
            ->get()
            ->transform(fn (ScrapbookItem $item) => [
                'id' => $item->id,
                'added' => $item->created_at,
                'item' => [
                    'area' => class_basename($item->item),
                    'title' => $item->item->title,
                    'image' => $item->item->main_image,
                    'description' => $item->item->meta_description,
                    'link' => $item->item->link,
                ],
            ]);
    }

    public function create(ScrapbookAddItemRequest $request, Scrapbook $scrapbook)
    {
        $request->resolveItem()->addToScrapbook($scrapbook);
    }

    public function delete(Gate $gate, Scrapbook $scrapbook, ScrapbookItem $item)
    {
        $gate->authorize('manage-scrapbook', $scrapbook);

        $item->delete();
    }
}
