<mj-column>
    <mj-text mj-class="inner" padding-bottom="10px">
        <h2>
            @if($link)<a href="{{ trim($link)}}" css-class="blue-links"> @endif
                    {{ $title }}
            @if($link) </a>@endif
        </h2>
    </mj-text>
</mj-column>
