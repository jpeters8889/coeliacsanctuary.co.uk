<mjml>
    @include('mailables.mjml.newsletter.components.metas')
    <mj-body background-color="#f7f7f7">
        @include('mailables.mjml.newsletter.components.header')
        @foreach($blocks as $block)
            @include("mailables.mjml.newsletter.components.compiled.blocks.{$block['block']}")
        @endforeach

        @include('mailables.mjml.newsletter.components.footer')
    </mj-body>
</mjml>
