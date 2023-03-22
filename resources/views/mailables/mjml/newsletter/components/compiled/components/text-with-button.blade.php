@foreach($content as $line)
    <mj-text mj-class="inner">{{ $line }}</mj-text>
@endforeach
</mj-column>
    </mj-section>
    </mj-wrapper>
    <mj-wrapper>
        <mj-section class="no-padding">
            <mj-column>
                <mj-button href="{{ $link }}" @if($block === 'single') border-radius="6px" font-size="20px" @endif>
                    {{ $label }}
                </mj-button>

