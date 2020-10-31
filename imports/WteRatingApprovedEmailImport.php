<?php

declare(strict_types=1);

namespace Imports;

use Carbon\Carbon;
use Coeliac\Common\Models\NotificationEmail;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatRating;
use Coeliac\Modules\EatingOut\WhereToEat\Notifications\WhereToEatRatingApprovedNotification;

class WteRatingApprovedEmailImport extends Import
{
    public function handle()
    {
        $seeds = $this->campaignDatabase
            ->table('sent_transactional')
            ->where('template', 'wteApproved')
            ->get();

        $bar = $this->command->makeProgressBar(count($seeds));

        $bar->start();

        foreach ($seeds as $seed) {
            if (!$rating = $this->resolveRating($seed)) {
                $bar->advance();
                continue;
            }

            $notification = new WhereToEatRatingApprovedNotification($rating);
            $notification->forceDate(Carbon::createFromFormat('d/m/Y', json_decode($seed->mergeTags, true)['header']['date']));

            NotificationEmail::query()->create([
                'key' => $seed->token,
                'email_address' => $seed->toEmail,
                'template' => $notification->toMail()->mjml,
                'data' => $notification->toMail()->viewData,
                'created_at' => $seed->created_at,
                'updated_at' => $seed->updated_at,
            ]);

            $bar->advance();
        }
    }

    private function resolveRating($seed): ?WhereToEatRating
    {
        $data = json_decode($seed->mergeTags, true);

        /** @var WhereToEatRating $rating */
        $ratings = WhereToEatRating::query()
            ->with('eatery')
            ->where('email', $seed->toEmail)
            ->where('name', $seed->toName)
            ->get();

        if ($ratings->count() === 0) {
            return null;
        }

        $ratings = $ratings->filter(static function (WhereToEatRating $rating) use ($data) {
            return $rating->eatery->name === $data['place'];
        });

        if ($ratings->count() === 0) {
            return null;
        }

        return $ratings->first();
    }
}
