<?php

declare(strict_types=1);

namespace Coeliac\Modules\Collection\Controllers;

use Illuminate\Http\Request;
use Coeliac\Common\Response\Page;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Collection\Items\Item;
use Coeliac\Modules\Collection\Repository;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Collection\Models\Collection;
use Coeliac\Modules\Collection\Models\CollectionItem;
use Coeliac\Modules\Blog\Repository as BlogRepository;
use Coeliac\Modules\Collection\Requests\CollectionShowRequest;

class CollectionController extends BaseController
{
    private Page $page;
    private Repository $repository;

    public function __construct(Page $page, Repository $repository)
    {
        $this->page = $page;
        $this->repository = $repository;
    }

    public function index()
    {
        return $this->page
            ->breadcrumbs([], 'Collections')
            ->setPageTitle('Collections')
            ->setMetaDescription('Coeliac Sanctuary Collections | Some of our favourite things, all grouped together in collections!')
            ->setSocialImage(asset('assets/images/shares/collection-list.jpg'))
            ->render('modules.collections.index');
    }

    public function list(Request $request)
    {
        $this->validate($request, [
            'limit' => 'integer,max:50',
        ]);

        return [
            'data' => $this->repository
                ->setWithCounts(['items'])
                ->setColumns(['id', 'title', 'slug', 'long_description', 'meta_description', 'created_at'])
                ->paginated($request->get('limit', 12)),
        ];
    }

    public function show(CollectionShowRequest $request)
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
            ->setPageTitle($collection->title.' | Collections')
            ->setMetaDescription($collection->meta_description)
            ->setMetaKeywords(explode(',', (string) $collection->meta_keywords))
            ->setSocialImage($collection->social_image)
            ->render('modules.collections.show', compact('collection', 'items'));
    }
}
