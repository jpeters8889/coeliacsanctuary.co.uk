<mj-column>
    <mj-text mj-class="inner">
        <h3>
            @if($link)<a href="{{ trim($link) }}" css-class="blue-links"> @endif
                    {{ $title }}
            @if($link) </a>@endif
        </h3>
    </mj-text>
</mj-column>
