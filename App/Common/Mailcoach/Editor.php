<?php

declare(strict_types=1);

namespace Coeliac\Common\Mailcoach;

use Coeliac\Common\Mailcoach\Support\NewsletterCompiler;
use Spatie\Mailcoach\Http\App\Livewire\EditorComponent;

class Editor extends EditorComponent
{
    protected $listeners = ['newsletter-updated' => 'saveQuietly'];

    public function render()
    {
        return view('mailcoach.editor');
    }

    public function saveQuietly()
    {
        $this->renderFullHtml();

        $this->model->setHtml($this->fullHtml);
        $this->model->save();
        $this->lastSavedAt = $this->model->updated_at;
        $this->autosaveConflict = false;
    }

    public function renderFullHtml()
    {
        $compiler = new NewsletterCompiler($this->model);

        $this->fullHtml = $compiler->render();
    }
}
