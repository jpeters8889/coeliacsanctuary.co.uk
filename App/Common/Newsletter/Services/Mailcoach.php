<?php

declare(strict_types=1);

namespace Coeliac\Common\Newsletter\Services;

use RuntimeException;
use Spatie\Mailcoach\Models\EmailList;
use Coeliac\Common\Newsletter\NewsletterService;
use Coeliac\Common\Newsletter\Exceptions\AlreadySubscribedException;

class Mailcoach implements NewsletterService
{
    private ?EmailList $list;

    public function __construct(string $listName)
    {
        $this->list = EmailList::query()->where('name', $listName)->first();
    }

    public function subscribe($email, $url)
    {
        throw_if(!$this->list, new RuntimeException('no list'));

        if ($this->list->isSubscribed($email)) {
            throw new AlreadySubscribedException('already subscribed');
        }

        $this->list->subscribe($email, ['url' => $url]);
    }
}
