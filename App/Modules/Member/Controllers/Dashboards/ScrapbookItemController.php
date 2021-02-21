<?php

namespace Coeliac\Modules\Member\Controllers\Dashboards;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Member\Models\Scrapbook;
use Coeliac\Modules\Member\Models\ScrapbookItem;
use Coeliac\Modules\Member\Requests\ScrapbookAddItemRequest;
use Illuminate\Contracts\Auth\Access\Gate;

class ScrapbookItemController extends BaseController
{
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
