<mjml>
    @include('mailables.mjml.newsletter.components.metas')
    <mj-body background-color="#f7f7f7">
        @include('mailables.mjml.newsletter.components.header')

        <mj-raw>
            @foreach($blocks as $block)
                <div class="mx-auto relative group" style="max-width: 616px;">
        </mj-raw>
        @include("mailables.mjml.newsletter.components.editor.blocks.{$block['block']}")
        <mj-raw>
            <div class="absolute top-0 opacity-0 transition hover:opacity-100 group-hover:opacity-100" style="left: 100%; padding-top: 1rem;">
                <div class="bg-gray-200 border rounded flex space-x-2" style="border-color: #9ca3af">
                    <div class="p-2 border-r @if($loop->first) text-gray-400 @else cursor-pointer @endif" style="border-color: #d1d5db" @unless($loop->first) wire:click="moveBlock('{{ $block['id'] }}', 'up')" @endunless>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                        </svg>
                    </div>
                    <div class="p-2 border-r @if($loop->last) text-gray-400 @else cursor-pointer @endif" style="border-color: #d1d5db" @unless($loop->last) wire:click="moveBlock('{{ $block['id'] }}', 'down')" @endunless>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                    <div class="p-2 cursor-pointer" wire:click="deleteBlock('{{ $block['id'] }}')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </div>
                </div>
            </div>
            </div>
            @endforeach

            <div>
                <livewire:coeliac-newsletter-add-block></livewire:coeliac-newsletter-add-block>
            </div>
        </mj-raw>

        @include('mailables.mjml.newsletter.components.footer')
    </mj-body>
</mjml>

@push('endHead')
    <style>
        .hover\:opacity-100:hover {
            opacity: 100;
        }

        .hover\:bg-gray-200:hover {
            background-color: #e5e7eb
        }

        @media (min-width: 768px) {
            .modal-wrapper-lg .modal {
                height: 100%;
            }
        }
    </style>
@endpush
