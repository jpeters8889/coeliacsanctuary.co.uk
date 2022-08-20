<?php

declare(strict_types=1);

namespace Coeliac\Common\Response;

use Carbon\Carbon;
use Coeliac\Common\Announcements\Repository;
use Coeliac\Modules\Competition\Models\Competition;
use Illuminate\Container\Container;
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

    protected bool $showBreadcrumbs = true;

    public function hideFacebook(): static
    {
        $this->displayFacebook = false;

        return $this;
    }

    public function hideTwitter(): static
    {
        $this->displayTwitter = false;

        return $this;
    }

        public function setMetaDescription($description): static
        {
            $this->metaDescription = $description;

            return $this;
        }

    public function setMetaKeywords(array $keywords): static
    {
        $this->metaKeywords = array_merge($this->metaKeywords, $keywords);

        return $this;
    }

        public function setSocialImage($image): static
        {
            $this->metaImage = $image;

            return $this;
        }

        public function setPageTitle($title): static
        {
            $this->title = $title;

            return $this;
        }

    public function showFacebook(): static
    {
        $this->displayFacebook = true;

        return $this;
    }

    public function showTwitter(): static
    {
        $this->displayTwitter = true;

        return $this;
    }

    public function noBreadcrumbs(): static
    {
        $this->showBreadcrumbs = false;

        return $this;
    }

    public function breadcrumbs(array $breadcrumbs, string $location): static
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

    public function addPrefetch(array $items): static
    {
        $this->prefetch = array_merge($this->prefetch, $items);

        return $this;
    }

    public function loadCriticalCss(string $path): static
    {
        $this->criticalCss = $path;

        return $this;
    }

    public function doNotIndex(): static
    {
        $this->tracking = false;

        return $this;
    }

    public function scrapable(string $area, int $id): static
    {
        $this->scrapable = true;
        $this->scrapableData = ['area' => $area, 'id' => $id];

        return $this;
    }

    protected function getScrapableData(): bool|array
    {
        if (! $this->scrapable) {
            return false;
        }

        return $this->scrapableData;
    }

    protected function collectData(array $data = []): array
    {
        return parent::collectData(array_merge($data, [
            'breadcrumbs' => $this->breadcrumbs,
            'announcements' => Container::getInstance()->make(Repository::class)->take(1),
            'promoteCompetition' => Competition::query()->whereDate('start_at', '<', Carbon::now()->format('Y-m-d H:i:s'))
                ->whereDate('end_at', '>', Carbon::now()->format('Y-m-d H:i:s'))
                ->where('promote_on_banner', 1)
                ->first(),
            'prefetch' => array_merge($this->prefetch, [
                'http://fonts.cdnfonts.com/css/note-this' => 'font',
                'https://fonts.googleapis.com/css?family=Raleway:200,400,500,600,700&display=swap' => 'style',
            ]),
            'criticalCss' => $this->criticalCss,
            'tracking' => $this->tracking,
            'scrapable' => $this->getScrapableData(),
            'showBreadcrumbs' => $this->showBreadcrumbs,
        ]));
    }
}
