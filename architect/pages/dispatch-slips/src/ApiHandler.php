<?php

declare(strict_types=1);

namespace Coeliac\Architect\Pages\DispatchSlips;

use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ApiHandler
{
    public function render(Dompdf $pdf, ResponseFactory $factory, $ids)
    {
        $orders = ShopOrder::query()
            ->with(['address', 'payment', 'items'])
            ->where('state_id', '!=', ShopOrderState::STATE_BASKET)
            ->when($ids === 'active', fn (Builder $query) => $query->where('state_id', ShopOrderState::STATE_PAID))
            ->when($ids !== 'active', fn (Builder $query) => $query->whereIn('id', explode(',', $ids)))
            ->get();

        $pdf->setOptions(new Options(['isRemoteEnabled' => true]))
            ->loadHtml($factory->view('architect.shop-dispatch-slip', [
                'orders' => $orders,
            ])->content());

        $pdf->setPaper('A4')->render();

        return new Response(
            $pdf->stream('slips.pdf', ['Attachment' => false]),
            200,
            ['Content-type' => 'application/pdf']
        );
    }

    public function printed(Request $request)
    {
        $ids = $request->get('id');

        ShopOrder::query()
            ->when($ids === 'active', fn (Builder $query) => $query->where('state_id', ShopOrderState::STATE_PAID))
            ->when($ids !== 'active', fn (Builder $query) => $query->whereIn('id', explode(',', $ids)))
            ->where('state_id', '!=', ShopOrderState::STATE_COMPLETE)
            ->each(fn (ShopOrder $order) => $order->markAs(ShopOrderState::STATE_PRINTED));
    }
}
