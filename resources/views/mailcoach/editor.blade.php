<div class="form-grid">
    @if ($model->hasTemplates())
        <x-mailcoach::template-chooser />
    @endif

    <div class="relative w-full">
        <livewire:coeliac-newsletter-main-editor :campaign="$model"></livewire:coeliac-newsletter-main-editor>
    </div>

    <x-mailcoach::editor-buttons :preview-html="$fullHtml" :model="$model" />
</div>
