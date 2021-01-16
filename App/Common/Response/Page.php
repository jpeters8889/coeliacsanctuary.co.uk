<?php

declare(strict_types=1);

namespace Coeliac\Common\Response;

use Illuminate\Container\Container;
use Coeliac\Common\Announcements\Repository;
use JPeters\PageViewBuilder\Page as PageBuilder;

class Page extends PageBuilder
{
    private $prefetch = [];

    private array $breadcrumbs = [
        'crumbs' => [
            [
                'link' => '/',
                'title' => 'Coeliac Sanctuary',
            ],
        ],
        'location' => '',
    ];

    public function breadcrumbs(array $breadcrumbs, $location)
    {
        $this->breadcrumbs['location'] = $location;

        if ($breadcrumbs === []) {
            return $this;
        }

        if (is_array($breadcrumbs[0])) {
            $this->breadcrumbs['crumbs'] = array_merge($this->breadcrumbs['crumbs'], $breadcrumbs);

            return $this;
        }

        $this->breadcrumbs['crumbs'][] = $breadcrumbs;

        return $this;
    }

    public function addPrefetch(array $items)
    {
        $this->prefetch = array_merge($this->prefetch, $items);

        return $this;
    }

    protected function collectData(array $data = []): array
    {
        $data['breadcrumbs'] = $this->breadcrumbs;
        $data['announcements'] = Container::getInstance()->make(Repository::class)->take(1);
        $data['prefetch'] = array_merge($this->prefetch, [
        ]);

        return parent::collectData($data);
    }
}
