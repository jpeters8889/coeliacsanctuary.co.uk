<mj-column>
    <mj-text mj-class="inner" padding-bottom="10px" css-class="blue-links">
        <h2>
            @if($link)<a href="{{ trim($link)}}"> @endif
                    {{ $title }}
            @if($link) </a>@endif
        </h2>
    </mj-text>
</mj-column>