<?php

namespace Coeliac\Common\Mailcoach;

use Spatie\Mailcoach\Domain\Settings\Support\EditorConfiguration\Editors\EditorConfigurationDriver;

class Driver extends EditorConfigurationDriver
{
    public static function label(): string
    {
        return 'Coeliac Editor';
    }

    public function getClass(): string
    {
        return Editor::class;
    }
}
