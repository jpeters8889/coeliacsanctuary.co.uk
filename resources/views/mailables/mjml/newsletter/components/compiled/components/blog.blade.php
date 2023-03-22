@if($blog)
@if($block === 'single')
    <mj-wrapper>
        <mj-section class="no-padding">
            <mj-column>
                <mj-text mj-class="inner">
                    <h2>
                        <a href="{{ $blog->absolute_link }}">{{ $blog->title }}</a>
                    </h2>
                </mj-text>
            </mj-column>
        </mj-section>
    </mj-wrapper>
@endif

<mj-wrapper>
    <mj-section class="no-padding">
        <mj-column>
            <mj-image href="{{ $blog->absolute_link }}" src="{{ $blog->main_image }}"></mj-image>
        </mj-column>
    </mj-section>
</mj-wrapper>
<mj-wrapper>
    <mj-section class="no-padding">
        <mj-column>
                <mj-text class="blue-links" padding-bottom="10px">
                    <h3>
                        <a href="{{ $blog->absolute_link }}">{{ $blog->title }}</a>
                    </h3>
                </mj-text>
                <mj-text class="blue-links">
                    {!! $block === 'single' ? $blog->description : $blog->meta_description !!}
                </mj-text>
        </mj-column>
    </mj-section>
</mj-wrapper>
<mj-wrapper>
    <mj-section class="no-padding">
        <mj-column>
            <mj-button href="{{ $blog->absolute_link }}" @if($block === 'single') border-radius="6px" font-size="20px" @endif>
                Read more
            </mj-button>
        </mj-column>
    </mj-section>
</mj-wrapper>
@else
    <mj-text></mj-text>
@endif
