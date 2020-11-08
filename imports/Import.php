<?php

declare(strict_types=1);

namespace Imports;

use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\ConnectionInterface;
use Coeliac\Base\Console\Commands\ImportCommand;

abstract class Import
{
    /**
     * @var Connection|ConnectionInterface
     */
    protected $seedDatabase;

    /**
     * @var Connection|ConnectionInterface
     */
    protected $shopDatabase;
    /**
     * @var Command
     */
    protected $command;
    /**
     * @var Connection|ConnectionInterface
     */
    protected $campaignDatabase;

    public function __construct(ImportCommand $command)
    {
        $this->seedDatabase = DB::connection('seed');
        $this->shopDatabase = DB::connection('seed_shop');
        $this->campaignDatabase = DB::connection('seed_campaigns');
        $this->command = $command;

        $command->info('Running '.class_basename($this).' - '.Carbon::now()->format('H:i:s'));
    }

    public function __destruct()
    {
        $this->command->line(PHP_EOL.'------------------');
    }

    abstract public function handle();

    protected function uploadImage($directory, $image)
    {
        return last(explode('/', Storage::disk('images')->putFile($directory, new File($image), 'public')));
    }

    protected function findInArray($model, $key, $find, $default = null)
    {
        if ($find === 'sw') {
            $find = 'slimmingworldfriendly';
        }

        if ($find === 'fodmap') {
            $find = 'fodmapfriendly';
        }

        if ($find === 'swimming') {
            $find = 'pool';
        }

        foreach ($model::query()->get() as $item) {
            if (strtolower(str_replace(' ', '', $item[$key])) === strtolower($find)) {
                return $item->id;
            }

            if (($item[$key] === $find) || (strtolower(str_replace(' ', '', $item[$key])) === strtolower($find))) {
                return $item->id;
            }
        }

        return $default;
    }

    public function formatHtml($body, $slug, $imageReplacements = []): string
    {
        $body = html_entity_decode(html_entity_decode($body));
        $body = str_replace('Â£', '£', $body);

        if (str_contains($body, '&lt;')) {
            $this->command->info("{$slug} has incorrect html =/");
        }

        if ($imageReplacements) {
            $pattern = '/<div class="(.*?)"><a href="(.*?)" data-lightbox="(.*?)" data-title="(.*?)"><img src="(.*?)" alt="(.*?)"(.*?)\/><\/a><div class="caption">(.*?)<\/div><\/div>/';

            preg_match_all($pattern, $body, $matches, PREG_SET_ORDER);

            foreach ($matches as $match) {
                [$original, $class, , , $caption, $image, ,] = $match;

                switch ($class) {
                    case 'fullwidthimg':
                        $position = 'fullwidth';
                        break;
                    case 'landscapeimgleft':
                    case 'portraitimgleft':
                    default:
                        $position = 'left';
                        break;
                    case 'landscapeimgright':
                    case 'portraitimgright':
                        $position = 'right';
                        break;
                }

                $newImage = "<article-image src='{$imageReplacements[str_replace(' ', '%20', $image)]}' title='{$caption}' position='{$position}'></article-image>";

                $body = str_replace($original, $newImage, $body);
            }
        }

        return $body;
    }
}
