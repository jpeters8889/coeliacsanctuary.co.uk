<?php

declare(strict_types=1);

namespace Tests\Unit\Common\Announcements;

use Tests\Abstracts\RepositoryTest;
use Coeliac\Common\Models\Announcement;
use Coeliac\Common\Announcements\Repository;
use Coeliac\Common\Repositories\AbstractRepository;

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
