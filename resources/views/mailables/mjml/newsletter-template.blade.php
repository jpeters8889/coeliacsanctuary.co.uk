<mjml>
    <mj-head>
        <mj-font name="Raleway" href="https://fonts.googleapis.com/css?family=Raleway"/>
        <mj-style> a {color:black;font-weight:bold;text-decoration:none} a:hover {text-decoration:underline;} h1
            {font-size:30px;text-align:center;margin:10px 0 0; padding:0;color:#000} h2,h3 {margin:0;padding:0;}
        </mj-style>
        <mj-style inline="inline"> .blue-links a { color: #29719f !important; }</mj-style>
        <mj-attributes>
            <mj-all font-family="Raleway, Arial" text-align="left" padding="0"/>
            <mj-text align="left" color="#555" font-size="16px" padding="0"/>
            <mj-section background-color="#fff" padding="10px"/>
            <mj-column padding="0"/>
            <mj-button background-color="#DBBC25" padding="0" font-size="15px" font-weight="bold"/>
            <mj-table font-size="15px"></mj-table>
            <mj-class name="blue" background-color="#80CCFC"></mj-class>
            <mj-class name="yellow" background-color="#DBBC25"></mj-class>
            <mj-class name="inner" padding="5px 0"></mj-class>
            <mj-class name="gray" background-color="#eeeeee"></mj-class>
            <mj-class name="social" padding="0"></mj-class>
        </mj-attributes>
    </mj-head>
    <mj-body background-color="#f7f7f7">
        <mj-container background-color="#f7f7f7">
            <mj-wrapper>
                <mj-section mj-class="blue" padding="5px">
                    <mj-column>
                        <mj-text align="center" font-size="14px"> Having trouble viewing this email? <a
                                href="::webviewUrl::">View
                                Online</a>
                        </mj-text>
                    </mj-column>
                </mj-section>
                <mj-section mj-class="blue">
                    <mj-column>
                        <mj-image src="{{ asset('assets/email/logo.jpg') }}"></mj-image>
                    </mj-column>
                    <mj-column vertical-align="bottom">
                        <mj-text align="right" padding-bottom="20px">
                            <img src="{{ asset('assets/email/fb.gif') }}" style="margin-right:5px"/>
                            <img src="{{ asset('assets/email/tw.gif') }}" style="margin-right:5px"/>
                            <img src="{{ asset('assets/email/gp.gif') }}" style="margin-right:5px"/>
                            <img src="{{ asset('assets/email/in.gif') }}" style="margin-right:5px"/>
                            <img src="{{ asset('assets/email/pn.gif') }}"/>
                        </mj-text>
                    </mj-column>
                </mj-section>
                <mj-section mj-class="yellow" padding="4px 10px">
                    <mj-text align="right">
                        {{ date('d/m/Y')  }}
                    </mj-text>
                </mj-section>
            </mj-wrapper>
            <mj-wrapper>
                <mj-section>
                    <mj-column css-class="blue-links">
                        <mj-text mj-class="inner" padding-bottom="10px">
                            <h2>Hey there!</h2>
                        </mj-text>
                        @foreach($introLines as $line)
                            <mj-text mj-class="inner">{!! $line !!}</mj-text>
                        @endforeach
                        <mj-text mj-class='inner'>We hope to message you guys again in a few weeks!</mj-text>
                        <mj-text mj-class="inner">
                            <h3>The Coeliac Sanctuary Team</h3>
                        </mj-text>
                    </mj-column>
                </mj-section>
                <mj-section>
                    <mj-column>
                        <mj-image href="https://www.coeliacsanctuary.co.uk/shop" src="{{ asset('assets/email/banner.png') }}"/>
                    </mj-column>
                </mj-section>
                <mj-section>
                    <mj-column>
                        <mj-divider border-width="2px" border-style="dashed" border-color="#DBBC25"/>
                    </mj-column>
                </mj-section>
                <mj-section>
                    <mj-column css-class="blue-links">
                        <mj-text mj-class="inner" padding-top="0" padding-bottom="10px">
                            <h2>Coeliac Sanctuary Recipes</h2>
                        </mj-text>
                        <mj-text> Here at Coeliac Sanctuary we love working on recipes, we now have over 250 in our
                            collection ranging from breakfasts and lunches to cakes, pastries and snacks.
                        </mj-text>
                    </mj-column>
                </mj-section>
                <mj-section>
                    @foreach($recipes as $recipe)
                        <mj-column padding="3px">
                            <mj-image padding-bottom="10px" src="{{ $recipe->square_image ?: $recipe->main_image }}"/>
                            <mj-text css-class="blue-links" padding-bottom="10px">
                                <a href="{{ config('app.url').'/recipe/'.$recipe->slug }}">
                                    <h3>{{ $recipe->title }}</h3>
                                </a>
                            </mj-text>
                            <mj-text>{{ $recipe->meta_description }}</mj-text>
                        </mj-column>
                    @endforeach
                </mj-section>
                <mj-section>
                    <mj-column>
                        <mj-text css-class="blue-links" padding-bottom="10px">
                            <a href="{{ config('app.url').'/recipe' }}">
                                <h3>See more recipes...</h3>
                            </a>
                        </mj-text>
                    </mj-column>
                </mj-section>
                <mj-section>
                    <mj-column>
                        <mj-divider border-width="2px" border-style="dashed" border-color="#DBBC25"/>
                    </mj-column>
                </mj-section>
                <mj-section>
                    <mj-column css-class="blue-links">
                        <mj-text mj-class="inner" padding-top="0" padding-bottom="10px">
                            <h2>Coeliac Sanctuary Blogs and Reviews</h2>
                        </mj-text>
                        <mj-text> There are so many blogs and reviews on the website, whether you are looking for
                            cooking inspiration or tips, news on gluten free products or interested in reviews of
                            eateries or products, there is sure to be something to pique your interest!
                        </mj-text>
                    </mj-column>
                </mj-section>
                <mj-section>
                    @foreach($blogs as $blog)
                        <mj-column padding="3px">
                            <mj-image padding-bottom="10px" src="{{ $blog->main_image }}"/>
                            <mj-text css-class="blue-links" padding-bottom="10px">
                                <a href="{{ config('app.url').'/blog/'.$blog->slug }}">
                                    <h3>{{ $blog->title }}</h3>
                                </a>
                            </mj-text>
                            <mj-text>{{ $blog->meta_description }}</mj-text>
                        </mj-column>
                    @endforeach
                </mj-section>
                <mj-section>
                    @foreach($reviews as $review)
                        <mj-column padding="3px">
                            <mj-image padding-bottom="10px" src="{{ $review->main_image }}"/>
                            <mj-text css-class="blue-links" padding-bottom="10px">
                                <a href="{{ config('app.url').'/review/'.$review->slug }}">
                                    <h3>
                                        {{ $review->title }} -
                                        {{ $review->eatery->town->town }}, {{ $review->eatery->county->county }}
                                    </h3>
                                </a>
                            </mj-text>
                            <mj-text>{{ $review->meta_description }}</mj-text>
                        </mj-column>
                    @endforeach
                </mj-section>
                <mj-section>
                    <mj-column>
                        <mj-text css-class="blue-links">
                            <a href="{{ config('app.url').'/blog' }}">
                                <h3>See more blogs...</h3>
                            </a>
                        </mj-text>
                    </mj-column>
                    <mj-column>
                        <mj-text css-class="blue-links">
                            <a href="{{ config('app.url').'/review' }}">
                                <h3>See more reviews...</h3>
                            </a>
                        </mj-text>
                    </mj-column>
                </mj-section>
                <mj-section>
                    <mj-column>
                        <mj-divider border-width="2px" border-style="dashed" border-color="#DBBC25"/>
                    </mj-column>
                </mj-section>
            </mj-wrapper>
            <mj-wrapper>
                <mj-section mj-class="gray">
                    <mj-column>
                        <mj-text mj-class="inner" padding-bottom="10px">
                            <h2>Elsewhere on Coeliac Sanctuary</h2>
                        </mj-text>
                        <mj-text css-class="blue-links" padding-bottom="10px">
                            <a href="">
                                <h3>Places to Eat</h3>
                            </a>
                        </mj-text>
                        <mj-text mj-class="inner">We have over 1,700 independent eateries listed on the website so we
                            are sure you will find somewhere who can cater to Coeliac where ever you are within the UK.
                            Here's a few random choices:-
                        </mj-text>
                    </mj-column>
                </mj-section>

                @foreach($eateries as $eatery)
                    <mj-section mj-class="gray">
                        <mj-column css-class="blue-links">
                            <mj-text mj-class="inner" padding-bottom="0" font-size="17px" color="black">
                                <strong>{{ $eatery->name }}</strong></mj-text>
                            <mj-text mj-class="inner" padding-bottom="0">{{ $eatery->info }}</mj-text>
                            <mj-text mj-class="inner" padding-bottom="0">
                                <a href="{{ config('app.url').'/wheretoeat/'.$eatery->county->slug.'/'.$eatery->town->slug }}">
                                    {{ $eatery->town->town }}, {{ $eatery->county->county }}
                                </a>
                            </mj-text>
                        </mj-column>
                    </mj-section>
                @endforeach

                <mj-section mj-class="gray">
                    <mj-column>
                        <mj-text css-class="blue-links" padding-bottom="10px">
                            <a href="{{ config('app.url').'/wheretoeat' }}">
                                <h3>Find more places to eat in our Eating Out guide</h3>
                            </a>
                        </mj-text>
                    </mj-column>
                </mj-section>
            </mj-wrapper>

            <mj-wrapper>
                <mj-section mj-class="yellow" padding="5px"></mj-section>
                <mj-section mj-class="blue" padding="10px">
                    <mj-column>
                        <mj-text align="center"> This one off email was sent to ::subscriber.email:: because you are
                            signed up to the Coeliac Sanctuary mailing list.
                        </mj-text>
                        <mj-text>&nbsp;</mj-text>
                        <mj-text>We'd hate to see you go, but if you wish to unsubscribe, please <a
                                href="::unsubscribeUrl::">click
                                here</a>.
                        </mj-text>
                        <mj-text>&nbsp;</mj-text>
                        <mj-text align="center" font-size="12px"> CoeliacSanctuary.co.uk, PO Box 643, Crewe, Cheshire,
                            CW1 9LJ, United Kingdom
                        </mj-text>
                    </mj-column>
                </mj-section>
            </mj-wrapper>
        </mj-container>
    </mj-body>
</mjml>
