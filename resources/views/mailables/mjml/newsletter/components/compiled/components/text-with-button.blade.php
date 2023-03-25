<mj-column>
    @foreach($content as $line)
        <mj-text mj-class="inner">{!! $line !!}</mj-text>
    @endforeach

    <mj-button href="{{ trim($link) }}" padding="10px 0" @if($block === 'single') border-radius="6px" font-size="20px" @endif>
        {{ $label }}
    </mj-button>
</mj-column>
