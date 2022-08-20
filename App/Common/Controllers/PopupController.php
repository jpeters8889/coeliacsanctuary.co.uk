<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Carbon\Carbon;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Models\Popup;
use Coeliac\Common\Popups\Repository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Cookie;

class PopupController extends BaseController
{
    public function __construct(protected Repository $repository, protected Request $request)
    {
    }

    public function get(): Popup|array
    {
        $popups = new Collection();

        $this->repository
            ->all()
            ->each(function (Popup $popup) use ($popups) {
                if ($this->request->hasCookie("CS_SEEN_POPUP_{$popup->id}")) {
                    $lastSeenModal = Carbon::createFromTimestamp((int) $this->request->cookie("CS_SEEN_POPUP_{$popup->id}"));
                    $modalDisplayLimit = Carbon::now()->subDays($popup->display_every);

                    if ($lastSeenModal->greaterThan($modalDisplayLimit)) {
                        return;
                    }
                }

                $popups->push($popup);
            });

        if ($popups->isEmpty()) {
            return [];
        }

        return $popups->first();
    }

    public function update(mixed $id): Response
    {
        /** @var Popup $popup */
        $popup = $this->repository->get($id);

        abort_if(! $popup, 404);

        $now = Carbon::now();

        return (new Response())->cookie(new Cookie(
            "CS_SEEN_POPUP_{$popup->id}",
            (string) $now->timestamp,
            $now->addDays($popup->display_every),
        ));
    }
}
