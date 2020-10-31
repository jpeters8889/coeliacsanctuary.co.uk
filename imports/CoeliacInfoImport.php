<?php

declare(strict_types=1);

namespace Imports;

use Coeliac\Common\Models\AccordionType;

class CoeliacInfoImport extends Import
{
    public function handle()
    {
        $accordions = [
            [
                'title' => 'About Coeliac Disease',
                'body' => '<p>
                        Coeliac is an autoimmune disorder which is triggered by gluten. Estimations show that around 1
                        in 100 people in the UK have Coeliac (1% of the population) but many are misdiagnosed so it is
                        thought that only around 24% of that 1% have confirmed diagnosis.
                    </p>
                    <p>
                        With Coeliac the immune system mistakenly attacks itself when gluten is consumed, accidentally
                        mistaking gluten as a threat to the body. This attack on itself causes damage to the surface of
                        the small intestine, the villi, which absorb nutrients from food. In a healthy intestine the
                        villi stand up straight trapping the food between, however with Coeliac suffers the villi are
                        flattened preventing absorption from food.
                    </p>
                    <p>
                        Coeliac is NOT an allergy or intolerance. It is a disease where gluten CAN cause harm to the
                        body. With intolerance there is no long term lasting damage.
                    </p>',
            ],
            [
                'title' => 'What is Gluten?',
                'body' => '<p>
                        Gluten (basically means "glue") is a protein which is found in certain cereals, it acts as a
                        glue to give the cereals structure and texture. Gluten gives elasticity to dough and helps baked
                        products to rise and keep shape.
                    </p>
                    <p>
                        The cereals gluten is found in are :-
                    </p>
                    <ul>
                        <li>Wheat</li>
                        <li>Barley</li>
                        <li>Rye</li>
                    </ul>',
            ],
            [
                'title' => 'Can I eat Gluten?',
                'body' => '<p>
                        No. Granted you will no doubt end up accidentally ingesting gluten occasionally though every
                        effort should be made to avoid eating it. If you eat gluten you will no doubt suffer from
                        whatever symptoms you have experienced before, whether that is stomach cramps, diarrhoea,
                        bloating etc, or some other symptom, however if you intentionally ingest gluten you are also
                        damaging the villi in your intestines more, therefore causing lasting harm to your body. Some
                        people are "silent Coeliacs" and don\'t get any symptoms, however this does not mean your villi
                        are not being damaged when you eat gluten.
                    </p>',
            ],
            [
                'title' => 'What are the symptoms of Coeliac?',
                'body' => '<p>
                        Because Coeliac is an autoimmune disease it can have many different symptoms, however the most
                        common are:-
                    </p>
                    <ul>
                        <li>Diarrhoea</li>
                        <li>Constipation</li>
                        <li>Vomiting and/or Nausea</li>
                        <li>Unexplained gastrointestinal problems</li>
                        <li>Regular stomach pain or cramps</li>
                        <li>Iron deficiency</li>
                        <li>Tiredness</li>
                        <li>Headaches</li>
                        <li>Weightloss</li>
                        <li>Malnutrition</li>
                        <li>Hair Loss</li>
                        <li>Skin Rash</li>
                        <li>Mouth Ulcers</li>
                        <li>Tooth Enamel Issues</li>
                        <li>Osteoporosis</li>
                        <li>Depression</li>
                        <li>Infertility</li>
                        <li>Join Pain</li>
                        <li>Bone Pain</li>
                        <li>Nerve Problems such as Ataxia and Neuropathy</li>
                    </ul>
                    <p>
                        Coeliac is commonly mistaken as Irritable Bowel Syndrome (IBS) as it shares many of the same
                        symptoms, however according to guidelines GP\'s are now advised to test for Coeliac in everyone
                        suspected of having IBS before making a diagnosis.
                    </p>',
            ],
            [
                'title' => 'What causes Coeliac?',
                'body' => '<p>
                        The exact cause of Coeliac isn\'t known, it is thought it can be stress related, it can also be
                        inherited (it is proven you are at higher risk if you have a relative with Coeliac) and some
                        believe environmental factors can play a part, otherwise it is unclear what may have an effect.
                    </p>',
            ],
            [
                'title' => 'Am I at risk?',
                'body' => '<p>
                        You are at increased risk of developing Coeliac if :-
                    </p>
                    <ul>
                        <li>A family member has Coeliac;</li>
                        <li>You have Type 1 Diabetes;</li>
                        <li>You have Irritable Bowel Syndrome;</li>
                        <li>You have another autoimmune disorder;</li>
                        <li>You suffer from anaemia;</li>
                        <li>You have a neurological disorder;</li>
                        <li>You have a chromosomal disorder;</li>
                    </ul>
                    <p>
                        Women are up to three times more likely to contract Coeliac than men.
                    </p>
                    <p>
                        Although the disease can manifest at any time the most common age group are between the ages of
                        8 and 12 and between 40 and 60.
                    </p>',
            ],
            [
                'title' => 'I have a family member with Coeliac, what is the likelihood I have it?',
                'body' => '<p>
                        Depending on the relation depends on the risk level, here are the current figures for risk
                        levels :-
                    </p>
                    <table>
                        <tr>
                            <td>
                                <strong>Relation</strong>
                            </td>
                            <td>Level of Risk</td>
                        </tr>
                        <tr>
                            <td>
                                Daughter
                            </td>
                            <td>
                                1 in 8 chance
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Son
                            </td>
                            <td>
                                1 in 13 chance
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Brother
                            </td>
                            <td>
                                1 in 16 chance
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Sister
                            </td>
                            <td>
                                1 in 7 chance
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Father
                            </td>
                            <td>
                                1 in 29 chance
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Mother
                            </td>
                            <td>
                                1 in 32 chance
                            </td>
                        </tr>
                    </table>',
            ],
            [
                'title' => 'Testing for Coeliac',
                'body' => '<p>
                        In the UK, Coeliac is most commonly tested for by a blood test followed by an endoscopy. For the
                        test to be accurate you will be required to eat gluten products with each meal for 6-8 weeks
                        (this is sometimes know as the <a title="Gluten Challenge" href="/info/gluten-challenge">gluten
                            challenge</a>) prior to the tests. If you fail to eat gluten the test is likely to come back
                        negative even if you do have Coeliac. According to a lot of GP\'s the test can also be inaccurate
                        despite consumption of gluten, diagnosis in some people can take many years, in others it can be
                        confirmed in one test.
                    </p>',
            ],
            [
                'title' => 'Treating Coeliac',
                'body' => '<p>
                        There is no cure for Coeliac, the only way of treating it is to partake in a gluten free diet,
                        this will control the symptoms and help prevent long term consequences. Even if you don\'t show
                        symptoms but have been diagnosed with Coeliac you should still change your diet as you are still
                        causing harm to your body.
                    </p>',
            ],
            [
                'title' => 'Food Labelling',
                'body' => '<p>
                        From 13th December 2014 it became compulsory that any of the 14 most common allergens are
                        clearly marked on pre-packed food and food sold loose and allergen information must be available
                        written and/or verbally on food sold in restaurants, cafes and delis.<br /><br /> Allergens must
                        be clearly visible in the ingredients list of food products, manufacturers can choose to
                        highlight the allergens in any way including using a<span style="color:#ff0000;">different colour</span>
                        text, using <em>italics</em> or <span style="text-decoration:underline;">underline</span>, or
                        the most commonly used way, <strong>bold</strong> text. The following allergens are the 14 which
                        will have to be highlighted :-
                    </p>
                    <ul>
                        <li>Cereals which contain gluten, i.e. barley, rye and wheat</li>
                        <li>Crustaceans</li>
                        <li>Fish</li>
                        <li>Eggs</li>
                        <li>Peanuts</li>
                        <li>Nuts such as almonds, hazelnuts, pecans, pistachios etc</li>
                        <li>Soybeans</li>
                        <li>Milk</li>
                        <li>Celery and celeriac</li>
                        <li>Mustard</li>
                        <li>Sesame</li>
                        <li>Sulphur dioxide (found in some dried fruits)</li>
                        <li>Lupin</li>
                        <li>Molluscs</li>
                    </ul>
                    <p>
                        Following the use of this new system, allergen information boxes e.g. "Contains gluten and milk"
                        will no longer be allowed to be printed on product packaging due to the allergens already being
                        highlighted in the ingredients list. However if cross contamination is a risk factor
                        manufacturers are allowed to specify a "may contain" warning but legally doesn\'t have to be
                        printed on products, it is only down to courtesy from the manufacturer if they print it or not.
                    </p>
                    <p>
                        In restaurants, cafes and delis allergens must be clearly specified either on a chart, chalk
                        board or orally by a staff member, if the allergens are not specified upfront there must be
                        clear signposts to where the information can be obtained. Again this rule only covers the 14
                        major allergy groups.
                    </p>
                    <p>
                        The new rule does not cover accidental presence of cross contamination, such as when eating out
                        and small pieces of other food items could fall onto deli counters or bowls, therefore you still
                        need to be vigilante when it comes to cross contamination and buying loose food.
                    </p>',
            ],
            [
                'title' => 'I\'ve just been diagnosed, what can I do?',
                'body' => '<p>
                        Being diagnosed at first can be overwhelming, especially when it means a sudden change in diet
                        and cutting out a lot of foods you probably used to eat regularly.
                    </p>
                    <p>
                        The easiest way to deal with the change is to try and get the whole house hold to change to a
                        gluten free diet, getting rid of any gluten containing items. However we can\'t all live in that
                        kind of ideal situation, therefore the next best thing would be to clear out a cupboard to keep
                        all your gluten free items separate, buy separate towels and cleaning cloths as gluten can get
                        caught in towel fibres and getting your own to dry your pots will help reduce cross
                        contamination. If possible also get your own utensils and toaster (if you can\'t get a separate
                        toaster, toaster bags are just as good). Buy a separate set of cutting boards too so you can
                        make sure all your gluten free can be done in a different area, if possible try and use a
                        different work surface to prepare gluten containing items. The more you can do to reduce the
                        risk of cross contamination the better.
                    </p>
                    <p>
                        Finding out what you should and shouldn\'t buy can all be a pain to work out, take a look at our
                        beginners<a title="Beginners Shopping List" href="/info/shopping-list">shopping list</a> guide
                        if you need some ideas!
                    </p>
                    <p>
                        You can also find a list of what contains, may contain and is gluten free right <a
                                title="Storecupboard Checklist" href="/info/storecupboard-check">here</a>.
                    </p>',
            ],
            [
                'title' => 'What does and doesn\'t contain Gluten?',
                'body' => '<p>
                        Some of the items which contain gluten are obvious, such as bread containing wheat, but some
                        other items such as ketchup and soy sauce you need to check. We have compiled a list of what you
                        need to check and what is naturally gluten free for you to refer too, you can find that right
                        <a title="Storecupbard Checklist" href="/info/storecupboard-check">here</a>.
                    </p>',
            ],
            [
                'title' => 'Can I eat oats with Coeliac?',
                'body' => '<p>
                        Yes and no. Some people with Coeliac can\'t tolerate eating oats because they can suffer "cross
                        contamination" due to being grown with wheat. Other people cannot tolerate oats due to the
                        protein, Avenin, in them being similar to gluten. It is usually advised that Coeliacs should not
                        eat oats for 12 months after being diagnosed, after the gut has healed, only "Pure Oats" should
                        be consumed, these are oats which haven\'t been grown with other cereals and have been deemed
                        gluten free.
                    </p>',
            ],
            [
                'title' => 'Coeliac and Lactose Intolerance',
                'body' => '<p>
                        A very common side effect of Coeliac is Lactose intolerance, if you have Coeliac you are at a
                        high risk of developing lactose intolerance, especially at the beginning, once a gluten free
                        diet commences lactose intolerance often goes as the gut begins healing itself.
                    </p>
                    <p>
                        Lactose is a protein found in dairy products such as milk, cheese and ice cream. The amount of
                        lactose you can tolerate is dependant on your body, some people may be able to tolerate small
                        amounts, other may not be able to tolerate any.
                    </p>
                    <p>
                        Lactose intolerance doesn\'t damage the intestines unlike Coeliac however it does cause
                        gastrointestinal problems such as stomach pains, nausea and diarrhoea.
                    </p>
                    <p>
                        There is no treatment for Lactose intolerance except to cut out lactose containing products, to
                        make sure you still get enough calcium in your diet it is suggested you either take calcium
                        supplements or use dairy alternatives such as soya milk.
                    </p>',
            ],
            [
                'title' => 'Non-Coeliac Gluten Intolerance (Gluten Intolerance)',
                'body' => '<p>
                        If you are having issues with gluten but don\'t have Coeliac you could have Non Coeliac Gluten
                        Intolerance. With NCGI you may experience similar pains and cramps to Coeliac however unlike
                        with Coeliac the villi in the intestines aren\'t being subjected to damage when gluten is eaten,
                        the villi remain intact. However as with Coeliac it is suggested that a gluten free diet is
                        undertaken to help control symptoms. Gluten intolerance may be due to unsuccessful diagnosis of
                        Coeliac or a reaction in other components of wheat rather than the gluten itself.
                    </p>',
            ],
        ];

        AccordionType::query()
            ->find(AccordionType::COELIAC_INFO)
            ->accordions()
            ->createMany($accordions);
    }
}
