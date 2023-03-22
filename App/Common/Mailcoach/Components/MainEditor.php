<?php

namespace Coeliac\Common\Mailcoach\Components;

use Coeliac\Common\Mailcoach\Support\NewsletterCompiler;
use Illuminate\Support\Str;
use Livewire\Component;
use Spatie\Mailcoach\Domain\Campaign\Models\Concerns\HasHtmlContent;

class MainEditor extends Component
{
    protected ?NewsletterCompiler $compiler = null;

    public HasHtmlContent $campaign;

    public $template = '';

    protected $listeners = ['addBlock', 'addComponentToBlock', 'componentUpdated'];

    public function mount()
    {
        $this->compiler = new NewsletterCompiler($this->campaign);

        $this->compileMjml();
    }

    public function hydrate()
    {
        if (!$this->compiler) {
            $this->compiler = new NewsletterCompiler($this->campaign);
        }

        $this->compileMjml();
    }

    public function addBlock($block)
    {
        switch ($block) {
            case 'triple':
                $properties = [
                    ['component' => null],
                    ['component' => null],
                    ['component' => null],
                ];
                break;
            case 'double':
                $properties = [
                    ['component' => null],
                    ['component' => null],
                ];
                break;
            case 'single':
            default:
                $properties = [['component' => null]];
                break;
        }

        $block = [
            'id' => Str::uuid(),
            'block' => $block,
            'properties' => $properties,
        ];

        /** @var array $data */
        $data = json_decode($this->campaign->structured_html, true);

        if (!is_array($data)) {
            $data = [];
        }

        if (!isset($data['blocks'])) {
            $data['blocks'] = [];
        }

        $data['blocks'][] = $block;

        $this->campaign->update(['structured_html' => $data]);
        $this->campaign->refresh();
        $this->compileMjml();

        $this->emit('newsletter-updated', $block);
    }

    public function addComponentToBlock($blockId, $component, $column = 0)
    {
        [$index, $block] = $this->findBlock($blockId);

        $block['properties'][$column]['component'] = [
            'name' => $component,
            'properties' => [],
        ];

        $this->saveComponent($block, $index);
    }

    protected function saveComponent($block, $index)
    {
        $data = json_decode($this->campaign->getStructuredHtml(), true);

        $data['blocks'][$index] = $block;

        $this->campaign->update(['structured_html' => $data]);
        $this->campaign->refresh();
        $this->compileMjml();

        $this->emit('newsletter-updated', $block);
    }

    public function componentUpdated($blockId, $componentIndex, $properties)
    {
        [$index, $block] = $this->findBlock($blockId);

        $block['properties'][$componentIndex]['component']['properties'] = $properties;

        $this->saveComponent($block, $index);
    }

    public function moveBlock($blockId, $direction)
    {
        [$index, $block] = $this->findBlock($blockId);

        $newIndex = $direction === 'up' ? $index - 1 : $index + 1;

        $data = json_decode($this->campaign->getStructuredHtml(), true);

        $blocks = $data['blocks'];

        $tempBlock = $blocks[$newIndex];

        $blocks[$newIndex] = $block;
        $blocks[$index] = $tempBlock;

        $this->campaign->update(['structured_html' => ['blocks' => $blocks]]);
        $this->campaign->refresh();
        $this->compileMjml();

        $this->emit('newsletter-updated', $block);
    }

    public function deleteBlock($blockId)
    {
        $data = json_decode($this->campaign->getStructuredHtml(), true);

        $blocks = collect($data['blocks'])
            ->reject(fn($block) => $block['id'] === $blockId)
            ->values();

        $this->campaign->update(['structured_html' => ['blocks' => $blocks]]);
        $this->campaign->refresh();
        $this->compileMjml();

        $this->emit('newsletter-updated');
    }

    protected function findBlock($blockId)
    {
        $blocks = json_decode($this->campaign->getStructuredHtml(), true)['blocks'];

        $ids = array_map(fn($block) => $block['id'], $blocks);

        $index = array_search($blockId, $ids);

        return [$index, $blocks[$index]];
    }

    protected function compileMjml(): void
    {
        $this->template = $this->compiler->renderForEditor();
    }

    public function render()
    {
        return view('mailcoach.components.main-editor');
    }
}
