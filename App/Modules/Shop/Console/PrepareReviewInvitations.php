<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Console;

use Carbon\Carbon;
use Coeliac\Modules\Shop\Jobs\SendReviewInvitation;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Coeliac\Modules\Shop\Models\ShopPostageCountryArea;
use Illuminate\Console\Command;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class PrepareReviewInvitations extends Command
{
    protected $signature = 'coeliac:send-shop-review-invitations';

    protected int $totalSent = 0;

    protected function sendingRules(): Collection
    {
        return new Collection([
            ['date' => Carbon::now()->subWeek()->toImmutable(), 'areas' => [ShopPostageCountryArea::UK]],
            ['date' => Carbon::now()->subWeeks(2)->toImmutable(), 'areas' => [ShopPostageCountryArea::EUROPE]],
            ['date' => Carbon::now()->subWeeks(3)->toImmutable(), 'areas' => [
                ShopPostageCountryArea::NORTH_AMERICA, ShopPostageCountryArea::OCEANA,],
            ],
        ]);
    }

    public function handle(Dispatcher $dispatcher)
    {
        $this->totalSent = 0;

        $this->sendingRules()->each(function ($rule) use ($dispatcher) {
            /** @var Collection<int, ShopOrder> $orders */
            $orders = ShopOrder::query()
                ->where('state_id', ShopOrderState::STATE_COMPLETE)
                ->where('shipped_at', '<=', $rule['date'])
                ->where('shipped_at', '>=', $rule['date']->startOfDay())
                ->whereRelation(
                    'postageCountry',
                    fn (Builder $relation) => $relation->whereIn('postage_area_id', $rule['areas'])
                )
                ->whereDoesntHave('reviewInvitation')
                ->get();

            return $orders->each(function (ShopOrder $order) use ($dispatcher) {
                $dispatcher->dispatch(new SendReviewInvitation($order));

                $this->totalSent++;
            });
        });

        $this->info("{$this->totalSent} Invitations Sent");
    }
}
