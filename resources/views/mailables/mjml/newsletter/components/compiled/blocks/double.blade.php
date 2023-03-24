<mj-wrapper>
    <mj-section css-class="multi-block double">
        @isset($block['properties'][0]['component']['name'])
            <livewire:is
                    :component="'coeliac-newsletter-compiled-component-'.$block['properties'][0]['component']['name']"
                    :properties="$block['properties'][0]['component']['properties']"
            ></livewire:is>
        @endisset

        @isset($block['properties'][1]['component']['name'])
            <livewire:is
                    :component="'coeliac-newsletter-compiled-component-'.$block['properties'][1]['component']['name']"
                    :properties="$block['properties'][1]['component']['properties']"
            ></livewire:is>
        @endisset
    </mj-section>
</mj-wrapper>
