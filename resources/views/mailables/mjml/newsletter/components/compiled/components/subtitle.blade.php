<mj-column>
    <mj-text mj-class="inner">
        <h3>
            @if($link)<a href="{{ $link}} "> @endif
                    {{ $title }}
            @if($link) </a>@endif
        </h3>
    </mj-text>
</mj-column>
