<?php

namespace Coeliac\Common\Mailcoach\Support;

use Coeliac\Common\MjmlCompiler\CoeliacCompiler;
use Spatie\Mailcoach\Domain\Campaign\Models\Concerns\HasHtmlContent;

class NewsletterCompiler
{
    protected CoeliacCompiler $mjmlCompiler;

    public function __construct(protected HasHtmlContent $campaign)
    {
        $this->mjmlCompiler = new CoeliacCompiler();
    }

    public function renderForEditor(): string
    {
        return $this->render(true);
    }

    protected function getBlocks(): array
    {
        $data = json_decode($this->campaign->getStructuredHtml(), true);

        if (!isset($data['blocks'])) {
            return [];
        }

        return $data['blocks'];
    }

    public function render($editable = false): string
    {
        $mjml = view($editable ? 'mailables.mjml.newsletter.editor' : 'mailables.mjml.newsletter.newsletter', [
            'blocks' => $this->getBlocks(),
        ])->render();

        $compiled = $this->mjmlCompiler->compile($mjml);

        return (string) $compiled['html'];
    }
}
