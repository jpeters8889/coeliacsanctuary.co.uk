<?php

declare(strict_types=1);

namespace Coeliac\Common\Newsletter\Services;

use Coeliac\Common\Newsletter\Exceptions\AlreadySubscribedException;
use Coeliac\Common\Newsletter\NewsletterService;
use RuntimeException;
use Spatie\Mailcoach\Domain\Audience\Models\EmailList;

class Mailcoach implements NewsletterService
{
    private ?EmailList $list;

    public function __construct(string $listName)
    {
        $this->list = EmailList::query()->where('name', $listName)->first();
    }

    public function subscribe(string $email, ?string $url): void
    {
        throw_if(! $this->list, new RuntimeException('no list'));

        if ($this->list->isSubscribed($email)) {
            throw new AlreadySubscribedException('already subscribed');
        }

        $this->list->subscribe($email, ['url' => $url]);
    }
}
