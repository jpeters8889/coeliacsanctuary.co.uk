<mj-column>
    <mj-text mj-class="inner" padding-bottom="10px">
        <h2>
            @if($link)<a href="{{ $link}} "> @endif
                    {{ $title }}
            @if($link) </a>@endif
        </h2>
    </mj-text>
</mj-column>
