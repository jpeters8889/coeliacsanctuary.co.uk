<mj-column>
    <mj-text mj-class="inner" css-class="blue-links">
        <h3>
            @if($link)<a href="{{ trim($link) }}"> @endif
                    {{ $title }}
            @if($link) </a>@endif
        </h3>
    </mj-text>
</mj-column>
