<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Coeliac\Common\Models\Popup;
use Illuminate\Support\Collection;
use Coeliac\Common\Popups\Repository;
use Coeliac\Base\Controllers\BaseController;

class PopupController extends BaseController
{
    private Repository $repository;
    private Request $request;

    public function __construct(Repository $repository, Request $request)
    {
        $this->repository = $repository;
        $this->request = $request;
    }

    public function get()
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

    public function update($id)
    {
        /* @var ?Popup $popup */
        $popup = $this->repository->get($id);

        abort_if(!$popup, 404);

        $now = Carbon::now();

        return (new Response())->cookie(
            "CS_SEEN_POPUP_{$popup->id}",
            $now->timestamp,
            /** @phpstan-ignore-next-line  */
            $now->addDays($popup->display_every)->diffInMinutes($now)
        );
    }
}
