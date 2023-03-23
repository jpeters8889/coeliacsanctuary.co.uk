<mj-raw>
    <div>
</mj-raw>

<mj-wrapper>
    <mj-section>
        <mj-raw>
            <div class="border-4 border-gray-200" style="border-style: dashed;">
        </mj-raw>
        <mj-column>
            <mj-raw>
                <div>
                    @if($block['properties'][0]['component'])
                        <livewire:is :component="'coeliac-newsletter-editor-component-'.$block['properties'][0]['component']['name']"
                            :properties="$block['properties'][0]['component']['properties']"
                            :block-id="$block['id']"
                            index="0"
                        ></livewire:is>
                    @else
                        <livewire:coeliac-newsletter-add-component
                            :block-id="$block['id']"
                            :index="0"
                        ></livewire:coeliac-newsletter-add-component>
                    @endif
                </div>
            </mj-raw>
        </mj-column>
        <mj-raw></div></mj-raw>

    </mj-section>
</mj-wrapper>

<mj-raw></div></mj-raw>
