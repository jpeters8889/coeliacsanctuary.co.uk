<mj-wrapper>
    <mj-section mj-class="blue" padding="5px">
        <mj-column>
            <mj-text align="center" font-size="14px"> Having trouble viewing this email? <a href="::webviewUrl::">View Online</a>
            </mj-text>
        </mj-column>
    </mj-section>
    <mj-section mj-class="blue">
        <mj-column>
            <mj-image src="{{ config('app.url') }}/assets/email/logo.jpg"></mj-image>
        </mj-column>
        <mj-column vertical-align="bottom">
        </mj-column>
    </mj-section>
    <mj-section mj-class="yellow" padding="4px 10px">
        <mj-column>
            <mj-text align="right">{{ date('jS F Y')  }}</mj-text>
        </mj-column>
    </mj-section>
</mj-wrapper>
