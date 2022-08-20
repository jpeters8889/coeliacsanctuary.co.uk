<?php

declare(strict_types=1);

namespace Coeliac\Modules\Collection\Items;

use Coeliac\Modules\Collection\Models\CollectionItem;
use Illuminate\Container\Container;
use Illuminate\Contracts\View\Factory as ViewFactory;

abstract class Item
{
    protected ViewFactory $viewFactory;
    protected CollectionItem $collectionItem;

    public function __construct(CollectionItem $item)
    {
        $this->collectionItem = $item;
        $this->viewFactory = Container::getInstance()->make(ViewFactory::class);
    }

    public static function resolve(CollectionItem $item): Item
    {
        if (! $item->relationLoaded('item')) {
            $item->load('item');
        }

        $className = class_basename($item->item);

        /** @var class-string<Item> $namespace */
        $namespace = "Coeliac\\Modules\\Collection\\Items\\{$className}";

        return new $namespace($item);
    }

    abstract public function toArray(): array;

    abstract public function render(): string;
}
