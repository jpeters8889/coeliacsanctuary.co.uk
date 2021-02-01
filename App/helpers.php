<?php

declare(strict_types=1);

use Carbon\Carbon;

function admin_user(): \Coeliac\Modules\Member\Models\User
{
    return \Coeliac\Modules\Member\Models\User::query()->firstWhere('email', 'contact@coeliacsanctuary.co.uk');
}

function cs_nl2br($string)
{
    return str_replace(["\r", "\n"], ['', '<br />'], $string);
}

function cs_br2nl($string)
{
    return str_replace('<br />', "\n", $string);
}

function formatPrice($price, $withPence = true, $symbol = '£')
{
    $formattedPrice = number_format($price / 100, 2);

    if (!$withPence && strpos($formattedPrice, '.00')) {
        $formattedPrice = trim($formattedPrice, '.00');
    }

    return $symbol.$formattedPrice;
}

function randomNumber($length = 8)
{
    $numbers = collect([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);

    $return = [];

    for ($number = 0; $number < $length; ++$number) {
        $return[] = $numbers->random();
    }

    return implode('', $return);
}

function formatDate(Carbon $date, $format = 'jS F Y')
{
    if ($date < Carbon::now()->subMonth()) {
        return $date->format($format);
    }

    return $date->diffForHumans();
}

function redirect_now($url, $code = 301)
{
    resolve('app')->abort($code, '', ['Location' => $url]);
}

function array_average(array $values)
{
    if (!$values) {
        return null;
    }

    return round(array_sum($values) / count($values) * 2) / 2;
}
