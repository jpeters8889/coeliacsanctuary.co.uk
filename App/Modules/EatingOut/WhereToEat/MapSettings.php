<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat;

use Illuminate\Container\Container;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;

class MapSettings
{
    private $countyData = [];

    public function __construct(CacheRepository $cache, ConfigRepository $config)
    {
        if ($cache->has($key = $config->get('coeliac.cache.wheretoeat.map_settings'))) {
            $this->countyData = $cache->get($key);

            return;
        }

        $this->buildCountySettings();

        $cache->rememberForever(
            $key,
            fn () => $this->countyData
        );
    }

    public function getSettings()
    {
        $cache = Container::getInstance()->make(CacheRepository::class);
        $config = Container::getInstance()->make(ConfigRepository::class);

        return $cache->rememberForever(
            $config->get('coeliac.cache.wheretoeat.js_map_settings'),
            fn () => $this->baseMapData()
        );
    }

    private function buildComment($county): string
    {
        $places = WhereToEat::query()
            ->selectRaw('wheretoeat_counties.county')
            ->selectRaw('SUM(CASE WHEN wheretoeat.type_id = 1 THEN 1 ELSE 0 END) wte')
            ->selectRaw('SUM(CASE WHEN wheretoeat.type_id = 2 THEN 1 ELSE 0 END) att')
            ->selectRaw('SUM(CASE WHEN wheretoeat.type_id = 2 THEN 1 ELSE 0 END) hotel')
            ->where('wheretoeat.live', true)
            ->where('wheretoeat.county_id', $county->id)
            ->leftJoin('wheretoeat_counties', 'county_id', 'wheretoeat_counties.id')
            ->leftJoin('wheretoeat_types', 'type_id', 'wheretoeat_types.id')
            ->groupBy('wheretoeat_counties.county')
            ->orderBy('county')
            ->first();

        return $this->processInfo($county, $places);
    }

    private function processInfo($county, $places): string
    {
        if (!is_object($places) || !($places->wte > 0 || $places->att > 0 || $places->hotel > 0)) {
            return "Sorry, there are no places in {$county->county}";
        }

        return $this->getInfoText($county, $places);
    }

    private function getInfoText($county, $places): string
    {
        return implode('', [
            $this->getText(
                (int) $places->wte,
                "There are {$places->wte} places to eat in {$county->county}<br/>",
                "There is 1 place to eat in {$county->county}<br/>"
            ),
            $this->getText(
                (int) $places->att,
                "There are {$places->att} attractions in {$county->county} with Gluten Free options.<br/>",
                "There is 1 attraction in {$county->county} with Gluten Free options.<br/>"
            ),
            $this->getText(
                (int) $places->hotel,
                "There are {$places->hotel} hotels or B&Bs in {$county->county} with Gluten Free options<br/>",
                "There is 1 hotel or B&B in {$county->county} with Gluten Free options.<br/>"
            ),
        ]);
    }

    private function getText(int $count, string $multiple, string $single): string
    {
        if ($count > 1) {
            return $multiple;
        }

        if ($count === 1) {
            return $single;
        }

        return '';
    }

    private function getCountyColour(): array
    {
        return [
            'England' => '#addaf9',
            'Wales' => '#80ccfc',
            'Scotland' => '#52ade7',
            'Northern Ireland' => '#1a9926',
            'Republic of Ireland' => '#1ec72e',
            'Isle of Man' => '#6d70f1',
            'Channel Islands' => '#14a845',
        ];
    }

    private function baseMapData(): array
    {
        return [
            'mapWidth' => '100%', 'shadowAllow' => true, 'shadowWidth' => 2, 'shadowOpacity' => 0.2,
            'shadowColor' => 'black', 'shadowX' => 0, 'shadowY' => 0, 'iPhoneLink' => true, 'isNewWindow' => false,
            'zoomEnable' => true, 'zoomEnableControls' => true, 'zoomMax' => 8, 'zoomStep' => 0.8,
            'borderColor' => '#f7f7f7', 'borderColorOver' => '#ffffff', 'nameColor' => '#ffffff',
            'nameFontSize' => '10px', 'nameFontWeight' => 'bold', 'nameStroke' => true, 'overDelay' => 300,
            'map_data' => $this->countyData,
        ];
    }

    private function buildCountySettings(): void
    {
        WhereToEatCounty::query()
            ->where('county', '!=', 'Nationwide')
            ->with(['country', 'eateries', 'eateries.town', 'eateries.ratings'])
            ->each(function (WhereToEatCounty $county, $index) {
                ++$index;
                $this->countyData["st{$index}"] = [
                    'id' => $index,
                    'name' => $county->county,
                    'shortname' => '',
                    'link' => '/wheretoeat/'.$county->slug,
                    'comment' => $this->buildComment($county),
                    'image' => '',
                    'color_map' => $this->getCountyColour()[$county->country->country],
                    'color_map_over' => '#dbbc25',
                ];
            });
    }
}
