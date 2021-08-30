<?php

declare(strict_types=1);

namespace Coeliac\Modules\Collection\Items;

use Illuminate\Container\Container;
use Coeliac\Modules\Collection\Models\CollectionItem;
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

    public static function resolve(CollectionItem $item): static
    {
        $className = class_basename($item->item);

        $namespace = "Coeliac\\Modules\\Collection\\Items\\{$className}";

        return new $namespace($item);
    }

    abstract public function toArray(): array;

    abstract public function render(): string;
}
