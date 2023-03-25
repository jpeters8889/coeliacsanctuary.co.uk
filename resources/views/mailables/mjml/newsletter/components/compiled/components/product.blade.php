<mj-column
        @if(($block === 'double' || $block === 'triple') && $position === 0)
            padding-right="10px"
        @endif

        @if($block === 'triple' && $position === 1)
            padding-right="10px"
        @endif
>
    @if($product)
        @if($block === 'single')
            <mj-text mj-class="inner">
                <h2>
                    <a href="{{ $product->absolute_link }}">{{ $product->title }}</a>
                </h2>
            </mj-text>
        @endif

        <mj-image href="{{ $product->absolute_link }}" src="{{ $product->main_image }}" fluid-on-mobile="true"
        ></mj-image>

        <mj-text class="blue-links" padding="10px 0">
            <h3>
                <a href="{{ $product->absolute_link }}">{{ $product->title }}</a>
            </h3>
        </mj-text>

        <mj-text class="blue-links" padding-bottom="10px">
            {!! $description !!}
        </mj-text>

        <mj-text class="blue-links" padding-bottom="10px">
            <h1>
                &pound;{{ $product->currentPrice / 100 }}
            </h1>
        </mj-text>

        <mj-button href="{{ $product->absolute_link }}" padding="10px 0" @if($block === 'single') border-radius="6px"
                   font-size="20px" @endif>
            View Product
        </mj-button>
    @else
        <mj-text></mj-text>
    @endif
</mj-column>
