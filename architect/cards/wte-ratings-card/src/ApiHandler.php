<?php

declare(strict_types=1);

namespace Coeliac\Architect\Cards\WteRatingsCard;

use Illuminate\Http\Response;
use Illuminate\Notifications\AnonymousNotifiable;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatReview;
use Coeliac\Modules\EatingOut\WhereToEat\Notifications\WhereToEatRatingApprovedNotification;

class ApiHandler
{
    public function delete($id)
    {
        WhereToEatReview::query()->findOrFail($id)->delete();

        return new Response();
    }

    public function approve($id)
    {
        /** @var WhereToEatReview $rating */
        $rating = WhereToEatReview::query()->findOrFail($id);
        $rating->update(['approved' => 1]);

        (new AnonymousNotifiable())
            ->route('mail', $rating->email)
            ->notify(new WhereToEatRatingApprovedNotification($rating));

        return new Response();
    }
}
