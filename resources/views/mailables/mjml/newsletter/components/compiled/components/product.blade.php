@if($product)
@if($block === 'single')
    <mj-wrapper>
        <mj-section class="no-padding">
            <mj-column>
                <mj-text mj-class="inner">
                    <h2>
                        <a href="{{ $product->absolute_link }}">{{ $product->title }}</a>
                    </h2>
                </mj-text>
            </mj-column>
        </mj-section>
    </mj-wrapper>
@endif

<mj-wrapper>
    <mj-section class="no-padding">
        <mj-column>
            <mj-image href="{{ $product->absolute_link }}" src="{{ $product->main_image }}"></mj-image>
        </mj-column>
    </mj-section>
</mj-wrapper>
<mj-wrapper>
    <mj-section class="no-padding">
        <mj-column>
                <mj-text class="blue-links" padding-bottom="10px">
                    <h3>
                        <a href="{{ $product->absolute_link }}">{{ $product->title }}</a>
                    </h3>
                </mj-text>
                <mj-text class="blue-links">
                    {!! $block === 'single' ? $product->description : $product->meta_description !!}
                </mj-text>
            <mj-text class="blue-links">
                <h1>
                    &pound;{{ $product->currentPrice / 100 }}
                </h1>
            </mj-text>
        </mj-column>
    </mj-section>
</mj-wrapper>
<mj-wrapper>
    <mj-section class="no-padding">
        <mj-column>
            <mj-button href="{{ $product->absolute_link }}" @if($block === 'single') border-radius="6px" font-size="20px" @endif>
                View Product
            </mj-button>
        </mj-column>
    </mj-section>
</mj-wrapper>
@else
    <mj-text></mj-text>
@endif
