<?php

declare(strict_types=1);

namespace Tests\Unit\Common\Popups;

use Coeliac\Common\Models\Popup;
use Coeliac\Common\Popups\Repository;
use Coeliac\Common\Repositories\AbstractRepository;
use Tests\Abstracts\RepositoryTest;

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
