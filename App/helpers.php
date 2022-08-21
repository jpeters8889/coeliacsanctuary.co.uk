<?php

declare(strict_types=1);

use Carbon\Carbon;
use Coeliac\Modules\Member\Models\User;
use NumberToWords\NumberToWords;

function admin_user(): User
{
    return User::query()->firstWhere('email', 'contact@coeliacsanctuary.co.uk');
}

function cs_nl2br(string $string): string
{
    return str_replace(["\r", "\n"], ['', '<br />'], $string);
}

function cs_br2nl(string $string): string
{
    return str_replace('<br />', "\n", $string);
}

function formatPrice(mixed $price, bool $withPence = true, string $symbol = '£'): string
{
    $formattedPrice = number_format($price / 100, 2);

    if (! $withPence && strpos($formattedPrice, '.00')) {
        $formattedPrice = trim($formattedPrice, '.00');
    }

    return $symbol . $formattedPrice;
}

function randomNumber(int $length = 8): int
{
    $numbers = collect([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);

    $return = [];

    for ($number = 0; $number < $length; ++$number) {
        $return[] = $numbers->random();
    }

    return (int) implode('', $return);
}

function formatDate(Carbon $date, string $format = 'jS F Y'): string
{
    if ($date < Carbon::now()->subMonth()) {
        return $date->format($format);
    }

    return $date->diffForHumans();
}

function redirect_now(string $url, int $code = 301): never
{
    resolve('app')->abort($code, '', ['Location' => $url]);
}

function array_average(array $values): null|float
{
    if (! $values) {
        return null;
    }

    return round(array_sum($values) / count($values) * 2) / 2;
}

function numberToWords(float|int $number, int $max = 10, int $min = 0): string
{
    if ($number <= $min || $number > $max) {
        return number_format($number);
    }

    return (new NumberToWords())
        ->getNumberTransformer('en')
        ->toWords((int)$number);
}
