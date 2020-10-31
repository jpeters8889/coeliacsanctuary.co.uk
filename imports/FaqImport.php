<?php

declare(strict_types=1);

namespace Imports;

use Coeliac\Common\Models\AccordionType;

class FaqImport extends Import
{
    public function handle()
    {
        $accordions = [
            [
                'title' => 'How long has Coeliac Sanctuary been going?',
                'body' => '<p>
                            Coeliac Sanctuary began life on 7th August 2014 and has been continuously growing since.
                            Initially the site started as a personal hobby to get Alison back into work after illness
                            and anxiety and a place for her to list places who offered gluten free for future reference.
                            However over the months Coeliac Sanctuary has become extremely popular with thousands of
                            Coeliacs and has now turned into a place thousands of people come to looking for places to
                            eat and gluten free recipes every week.
                        </p>',
            ],
            [
                'title' => 'How do I sign up for your newsletter?',
                'body' => '<p>
                            To sign up for the newsletter you simply have to enter your email address in the newsletter
                            box which is on the homepage and some other pages. You can also sign up on our Facebook.
                        </p>
                        <p>
                            If you wish you unsubscribe you can by clicking the "unsubscribe" link at the bottom of
                            every email. You will receive no more emails once unsubscribed but you can resubscribe at
                            any time be reentering your email on the website.
                        </p>',
            ],
            [
                'title' => 'How can I contact you?',
                'body' => '<p>
                            There are multiple ways of contacting us; via our
                            <a style="display: inline-block!important; cursor: pointer"><contact-trigger>contact form</contact-trigger></a>, by email
                            <a title="Email"
                               href="mailto:contact@coeliacsanctuary.co.uk">contact@coeliacsanctuary.co.uk</a>,
                            or via our
                            <a title="Facebook" href="https://www.facebook.com/coeliacsanctuary" target="_blank">Facebook</a>
                            or
                            <a title="Twitter" href="https://twitter.com/CoeliacSanc" target="_blank">Twitter</a>
                        </p>',
            ],
            [
                'title' => 'You have typing errors in your blog/recipe/review, can you fix them?',
                'body' => '<p>
                            Yes, we can, just let us know, where and what they are. Due to Alison\'s Fibromyalgia she
                            writes the content (eventually) but misses details such as typing errors and grammatical
                            mistakes so relies on a second person to proof read, however they aren\'t perfect and do miss
                            errors sometimes too.
                        </p>',
            ],
            [
                'title' => 'I have a place to add to your Eating Out guide, how can I add them?',
                'body' => '<p>
                            If you own or have been somewhere that cater to gluten free diets then please
                            <a title="Contact Us" href="/wheretoeat/place-request">contact us</a> with the name and
                            the location and we will get them added as soon as possible.
                        </p>',
            ],
            [
                'title' => 'There is a place on your list that doesn\'t exist anymore, can you remove?',
                'body' => '<p>
                            We can remove a place if you <a title="Contact Us" href="/wheretoeat/place-request">contact
                                us</a> with which place no long caters or has ceased trading.
                        </p>',
            ],
            [
                'title' => 'How did you find all the places in the Where to Eat guide?',
                'body' => '<p>
                            The vast majority of the places in our Where to Eat guide are recommended to us by our
                            website visitors, when we receive a recommendation it gets added to our list to check, then
                            at a later date we will choose a random selection to add to the website and we will then
                            attempt to verify each place to make sure it exists and actually does Gluten Free food, we
                            do this by looking at their own website or Facebook page, or looking for reviews online.
                        </p>',
            ],
            [
                'title' => 'I suggested a place to add but you haven\'t added it.',
                'body' => ' If you suggested a place for us to add to our guide but we haven\'t added it yet, its most
                            likely because we haven\'t had chance to yet, we\'ve got 100s of places to add listed and we
                            only get to add a few a week, when we decide to add places we choose a random selection from
                            the list and then verify each one to make sure they exist and offer Gluten Free food, we do
                            this by checking their own website, Facebook page, or looking for reviews. Once we\'ve
                            checked the place does Gluten Free food it gets added to our guide.
                        </p>',
            ],
            [
                'title' => 'What is a blog and what\'s yours about?',
                'body' => '<p>
                            A blog is basically an online log or diary, ours is mainly focused on Coeliac related
                            subjects but Alison will go astray sometimes and talk about other things, but they are
                            usually at least loosely based around Coeliac or gluten related subjects.
                        </p>',
            ],
            [
                'title' => 'All your recipes are in gas mark, can you tell me the temperature in fahrenheit or celsius?',
                'body' => '<p>
                            We put together a conversion chart just for you.
                        </p>
                        <table>
                            <tr>
                                <td><strong>Gas Mark</strong></td>
                                <td><strong>Farenheit</strong></td>
                                <td><strong>Celcius</strong></td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>275&deg;F</td>
                                <td>140&deg;C</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>300&deg;F</td>
                                <td>150&deg;C</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>325&deg;F</td>
                                <td>170&deg;C</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>350&deg;F</td>
                                <td>180&deg;C</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>375&deg;F</td>
                                <td>190&deg;C</td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>400&deg;F</td>
                                <td>200&deg;C</td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>425&deg;F</td>
                                <td>220&deg;C</td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>450&deg;F</td>
                                <td>230&deg;C</td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>475&deg;F</td>
                                <td>240&deg;C</td>
                            </tr>
                        </table>',
            ],
            [
                'title' => 'All your recipes are in grams, but I want to use a different measurement. What\'s the
                        conversion?',
                'body' => '<p>
                            Here\'s a conversion chart if you need to change measurement units
                        </p>
                        <table>
                            <tr>
                                <td><strong>Grams</strong></td>
                                <td><strong>Ounce</strong></td>
                            </tr>
                            <tr>
                                <td>57g</td>
                                <td>2oz</td>
                            </tr>
                            <tr>
                                <td>85g</td>
                                <td>3oz</td>
                            </tr>
                            <tr>
                                <td>114g</td>
                                <td>4oz</td>
                            </tr>
                            <tr>
                                <td>142g</td>
                                <td>5oz</td>
                            </tr>

                            <tr>
                                <td>170g</td>
                                <td>6oz</td>
                            </tr>
                            <tr>
                                <td>198g</td>
                                <td>7oz</td>
                            </tr>
                            <tr>
                                <td>227g</td>
                                <td>8oz</td>
                            </tr>
                            <tr>
                                <td>255g</td>
                                <td>9oz</td>
                            </tr>
                            <tr>
                                <td>283g</td>
                                <td>10oz</td>
                            </tr>
                        </table>
                        <br /><br />
                        <table>
                            <tr>
                                <td><strong>Food Item</strong></td>
                                <td><strong>Gram/Cup Equivalent</strong></td>
                            </tr>
                            <tr>
                                <td>Butter</td>
                                <td>240g/1 Cup</td>
                            </tr>
                            <tr>
                                <td>Cornflour</td>
                                <td>120g/1 Cup</td>
                            </tr>
                            <tr>
                                <td>Flour</td>
                                <td>120g/1 Cup</td>
                            </tr>
                            <tr>
                                <td>Granulated Sugar</td>
                                <td>200g/1 Cup</td>
                            </tr>
                            <tr>
                                <td>Ground Nuts</td>
                                <td>120g/1 Cup</td>
                            </tr>
                            <tr>
                                <td>Icing Sugar</td>
                                <td>100g/1 Cup</td>
                            </tr>
                            <tr>
                                <td>Oats</td>
                                <td>90g/1 Cup</td>
                            </tr>
                            <tr>
                                <td>Rice</td>
                                <td>190g/1 Cup</td>
                            </tr>
                            <tr>
                                <td>Salt</td>
                                <td>75g/&frac14; Cup</td>
                            </tr>
                            <tr>
                                <td>Sultanas</td>
                                <td>200g/1 Cup</td>
                            </tr>
                        </table>',
            ],
            [
                'title' => 'How do you work out nutritional info on your recipes?',
                'body' => '<p>
                            Our nutritional info may not always be 100% accurate as we rely on
                            <a title="My Fitness Pal" href="https://www.myfitnesspal.com" target="_blank">My
                                Fitness Pal</a> to provide the information for us, most of the time it is accurate but
                            the odd times it may be slightly off. The nutritional info will also depend on what brands
                            you use, the brands we used in the recipes may have different nutritional details than what
                            you are using, making them differ from what our info says.
                        </p>',
            ],
            [
                'title' => 'I don\'t require dairy free food, can I use normal dairy products on dairy free recipes?',
                'body' => '<p>
                            For the most part, yes you can, on the majority of the dairy free recipes we have added a
                            note for how you can alter it so it is not dairy free, these suggestions are usually as
                            simple as margarine instead of soya spread, natural yogurt instead of soya yogurt etc
                        </p>',
            ],
            [
                'title' => 'There are no reviews in my area, will there ever be any?',
                'body' => '<p>
                            We travel round as and when we can, as you can probably tell we are located in North England
                            so more reviews are in this area, however we try to review wherever we can get too, keep
                            checking back to see if there has been any reviews in your area added as we are forever
                            going to different places.
                        </p>',
            ],
            [
                'title' => 'I don\'t agree with your review, please change it?',
                'body' => '<p>Yes we have had this asked on reviews before, generally the answer will be no, the reviews are
                        done based on the opinion of Alison (and sometimes Jamie, and sometimes even Alison\'s parents),
                        other opinions are welcomed to be expressed in the comments if you don\'t agree. However if you
                        are the owner of the establishment, we may relent and alter the review, but not change our
                        personal view.</p>',
            ],
            [
                'title' => 'I\'m recently diagnosed, where can I get more info?',
                'body' => '<p>
                            We have lots of information about Coeliac in our <a title="Info" href="/info">info</a>
                            section, including a storecupboard staples list and beginners shopping list. If you still
                            require more info <a title="Coeliac UK" href="https://www.coeliac.org.uk" target="_blank">Coeliac
                                UK</a> is the official place to head and find out lots of details.
                        </p>',
            ],
        ];

        AccordionType::query()
            ->find(AccordionType::FAQ)
            ->accordions()
            ->createMany($accordions);
    }
}
