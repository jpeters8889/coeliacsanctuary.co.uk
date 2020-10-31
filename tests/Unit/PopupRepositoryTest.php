<?php

declare(strict_types=1);

namespace Tests\Unit;

use Coeliac\Common\Models\Popup;
use Tests\Abstracts\RepositoryTest;
use Coeliac\Common\Popups\Repository;
use Coeliac\Common\Repositories\AbstractRepository;

class PopupRepositoryTest extends RepositoryTest
{
    protected function loadRepository(): AbstractRepository
    {
        return new Repository();
    }

    protected function model(): string
    {
        return Popup::class;
    }
}
