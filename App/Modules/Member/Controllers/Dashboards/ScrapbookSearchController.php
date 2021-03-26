<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers\Dashboards;

use Illuminate\Http\Response;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Member\Requests\ScrapbookSearchRequest;

class ScrapbookSearchController extends BaseController
{
    public function __invoke(ScrapbookSearchRequest $request)
    {
        $item = $request->user()->scrapbookItems()
            ->where('item_type', $request->resolveItem())
            ->where('item_id', $request->input('id'))
            ->first();

        if (!$item) {
            return new Response('', 204);
        }

        return [
            'id' => $item->id,
            'scrapbook_id' => $item->scrapbook_id,
        ];
    }
}