<mj-wrapper>
    <mj-section css-class="multi-block triple">
        @isset($block['properties'][0]['component']['name'])
            <livewire:is
                    :component="'coeliac-newsletter-compiled-component-'.$block['properties'][0]['component']['name']"
                    :properties="$block['properties'][0]['component']['properties']"
                    block="triple"
                    :position="0"
            ></livewire:is>
        @endisset

        @isset($block['properties'][1]['component']['name'])
            <livewire:is
                    :component="'coeliac-newsletter-compiled-component-'.$block['properties'][1]['component']['name']"
                    :properties="$block['properties'][1]['component']['properties']"
                    block="triple"
                    :position="1"
            ></livewire:is>
        @endisset

        @isset($block['properties'][2]['component']['name'])
            <livewire:is
                    :component="'coeliac-newsletter-compiled-component-'.$block['properties'][2]['component']['name']"
                    :properties="$block['properties'][2]['component']['properties']"
                    block="triple"
                    :position="2"
            ></livewire:is>
        @endisset
    </mj-section>
</mj-wrapper>
