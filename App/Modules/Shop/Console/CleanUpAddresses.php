<?php

namespace Coeliac\Modules\Shop\Console;

use Coeliac\Modules\Member\Models\UserAddress;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CleanUpAddresses extends Command
{
    protected $signature = 'coeliac:clean-addresses';

    protected array $processedIds = [];

    public function handle()
    {
        $keys = ['line_2', 'line_3'];

        $addresses = UserAddress::query()->get();
        $bar = $this->output->createProgressBar($addresses->count());

        $this->info('Nullifying' . PHP_EOL);

        $addresses->each(function (UserAddress $address) use ($keys, $bar) {
            $updated = false;

            foreach ($keys as $key) {
                if (trim($address->$key) === '') {
                    $updated = true;
                    $address->$key = null;
                }
            }

            if ($updated) {
                $address->save();
            }

            $bar->advance();
        });

        $this->info(PHP_EOL . 'Duplicates' . PHP_EOL);

        $bar->setProgress(0);

        $addresses->each(function (UserAddress $address) use ($bar) {
            if (in_array($address->id, $this->processedIds)) {
                $bar->advance();
                return;
            }

            $duplicateAddresses = UserAddress::query()
                ->where('id', '!=', $address->id)
                ->where('type', trim($address->type))
                ->where('line_1', trim($address->line_1))
                ->where('line_2', $address->line_2 ? trim($address->line_2) : null)
                ->where('line_3', $address->line_3 ? trim($address->line_3) : null)
                ->where('town', trim($address->town))
                ->where('postcode', trim($address->postcode))
                ->where('country', $address->country)
                ->get();

            if ($duplicateAddresses->count() > 0) {
//                $this->info("{$address->id} has {$duplicateAddresses->count()} duplicates");
                $duplicateAddresses->each(function (UserAddress $duplicate) use ($address) {
                    if ($duplicate->type === 'Billing') {
                        $duplicate->forceDelete();
                    }

                    $duplicate->orders()->update(['user_address_id' => $address->id]);

                    $this->processedIds[] = $duplicate->id;

                    $duplicate->forceDelete();
                });
            }

            $this->processedIds[] = $address->id;

            $bar->advance();
        });

        $this->info(PHP_EOL . 'Dodgy Postcodes' . PHP_EOL);

        $bar->setProgress(0);

        $addresses->each(function (UserAddress $address) use ($bar) {
            if (Str::contains($address->postcode, '.')) {
                if ($address->type === 'Billing') {
                    $address->forceDelete();
                    $bar->advance();
                    return;
                }

                $address->delete();
            }

            $bar->advance();
        });
    }
}
