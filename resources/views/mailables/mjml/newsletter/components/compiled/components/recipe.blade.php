<mj-column
    @if(($block === 'double' || $block === 'triple') && $position === 0)
        padding-right="10px"
    @endif

    @if($block === 'triple' && $position === 1)
        padding-right="10px"
    @endif
>
    @if($recipe)
        @if($block === 'single')
            <mj-text mj-class="inner">
                <h2>
                    <a href="{{ $recipe->absolute_link }}">{{ $recipe->title }}</a>
                </h2>
            </mj-text>
        @endif

        <mj-image href="{{ $recipe->absolute_link }}" src="{{ $recipe->main_image }}" fluid-on-mobile="true"></mj-image>

        <mj-text class="blue-links" padding="10px 0">
            <h3>
                <a href="{{ $recipe->absolute_link }}">{{ $recipe->title }}</a>
            </h3>
        </mj-text>

        <mj-text class="blue-links">
            {!! $description !!}
        </mj-text>

        <mj-button href="{{ $recipe->absolute_link }}" padding="10px 0" @if($block === 'single') border-radius="6px"
                   font-size="20px" @endif>
            Read more
        </mj-button>
    @else
        <mj-text></mj-text>
    @endif
</mj-column>
