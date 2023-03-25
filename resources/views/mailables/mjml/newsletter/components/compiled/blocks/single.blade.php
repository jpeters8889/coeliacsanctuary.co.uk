<mj-wrapper>
    <mj-section>
            @isset($block['properties'][0]['component']['name'])
                <livewire:is :component="'coeliac-newsletter-compiled-component-'.$block['properties'][0]['component']['name']"
                             :properties="$block['properties'][0]['component']['properties']"
                             block="single"
                             :position="0"
                ></livewire:is>
            @endisset
    </mj-section>
</mj-wrapper>
