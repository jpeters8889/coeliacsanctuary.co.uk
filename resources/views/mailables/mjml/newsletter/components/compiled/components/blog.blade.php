<mj-column
        @if(($block === 'double' || $block === 'triple') && $position === 0)
            padding-right="10px"
        @endif

        @if($block === 'triple' && $position === 1)
            padding-right="10px"
        @endif
>
    @if($blog)
        @if($block === 'single')
            <mj-text mj-class="inner">
                <h2>
                    <a href="{{ $blog->absolute_link }}">{{ $blog->title }}</a>
                </h2>
            </mj-text>
        @endif

        <mj-image href="{{ $blog->absolute_link }}" src="{{ $blog->main_image }}" fluid-on-mobile="true"></mj-image>

        <mj-text css-class="blue-links" padding="10px 0">
            <h3>
                <a href="{{ $blog->absolute_link }}">{{ $blog->title }}</a>
            </h3>
        </mj-text>

        <mj-text css-class="blue-links">
            {!! $description !!}
        </mj-text>

        <mj-button href="{{ $blog->absolute_link }}" padding="10px 0" @if($block === 'single') border-radius="6px"
                   font-size="20px" @endif>
            Read more
        </mj-button>
    @else
        <mj-text></mj-text>
    @endif
</mj-column>
