<?php

declare(strict_types=1);

namespace Coeliac\Modules\Collection\Controllers;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Illuminate\Http\Request;
use Coeliac\Common\Response\Page;
use Coeliac\Modules\Collection\Items\Item;
use Coeliac\Modules\Collection\Repository;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Collection\Models\Collection;
use Coeliac\Modules\Collection\Models\CollectionItem;
use Coeliac\Modules\Collection\Requests\CollectionShowRequest;
use Illuminate\Http\Response;

class CollectionController extends BaseController
{
    public function __construct(private Page $page, private Repository $repository)
    {
    }

    public function index(): Response
    {
        return $this->page
            ->breadcrumbs([], 'Collections')
            ->setPageTitle('Collections')
            ->setMetaDescription('Coeliac Sanctuary Collections | Some of our favourite things, all grouped together in collections!')
            ->setSocialImage(asset('assets/images/shares/collection-list.jpg'))
            ->render('modules.collections.index');
    }

    public function list(Request $request): array
    {
        $this->validate($request, [
            'limit' => 'integer,max:50',
        ]);

        return [
            'data' => $this->repository
                ->setWithCounts(['items'])
                ->setColumns(['id', 'title', 'slug', 'long_description', 'meta_description', 'created_at'])
                ->paginated($request->get('limit', 12))
                ->through(function (Collection $collection) {
                    $collection->items->transform(function (CollectionItem $item) {
                        if ($item->item instanceof WhereToEat) {
                            return $item;
                        }

                        $item->load(['item.images', 'item.images.image']);

                        return $item;
                    });

                    return $collection;
                }),
        ];
    }

    public function show(CollectionShowRequest $request): Response
    {
        /* @var Collection $collection */
        abort_if(!$collection = $request->resolveItem(), 404, 'Sorry, this collection can\'t be found');

        $items = $collection
            ->items
            ->transform(fn (CollectionItem $item) => Item::resolve($item));

        return $this->page
            ->breadcrumbs([
                [
                    'link' => '/collection',
                    'title' => 'Collections',
                ],
            ], $collection->title)
            ->setPageTitle($collection->title . ' | Collections')
            ->setMetaDescription($collection->meta_description)
            ->setMetaKeywords(explode(',', (string)$collection->meta_keywords))
            ->setSocialImage($collection->social_image)
            ->render('modules.collections.show', compact('collection', 'items'));
    }
}
