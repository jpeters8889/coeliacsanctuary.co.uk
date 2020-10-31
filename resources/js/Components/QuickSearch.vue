<template>
    <div v-if="showBox" class="js-search-modal z-max fixed inset-0 w-full h-full bg-black-80 flex justify-center items-center px-4"
         @click.self="hide()">
        <div class="w-full max-w-modal-small max-h-full bg-white rounded-lg">
            <div class="flex flex-col">
                <div class="leading-none flex flex-wrap justify-center text-xs bg-grey-light py-2 px-4 rounded-t-lg">
                    <div v-for="(checked, area) in areas" class="px-1">
                        <form-checkbox :value="checked" :label="labelFor(area)" input-size="text-xs"
                                       :name="area"></form-checkbox>
                    </div>
                </div>
                <div class="flex items-center justify-between py-2 px-4">
                    <div>
                        <font-awesome-icon :icon="['fas', 'search']"></font-awesome-icon>
                    </div>
                    <div class="flex-1">
                        <input v-model="searchText" ref="searchText" type="search" class="w-full border-0 text-lg pl-2"
                               maxlength="50" max="50"
                               placeholder="What are you looking for?" @keyup="search()" />
                    </div>
                </div>
                <div class="flex flex-col scrollable h-3/4 max-h-search" v-if="searchText !== ''">
                    <div v-if="results.length > 0" v-for="(result, index) in results"
                         class="border-b border-grey-off-light leading-tight"
                         :class="index % 2 === 0 ? 'bg-grey-light' : ''">
                        <component :is="resultComponent(result.type)" :result="result"></component>
                    </div>
                    <div v-else>
                        <em>No results found...</em>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import LazyLoadsImages from "../Mixins/LazyLoadsImages";
    import GoogleEvents from "../Mixins/GoogleEvents";
    import FormCheckbox from "./Forms/FormCheckbox";
    import BlogResult from "./Search/BlogResult";
    import EateryResult from "./Search/EateryResult";
    import RecipeResult from "./Search/RecipeResult";
    import ReviewResult from "./Search/ReviewResult";
    import ShopProductResult from "./Search/ShopProductResult";

    export default {
        mixins: [GoogleEvents, LazyLoadsImages],

        components: {
            'form-checkbox': FormCheckbox,
            'search-blog-result': BlogResult,
            'search-eatery-result': EateryResult,
            'search-recipe-result': RecipeResult,
            'search-review-result': ReviewResult,
            'search-shop-product-result': ShopProductResult,
        },

        data: () => ({
            timeout: null,

            showBox: false,

            searchText: '',
            areas: {
                blogs: true,
                reviews: true,
                recipes: true,
                eateries: false,
                products: true,
            },

            results: [],
        }),

        mounted() {
            this.$root.$on('show-quick-search', () => {
                this.googleEvent('event', 'search', {
                    event_label: 'opened',
                });

                this.show();
            });

            Object.keys(this.areas).forEach((area) => {
                this.$root.$on(`${area}-change`, (value) => {
                    this.areas[area] = !!value;

                    if (this.searchText !== '') {
                        this.search();
                    }
                });
            });
        },

        methods: {
            search() {
                if (this.timeout) {
                    clearTimeout(this.timeout);
                }

                this.timeout = setTimeout(() => {
                    this.results = [];
                    coeliac().request().post('/api/search', {
                        search: this.searchText,
                        areas: this.areas,
                    }).then((response) => {
                        this.googleEvent('event', 'search', {
                            event_label: this.searchText,
                        });

                        if (response.status === 200) {
                            this.results = response.data;
                        }

                        this.loadLazyImages();
                    });
                }, 500);
            },

            labelFor(area) {
                if (area === 'products') {
                    return 'Shop';
                }

                return area.charAt(0).toUpperCase() + area.slice(1);
            },

            show() {
                document.querySelector('body').classList.add('overflow-hidden');
                this.showBox = true;

                setTimeout(() => {
                    this.$refs['searchText'].focus();
                }, 100);
            },

            hide() {
                this.showBox = false;
                document.querySelector('body').classList.remove('overflow-hidden');
            },

            resultComponent(type) {
                switch (type) {
                    case 'blogs':
                        return 'search-blog-result';
                    case 'eateries':
                        return 'search-eatery-result';
                    case 'reviews':
                        return 'search-review-result';
                    case 'recipes':
                        return 'search-recipe-result';
                    case 'shopproducts':
                        return 'search-shop-product-result';
                }
            }
        },
    }
</script>
