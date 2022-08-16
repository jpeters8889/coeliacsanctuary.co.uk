<?php

namespace Coeliac\Modules\Shop\Jobs;

use Carbon\Carbon;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderReviewInvitation;
use Coeliac\Modules\Shop\Notifications\LeaveAReviewNotification;

class SendReviewInvitation
{
    protected ShopOrderReviewInvitation $invitation;

    public function __construct(protected ShopOrder $order)
    {
        $this->invitation = $order->reviewInvitation()->firstOrCreate();
    }

    public function handle()
    {
        $this->order->user->notify(new LeaveAReviewNotification($this->invitation));

        $this->invitation->update([
            'sent' => true,
            'sent_at' => Carbon::now(),
        ]);
    }
}