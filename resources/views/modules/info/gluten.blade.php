@extends('templates.page-single-column')

@section('primary-column')
    <div class="flex flex-col">
        <div class="page-box">
            <h1 class="my-4 p-3 text-4xl font-coeliac text-center font-semibold leading-tight border-b border-t border-blue-light">
                Gluten Challenge
            </h1>

            <h6 class="text-center -mt-4 pt-1">
                <a class="text-sm font-semibold font-sans hover:text-blue-dark transition-all" href="/info">
                    More Coeliac Information
                </a>
            </h6>

            <div class="flex flex-col mt-4 main-body">
                <p>
                    If you have been on a gluten free diet and you or your doctor decide you should be tested for
                    Coeliac you will need to take part in something which has been dubbed as a "gluten challenge" before
                    being tested as there will not be enough gluten/damage to the villi in the intestines to show a
                    positive result even if you are the most sensitive Coeliac.
                </p>

                <p>
                    There isn't really any official guidelines on HOW much you should eat if you have to undertake a
                    gluten challenge, but it seems that a lot of people don't eat enough for them to get a positive
                    Coeliac biopsy. This is only a rough guideline of how much you should eat each day for the 6-8 weeks
                    before the biopsy, you are always free to eat more of course, remember to aim for a substantial
                    amount, any other time zero gluten is the objective but not for this!
                </p>
                <p>
                    <strong>
                        Aim to eat 10g or more per day, this averages at at least 4 portions of the samples below.
                    </strong>
                </p>
                <p>
                    Remember the examples below are only guides to how much gluten is in them and not necessarily 100%
                    correct and are not the only things you can eat, anything derived from wheat, barley or rye will
                    contain gluten.
                </p>

                <table>
                    <tr>
                        <td><strong>Food Type</strong></td>
                        <td><strong>Serving (each serving providing 2-3g of gluten)</strong></td>
                    </tr>
                    <tr>
                        <td>Biscuits</td>
                        <td>
                            3 medium sized biscuits (digestives, cookies etc), 4 small biscuits (custard creams,
                            bourbons etc)
                        </td>
                    </tr>
                    <tr>
                        <td>Bread</td>
                        <td>One medium slice, two small slices or one bread roll</td>
                    </tr>
                    <tr>
                        <td>Cakes</td>
                        <td>One slice, one cupcake or an average size sponge pudding</td>
                    </tr>
                    <tr>
                        <td>Cereal</td>
                        <td>One weetabix, one shredded wheat, one bowl of sugar puffs</td>
                    </tr>
                    <tr>
                        <td>Flour</td>
                        <td>30g of any wheat based flour</td>
                    </tr>
                    <tr>
                        <td>Pasta</td>
                        <td>60g pasta either fresh, dried or canned</td>
                    </tr>
                </table>

                <p>
                    Remember, while you can, make sure you go and splurge on all those gluten filled things you can't
                    usually have, fish and chips, dumplings, the most calorific cakes you can find. The only time you
                    can say "I need to eat if for my health".
                </p>
            </div>
        </div>
    </div>
@endsection
