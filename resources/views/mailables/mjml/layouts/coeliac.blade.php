<mjml>
    <mj-head>

        <mj-font name="Raleway" href="https://fonts.googleapis.com/css?family=Raleway" />

        <mj-style>
            a {color:black;font-weight:bold;text-decoration:none} a:hover {text-decoration:underline;} h1
            {font-size:30px;text-align:center;margin:10px 0 0; padding:0;color:#000} h2,h3 {margin:0;padding:0;}
        </mj-style>

        <mj-attributes>
            <mj-all font-family="Raleway, Arial" text-align="left" padding="0" />
            <mj-text align="left" color="#555" font-size="16px" padding="0" />
            <mj-section background-color="#fff" padding="10px" />
            <mj-column padding="0" />
            <mj-button background-color="#DBBC25" padding="0" font-size="15px" font-weight="bold" />
            <mj-table font-size="15px"></mj-table>
            <mj-class name="blue" background-color="#80CCFC"></mj-class>
            <mj-class name="yellow" background-color="#DBBC25"></mj-class>
            <mj-class name="inner" padding="5px 0"></mj-class>
            <mj-class name="social" padding="0"></mj-class>
        </mj-attributes>

    </mj-head>
    <mj-body background-color="#f7f7f7">
        <mj-container background-color="#f7f7f7">
            <mj-wrapper>
                @isset($key)
                    <mj-section mj-class="blue" padding="5px">
                        <mj-column>
                            <mj-text align="center" font-size="14px">Having trouble viewing this email? <a
                                    href="{{ config('app.url') }}/email/{{ $key }}">View Online</a></mj-text>
                        </mj-column>
                    </mj-section>
                @endisset
                <mj-section mj-class="blue">
                    <mj-column>
                        <mj-image src="{{ asset('assets/email/logo.jpg') }}"></mj-image>
                    </mj-column>
                    <mj-column vertical-align="bottom">
                        <mj-text align="right" padding-bottom="20px">
                            <img src="{{ asset('assets/email/fb.gif') }}" style="margin-right:5px" />
                            <img src="{{ asset('assets/email/tw.gif') }}" style="margin-right:5px" />
                            <img src="{{ asset('assets/email/gp.gif') }}" style="margin-right:5px" />
                            <img src="{{ asset('assets/email/in.gif') }}" style="margin-right:5px" />
                            <img src="{{ asset('assets/email/pn.gif') }}" />
                        </mj-text>
                    </mj-column>
                </mj-section>
                <mj-section mj-class="yellow" padding="4px 10px">
                    <mj-column>
                        <mj-text align="right">
                            {{ $date->format('d/m/Y')  }}
                        </mj-text>
                    </mj-column>
                </mj-section>
            </mj-wrapper>
            <mj-wrapper>
                @yield('main-content')
            </mj-wrapper>
            <mj-wrapper>
                <mj-section padding="20px 0 0">
                    <mj-column>
                        <mj-text>&nbsp;</mj-text>
                    </mj-column>
                </mj-section>
                <mj-section padding="10px" padding-top="15px" background-color="#f0f0f0">
                    <mj-column>
                        <mj-text>
                            <h2>Have you seen these {{ $relatedTitle }}?</h2>
                        </mj-text>
                    </mj-column>
                </mj-section>
                <mj-section padding="10px" background-color="#f0f0f0">
                    @foreach($relatedItems as $related)
                        <mj-column>
                            <mj-image padding="0 5px 5px" width="0" src="{{ $related['image'] }}"></mj-image>
                            <mj-text padding="0 5px 5px">
                                <h3><a href="{{ $related['link'] }}">{{ $related['title'] }}</a></h3>
                            </mj-text>
                        </mj-column>
                    @endforeach
                </mj-section>
            </mj-wrapper>
            <mj-wrapper>
                <mj-section mj-class="yellow" padding="5px"></mj-section>
                <mj-section mj-class="blue" padding="10px">
                    <mj-column>
                        <mj-text align="center">
                            This one off email was sent to {{ isset($notifiable) ? $notifiable->email : $email }} {{ $reason }}.
                        </mj-text>
                        <mj-text>&nbsp;</mj-text>
                        <mj-text align="center">If you believe this message was sent in error, please <a
                                style="color:#000;font-weight:bold;text-decoration:none;"
                                href="{{ config('app.url') }}/contact">contact us.</a></mj-text>
                        <mj-text>&nbsp;</mj-text>
                        <mj-text align="center" font-size="14px">
                            CoeliacSanctuary.co.uk, PO Box 643, Crewe, Cheshire, CW1 9LJ, United Kingdom
                        </mj-text>
                    </mj-column>
                </mj-section>
            </mj-wrapper>
        </mj-container>
    </mj-body>
</mjml>
