<?php

declare(strict_types=1);

namespace Coeliac\Common\Architect;

use JPeters\Architect\Dashboards\AbstractDashboard;
use JPeters\Architect\Dashboards\Cards\Card;

class MailcoachDashboard extends AbstractDashboard
{
    public function dashboardName(): string
    {
        return 'Mailcoach';
    }

    public function dashboardRoute(): string
    {
        return 'mailcoach';
    }

    public function cards(): array
    {
        return [
            Card::generate('')
                ->setContent(
                    <<<STR
                    <p class="mb-2">Mailcoach is the new newsletter management app.</p>
                    <p><a href="/mailcoach" target="_blank">Go To Mailcoach</a></p>
                    STR
                ),
        ];
    }
}
