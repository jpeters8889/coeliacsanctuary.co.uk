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
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class PrepareReviewInvitations extends Command
{
    protected $signature = 'coeliac:send-shop-review-invitations {--id=} {--testing}';

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

    public function handle(Dispatcher $dispatcher): void
    {
        $this->totalSent = 0;

        $this->sendingRules()->each(fn ($rule) => $this->getOrders($rule)->each(function (ShopOrder $order) use ($dispatcher) {
            if ($this->option('testing')) {
                $this->info("Will send order {$order->id} to {$order->user->name}");
            } else {
                $dispatcher->dispatch(new SendReviewInvitation($order));
            }

            $this->totalSent++;
        }));

        $this->info("{$this->totalSent} Invitations Sent");
    }

    /** @return EloquentCollection<int, ShopOrder> */
    public function getOrders($rule): EloquentCollection
    {
        /** @var Builder<ShopOrder> $query */
        $query = ShopOrder::query()
            ->where('state_id', ShopOrderState::STATE_COMPLETE)
            ->where('shipped_at', '<=', $rule['date'])
            ->where('shipped_at', '>=', $rule['date']->startOfDay());

        if ($this->option('id')) {
            $query = ShopOrder::query()->whereIn('id', [$this->option('id')]);
        }

        return $query //@phpstan-ignore-line
            ->when($this->option('testing'), fn (Builder $builder) => $builder->with('user'))
            ->whereRelation(
                'postageCountry',
                fn (Builder $relation) => $relation->whereIn('postage_area_id', $rule['areas'])
            )
            ->whereDoesntHave('reviewInvitation')
            ->get();
    }
}
