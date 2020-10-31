<?php

declare(strict_types=1);

namespace Imports;

use Carbon\Carbon;
use Coeliac\Common\Models\Announcement;

class AnnouncementsImport extends Import
{
    public function handle()
    {
        $seeds = $this->seedDatabase->table('announcements')->get();

        $bar = $this->command->makeProgressBar(count($seeds));
        $bar->start();

        foreach ($seeds as $seed) {
            Announcement::query()->create([
                'title' => $seed->title,
                'text' => $seed->text,
                'live' => $seed->live,
                'expires_at' => Carbon::createFromTimestamp($seed->expire),
                'created_at' => $seed->created_at,
                'updated_at' => $seed->updated_at,
            ]);

            $bar->advance();
        }

        $bar->finish();
    }
}
