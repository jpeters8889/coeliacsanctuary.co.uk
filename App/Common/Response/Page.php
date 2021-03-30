<?php

declare(strict_types=1);

namespace Coeliac\Common\Response;

use Illuminate\Container\Container;
use Coeliac\Common\Announcements\Repository;
use JPeters\PageViewBuilder\Page as PageBuilder;

class Page extends PageBuilder
{
    private array $prefetch = [];

    private ?string $criticalCss = null;

    private bool $tracking = true;

    private bool $scrapable = false;

    private array $scrapableData = [];

    private array $breadcrumbs = [
        'crumbs' => [
            [
                'link' => '/',
                'title' => 'Coeliac Sanctuary',
            ],
        ],
        'location' => '',
    ];

    public function breadcrumbs(array $breadcrumbs, $location): self
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

    public function addPrefetch(array $items): self
    {
        $this->prefetch = array_merge($this->prefetch, $items);

        return $this;
    }

    public function loadCriticalCss(string $path): self
    {
        $this->criticalCss = $path;

        return $this;
    }

    public function doNotIndex(): self
    {
        $this->tracking = false;

        return $this;
    }

    public function scrapable(string $area, int $id): self
    {
        $this->scrapable = true;
        $this->scrapableData = ['area' => $area, 'id' => $id];

        return $this;
    }

    protected function getScrapableData()
    {
        if (!$this->scrapable) {
            return false;
        }

        return $this->scrapableData;
    }

    protected function collectData(array $data = []): array
    {
        return parent::collectData(array_merge($data, [
            'breadcrumbs' => $this->breadcrumbs,
            'announcements' => Container::getInstance()->make(Repository::class)->take(1),
            'prefetch' => array_merge($this->prefetch, [
                'http://fonts.cdnfonts.com/css/note-this' => 'font',
                'https://fonts.googleapis.com/css?family=Raleway:200,400,500,600,700&display=swap' => 'style',
            ]),
            'criticalCss' => $this->criticalCss,
            'tracking' => $this->tracking,
            'scrapable' => $this->getScrapableData(),
        ]));
    }
}
