<?php

declare(strict_types=1);

namespace Tests\Unit\Common\Announcements;

use Coeliac\Common\Announcements\Repository;
use Coeliac\Common\Models\Announcement;
use Coeliac\Common\Repositories\AbstractRepository;
use Tests\Abstracts\RepositoryTest;

class AnnouncementRepositoryTest extends RepositoryTest
{
    protected function loadRepository(): AbstractRepository
    {
        return new Repository();
    }

    protected function model(): string
    {
        return Announcement::class;
    }
}
