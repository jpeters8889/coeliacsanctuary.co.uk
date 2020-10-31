<?php

declare(strict_types=1);

namespace Coeliac\Architect\Pages\DispatchSlips;

use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Illuminate\Contracts\Routing\ResponseFactory;

class ApiHandler
{
    public function render(Dompdf $pdf, ResponseFactory $factory, $ids)
    {
        $pdf->loadHtml($factory->view('architect.shop-dispatch-slip', [
            'orders' => ShopOrder::query()
                ->where('state_id', '!=', ShopOrderState::STATE_BASKET)
                ->whereIn('id', explode(',', $ids))
                ->get(),
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
        ShopOrder::query()
            ->where('state_id', '!=', ShopOrderState::STATE_BASKET)
            ->whereIn('id', explode(',', (string) $request->input('id')))
            ->get()
            ->each(fn (ShopOrder $order) => $order->markAs(ShopOrderState::STATE_PRINTED));
    }
}
