<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Jobs;

use Carbon\Carbon;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderReviewInvitation;
use Coeliac\Modules\Shop\Notifications\LeaveAReviewNotification;

class SendReviewInvitation
{
    protected ShopOrderReviewInvitation $invitation;

    public function __construct(protected ShopOrder $order, protected ?string $delayText = null)
    {
        $this->invitation = $order->reviewInvitation()->firstOrCreate();
    }

    public function handle()
    {
        $this->order->user->notify(new LeaveAReviewNotification($this->invitation, $this->delayText));

        $this->invitation->update([
            'sent' => true,
            'sent_at' => Carbon::now(),
        ]);
    }
}
