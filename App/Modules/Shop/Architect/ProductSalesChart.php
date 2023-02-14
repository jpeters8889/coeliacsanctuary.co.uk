<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Architect;

use Carbon\Carbon;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use JPeters\Architect\Dashboards\Cards\Chartable;

class ProductSalesChart extends Chartable
{
    protected array $colours = [
        1 => '#80CCFC', //cards
        2 => '#addaf9', // multi
        3 => '#f26522', // cals
        4 => '#ff0000', // wristbands
        5 => '#00ff00', // stickers
        6 => '#FFB6C1', // pens
        7 => '#f5f5f5', // bags
        8 => '#ecd14a', // coeliac other cards
        10 => '#186ba3', // keyrings
        11 => '#ecd14a', // coeliac plus
        12 => '#cccccc', // lanyard
    ];

    protected array $backgroundColours = [];

    protected function chartType(): string
    {
        return 'bar';
    }

    protected function products(): Collection
    {
        return ShopProduct::query()
            ->with('categories')
            ->orderBy('title')
            ->get()
            ->map(fn (ShopProduct $product) => ['id' => $product->id, 'title' => $product->title, 'category_id' => $product->categories[0]->id]);
    }

    protected function labels(): array
    {
        $labels = [];

        $start = $this->dateRange['start']->clone()->startOf($this->dateRange['unit']);
        $end = $this->dateRange['end']->clone()->endOf($this->dateRange['unit']);

        $this->products()->each(function (array $product) use (&$labels, $start, $end) {
            $count = ShopOrderItem::query()
                ->where('product_id', $product['id'])
                ->whereHas('order', fn (Builder $query) => $query->whereHas('payment'))
                ->where('created_at', '>=', $start)
                ->where('created_at', '<=', $end)
                ->count();

            if ($count) {
                $labels[] = $product['title'];
            }
        });

        return $labels;
    }

    protected function calculateData(): array
    {
        $start = $this->dateRange['start']->clone()->startOf($this->dateRange['unit']);
        $end = $this->dateRange['end']->clone()->endOf($this->dateRange['unit']);

        return $this->getData($start, $end);
    }

    protected function getData(Carbon $start, Carbon $end): int|float|array
    {
        $products = [];

        $this->products()->each(function (array $product) use (&$products, $start, $end) {
            $count = 0;

            $item = ShopOrderItem::query()
                ->where('product_id', $product['id'])
                ->whereHas('order', fn (Builder $query) => $query->whereHas('payment'))
                ->where('created_at', '>=', $start)
                ->where('created_at', '<=', $end)
                ->get(['quantity']);

            if ($item) {
                $item->each(function (ShopOrderItem $item) use (&$count) {
                    $count += $item->quantity;
                });

                $products[] = $count;
                $this->backgroundColours[] = data_get($this->colours, $product['category_id'], '#cccccc');
            }
        });

        return $products;
    }

    protected function data(): array
    {
        return [[
            'label' => $this->dataLabel(),
            'data' => $this->calculateData(),
            'borderColor' => $this->backgroundColours,
            'backgroundColor' => $this->backgroundColours,
        ]];
    }

    protected function dataLabel(): string
    {
        return 'Product';
    }

    protected function defaultRange(): string
    {
        return 'lastMonth';
    }

    protected function options(): array
    {
        return [
            'indexAxis' => 'y',
            'scales' => [
                'x' => [
                    'min' => 0,
                ],
                'y' => [
                    'ticks' => [
                        'autoSkip' => false,
                    ],
                ],
            ],
        ];
    }
}
