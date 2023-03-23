<mj-wrapper>
    <mj-section>
        <mj-column>
            @isset($block['properties'][0]['component']['name'])
                <livewire:is :component="'coeliac-newsletter-compiled-component-'.$block['properties'][0]['component']['name']"
                             :properties="$block['properties'][0]['component']['properties']"
                ></livewire:is>
            @endisset
        </mj-column>

        <mj-column>
            @isset($block['properties'][1]['component']['name'])
                <livewire:is :component="'coeliac-newsletter-compiled-component-'.$block['properties'][1]['component']['name']"
                             :properties="$block['properties'][1]['component']['properties']"
                ></livewire:is>
            @endisset
        </mj-column>
    </mj-section>
</mj-wrapper>
