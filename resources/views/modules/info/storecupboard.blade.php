@extends('templates.page-two-column')

@section('primary-column')
    <div class="flex flex-col"chunk>
        <div class="page-box">
            <h1 class="text-2xl font-coeliac text-center font-semibold leading-tight md:text-left">
                Storecupboard Checklist
                <a class="text-xs font-sans hover:text-grey transition-color" href="/info"><br />More Information</a>
            </h1>

            <div class="flex flex-col mt-4">
                <p>
                    So you know what you should check and what is naturally gluten free we have produced a storecupboard
                    list of what you should check and what you shouldn't. This list isn't definitive and there will be
                    variances between manufacturers and products but this should at least give a rough idea of what you
                    will need to check.
                </p>

                <div class="main-body">
                    <table>
                        <tr>
                            <th colspan="3">
                                Bread, Cereal, Pasta and Noodles
                            </th>
                        </tr>
                        <tr>
                            <td><strong>Naturally Gluten Free</strong></td>
                            <td><strong>May contain Gluten</strong></td>
                            <td><strong>Will contain Gluten</strong></td>
                        </tr>
                        <tr>
                            <td>
                                <ul class="list-none">
                                    <li>Buckwheat flakes</li>
                                    <li>Corn or rice pasta</li>
                                    <li>Gluten free breads</li>
                                    <li>Gluten free cereals</li>
                                    <li>Gluten free muesli</li>
                                    <li>Gluten free pasta</li>
                                    <li>Gluten free pizza bases</li>
                                    <li>Rice Noodles</li>
                                </ul>
                            </td>
                            <td>
                                <ul class="list-none">
                                    <li>Buckwheat Noodles</li>
                                    <li>Porridge Oats</li>
                                    <li>Soba Noodles</li>
                                </ul>
                            </td>
                            <td>
                                <ul class="list-none">
                                    <li>All breads made with wheat</li>
                                    <li>Crackers</li>
                                    <li>Noodles made with wheat</li>
                                    <li>Pasta made with wheat</li>
                                    <li>Pastries</li>
                                    <li>Wheat based cereals</li>
                                </ul>
                            </td>
                        </tr>

                        <tr>
                            <th colspan="3">
                                Condiments, Sauces and Gravy
                            </th>
                        </tr>
                        <tr>
                            <td><strong>Naturally Gluten Free</strong></td>
                            <td><strong>May contain Gluten</strong></td>
                            <td><strong>Will contain Gluten</strong></td>
                        </tr>
                        <tr>
                            <td>
                                <ul class="list-none">
                                    <li>Honey</li>
                                    <li>Pepper</li>
                                    <li>Salt</li>
                                    <li>Spices</li>
                                    <li>Sugar</li>
                                </ul>
                            </td>
                            <td>
                                <ul class="list-none">
                                    <li>Gravy</li>
                                    <li>Ketchup</li>
                                    <li>Sauces</li>
                                    <li>Stocks</li>
                                    <li>Stuffing</li>
                                </ul>
                            </td>
                            <td></td>
                        </tr>

                        <tr>
                            <th colspan="3">
                                Dairy
                            </th>
                        </tr>
                        <tr>
                            <td><strong>Naturally Gluten Free</strong></td>
                            <td><strong>May contain Gluten</strong></td>
                            <td><strong>Will contain Gluten</strong></td>
                        </tr>
                        <tr>
                            <td>
                                <ul class="list-none">
                                    <li>Buttermilk</li>
                                    <li>Cream</li>
                                    <li>Fromage frais</li>
                                    <li>Hard cheese</li>
                                    <li>Natural yogurt</li>
                                </ul>
                            </td>
                            <td>
                                <ul class="list-none">
                                    <li>Fruit flavoured yogurts</li>
                                    <li>Soft cheese</li>
                                    <li>Soya desserts</li>
                                </ul>
                            </td>
                            <td>
                                <ul class="list-none">
                                    <li>Yogurts with muesli</li>
                                </ul>
                            </td>
                        </tr>

                        <tr>
                            <th colspan="3">
                                Desserts
                            </th>
                        </tr>
                        <tr>
                            <td><strong>Naturally Gluten Free</strong></td>
                            <td><strong>May contain Gluten</strong></td>
                            <td><strong>Will contain Gluten</strong></td>
                        </tr>
                        <tr>
                            <td>
                                <ul class="list-none">
                                    <li>Jelly</li>
                                    <li>Rice pudding</li>
                                </ul>
                            </td>
                            <td>
                                <ul class="list-none">
                                    <li>Frozen yogurt</li>
                                    <li>Ice cream</li>
                                </ul>
                            </td>
                            <td>
                                <ul class="lsit-none">
                                    <li>Pancakes</li>
                                    <li>Pastries</li>
                                    <li>Puddings</li>
                                </ul>
                            </td>
                        </tr>

                        <tr>
                            <th colspan="3">
                                Drinks
                            </th>
                        </tr>
                        <tr>
                            <td><strong>Naturally Gluten Free</strong></td>
                            <td><strong>May contain Gluten</strong></td>
                            <td><strong>Will contain Gluten</strong></td>
                        </tr>
                        <tr>
                            <td>
                                <ul class="list-none">
                                    <li>Cider</li>
                                    <li>Coffee</li>
                                    <li>Fruit Juice</li>
                                    <li>Gluten free beers</li>
                                    <li>Sherry</li>
                                    <li>Spirits</li>
                                    <li>Tea</li>
                                    <li>Wine</li>
                                </ul>
                            </td>
                            <td>
                                <ul class="list-none">
                                    <li>Fizzy drinks</li>
                                    <li>Hot chocolate</li>
                                    <li>Hot drinks from vending machines</li>
                                    <li>Squash</li>
                                </ul>
                            </td>
                            <td>
                                <ul class="list-none">
                                    <li>Barley squashes</li>
                                    <li>Beer</li>
                                    <li>Malted drinks</li>
                                </ul>
                            </td>
                        </tr>

                        <tr>
                            <th colspan="3">
                                Fresh Produce
                            </th>
                        </tr>
                        <tr>
                            <td><strong>Naturally Gluten Free</strong></td>
                            <td><strong>May contain Gluten</strong></td>
                            <td><strong>Will contain Gluten</strong></td>
                        </tr>

                        <tr>
                            <td>
                                <ul class="list-none">
                                    <li>Eggs</li>
                                    <li>Fresh fish</li>
                                    <li>Fresh meat and poultry</li>
                                    <li>Fruit</li>
                                    <li>Potatoes</li>
                                    <li>Vegetables</li>
                                </ul>
                            </td>
                            <td>
                                <ul class="list-none">
                                    <li>Chips</li>
                                    <li>Mash potato</li>
                                </ul>
                            </td>
                            <td>
                                <ul class="list-none">
                                    <li>Pie fillings</li>
                                </ul>
                            </td>
                        </tr>

                        <tr>
                            <th colspan="3">
                                Grains, Cereals and Flour
                            </th>
                        </tr>
                        <tr>
                            <td><strong>Naturally Gluten Free</strong></td>
                            <td><strong>May contain Gluten</strong></td>
                            <td><strong>Will contain Gluten</strong></td>
                        </tr>
                        <tr>
                            <td>
                                <ul class="list-none">
                                    <li>Amaranth</li>
                                    <li>Arrowroot</li>
                                    <li>Buckwheat</li>
                                    <li>Carob</li>
                                    <li>Cassava</li>
                                    <li>Chestnut flour</li>
                                    <li>Corn</li>
                                    <li>Gluten free flours</li>
                                    <li>Gram flour</li>
                                    <li>Millet</li>
                                    <li>Polenta</li>
                                    <li>Quinoa</li>
                                    <li>Rice</li>
                                    <li>Sorghum</li>
                                    <li>Soya</li>
                                    <li>Tapioca</li>
                                    <li>Teff</li>
                                </ul>
                            </td>
                            <td>
                                <ul class="list-none">
                                    <li>Oats</li>
                                </ul>
                            </td>
                            <td>
                                <ul class="list-none">
                                    <li>Baking powder</li>
                                    <li>Barley</li>
                                    <li>Barley malt</li>
                                    <li>Bulgar Wheat</li>
                                    <li>Couscous</li>
                                    <li>Durum wheat</li>
                                    <li>Kamut</li>
                                    <li>Rusk</li>
                                    <li>Rye</li>
                                    <li>Semolina</li>
                                    <li>Spelt</li>
                                    <li>Triticale</li>
                                    <li>Wheat</li>
                                    <li>Wheat bran</li>
                                </ul>
                            </td>
                        </tr>

                        <tr>
                            <th colspan="3">
                                Processed and Prepared Food
                            </th>
                        </tr>
                        <tr>
                            <td><strong>Naturally Gluten Free</strong></td>
                            <td><strong>May contain Gluten</strong></td>
                            <td><strong>Will contain Gluten</strong></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <ul class="list-none">
                                    <li>Burgers</li>
                                    <li>Frozen chips and potato products</li>
                                    <li>Pates</li>
                                    <li>Processed cheese</li>
                                    <li>Processed meat</li>
                                    <li>Ready meals</li>
                                    <li>Sausages</li>
                                    <li>Soups</li>
                                </ul>
                            </td>
                            <td>
                                <ul class="list-none">
                                    <li>Breaded meats</li>
                                    <li>Haggis</li>
                                    <li>Meat or fish in breadcrumbs</li>
                                    <li>Products in batter</li>
                                    <li>Scotch Eggs</li>
                                </ul>
                            </td>
                        </tr>

                        <tr>
                            <th colspan="3">
                                Snacks
                            </th>
                        </tr>
                        <tr>
                            <td><strong>Naturally Gluten Free</strong></td>
                            <td><strong>May contain Gluten</strong></td>
                            <td><strong>Will contain Gluten</strong></td>
                        </tr>
                        <tr>
                            <td>
                                <ul class="list-none">
                                    <li>Gluten free pretzels</li>
                                    <li>Nuts and seeds</li>
                                    <li>Plain popcorn</li>
                                    <li>Rice cakes</li>
                                </ul>
                            </td>
                            <td>
                                <ul class="list-none">
                                    <li>Chocolate</li>
                                    <li>Crisps</li>
                                    <li>Dry roast nuts</li>
                                    <li>Ice Cream</li>
                                    <li>Meringue</li>
                                </ul>
                            </td>
                            <td>
                                <ul class="list-none">
                                    <li>Biscuits</li>
                                    <li>Cakes</li>
                                    <li>Crumpets</li>
                                    <li>Pancakes</li>
                                    <li>Pretzels</li>
                                    <li>Shortbread</li>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('secondary-column')
    <div class="flex flex-col">
        <widget-newsletter-signup class="mb-3"></widget-newsletter-signup>

        @include('components.related-item', [$related, $title = 'Recent Blogs'])
    </div>
@endsection
