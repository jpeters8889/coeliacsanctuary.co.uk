<?php

declare(strict_types=1);

namespace Coeliac\Common\Traits;

use Illuminate\Database\Eloquent\Model;
use function in_array;

/** @mixin Model */
trait HasRichText
{
    public function getRichTextAttribute(): array
    {
        return array_merge([
            '@context' => $this->richTextContext(),
            '@type' => $this->richTextType(),
        ], $this->toRichText());
    }

    protected function richTextContext(): string
    {
        return 'http://schema.org';
    }

    abstract protected function richTextType(): string;

    abstract protected function toRichText(): array;

    protected function formatTimeToIso(string $time): string
    {
        $time = str_ireplace([' and', ' a', ' half'], '', $time);
        $bits = explode(' ', $time);

        if (count($bits) === 4) {
            return "PT{$bits[0]}H{$bits[2]}M";
        }

        if (count($bits) === 2) {
            $unit = 'M';

            if (in_array($bits[1], ['Hour', 'Hours'])) {
                $unit = 'H';
            }

            return "PT{$bits[0]}{$unit}";
        }

        return 'PT';
    }
}
