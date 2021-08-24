<template>
    <div>
        <div class="flex flex-col lg:flex-row">
            <div class="lg:w-1/4 lg:mr-4 lg:relative">
                <div id="searchCheck"></div>

                <div :class="filterClasses">
                    <div>
                        <form-input type="search" name="term" required :max="50" :value="currentTerm"></form-input>
                    </div>

                    <div class="leading-none flex flex-wrap justify-center text-xs lg:flex-no-wrap lg:flex-col">
                        <div v-for="(checked, area) in areas" class="px-1 lg:my-1">
                            <form-checkbox :value="checked" :label="labelFor(area)" input-size="text-xs lg:text-base"
                                           :name="area"></form-checkbox>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="loading" class="relative h-32 lg:flex-1">
                <loader :show="true"></loader>
            </div>

            <div v-else class="flex-1 flex flex-col mt-2 lg:mt-0" ref="items">
                <pagination :current="currentPage"
                            :lastPage="lastPage"
                            :can-go-back="currentPage > 1"
                            :can-go-forward="currentPage < lastPage"
                ></pagination>

                <div class="my-2">
                    <div v-if="results.length > 0" v-for="(result, index) in results"
                         class="border-b border-grey-off-light leading-tight"
                         :class="index % 2 === 0 ? 'bg-grey-light' : ''">
                        <component :is="resultComponent(result.type)" :result="result"
                                   :key="result.type+'-'+result.id"></component>
                    </div>
                    <div v-if="results.length === 0">
                        <em>No results found...</em>
                    </div>
                </div>

                <pagination :current="currentPage"
                            :lastPage="lastPage"
                            :can-go-back="currentPage > 1"
                            :can-go-forward="currentPage < lastPage"
                ></pagination>
            </div>
        </div>
    </div>
</template>

<script>
import LazyLoadsImages from "@/Mixins/LazyLoadsImages";

const Loader = () => import('~/Global/UI/Loader' /* webpackChunkName: "chunk-loader" */)
const FormInput = () => import('~/Forms/Input' /* webpackChunkName: "chunk-form-input" */)
const FormCheckbox = () => import('~/Forms/Checkbox' /* webpackChunkName: "chunk-form-checkbox" */)
const Pagination = () => import('~/Global/UI/Pagination' /* webpackChunkName: "chunk-pagination" */)

import BlogResult from "~/Search/Results/BlogResult";
import EateryResult from "~/Search/Results/EateryResult";
import RecipeResult from "~/Search/Results/RecipeResult";
import ReviewResult from "~/Search/Results/ReviewResult";
import ShopProductResult from "~/Search/Results/ShopProductResult";
import GoogleEvents from "@/Mixins/GoogleEvents";

export default {
    mixins: [GoogleEvents, LazyLoadsImages],

    props: {
        term: {
            required: true,
            type: String,
        }
    },

    components: {
        'loader': Loader,
        'form-input': FormInput,
        'form-checkbox': FormCheckbox,
        'pagination': Pagination,
        'search-blog-result': BlogResult,
        'search-eatery-result': EateryResult,
        'search-recipe-result': RecipeResult,
        'search-review-result': ReviewResult,
        'search-shop-product-result': ShopProductResult,
    },

    data: () => ({
        isSticky: false,

        areas: {
            blogs: true,
            reviews: true,
            recipes: true,
            eateries: false,
            products: true,
        },

        currentTerm: '',
        timeout: null,

        currentPage: 1,
        lastPage: 1,

        loading: true,

        results: [],
    }),

    mounted() {
        this.currentTerm = this.term;

        if (this.currentTerm === '') {
            this.loading = false;
            coeliac().error('Please enter a search term...')
        }

        this.$root.$on('term-change', (value) => {
            this.currentTerm = value;
        });

        this.$root.$on('pagination-click', (page) => {
            this.googleEvent('event', this.title, {
                event_category: 'navigate-page',
                event_label: page,
            });


            if (page === 'next') {
                page = this.currentPage + 1;
            }

            if (page === 'prev') {
                page = this.currentPage - 1;
            }

            this.currentPage = page;

            this.runSearch();
            this.$scrollTo(this.$refs.items, 500, {
                offset: -200,
            });
        });

        Object.keys(this.areas).forEach((area) => {
            this.$root.$on(`${area}-change`, (value) => {
                this.areas[area] = !!value;
            });
        });

        new IntersectionObserver(entries => {
            if (window.scrollY === 0) {
                this.isSticky = false;
                return;
            }
            this.isSticky = entries[0].intersectionRatio === 0;
        }).observe(document.querySelector('#searchCheck'));

        this.parseUrl();

        this.runSearch();
    },

    methods: {
        runSearch() {
            if (this.currentTerm === '') {
                this.results = [];
                return;
            }

            coeliac().request().post(`/api/search?page=${this.currentPage}`, {
                term: this.currentTerm,
                areas: this.areas,
            }).then((response) => {
                this.lastPage = response.data.last_page;
                this.results = response.data.data;
            }).catch(() => {
                this.results = [];

                coeliac().error('Sorry, there was an error running your search.');
            }).finally(() => {
                this.loading = false;
                this.updateUrl();
                this.updateTitle();
                this.loadLazyImages();
            })
        },

        updateUrl() {
            const params = new URLSearchParams(window.location.search);
            params.set('q', this.currentTerm);
            params.set('f', btoa(JSON.stringify(this.areas)));
            history.pushState(null, '', `${window.location.origin}${window.location.pathname}?${params.toString()}`);
        },

        updateTitle() {
            let title = document.querySelector('title');
            let titleParts = title.innerText.split(' | ');
            titleParts[0] = this.currentTerm;

            title.innerHTML = titleParts.join(' | ');
        },

        labelFor(area) {
            if (area === 'products') {
                return 'Shop';
            }

            return area.charAt(0).toUpperCase() + area.slice(1);
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
                case 'products':
                    return 'search-shop-product-result';
            }
        },

        parseUrl() {
            const params = new URLSearchParams(window.location.search);

            if (params.has('f')) {
                const areas = JSON.parse(atob(params.get('f')));

                if (JSON.stringify(Object.keys(areas)) === JSON.stringify(Object.keys(this.areas))) {
                    this.areas = areas;

                    Object.keys(areas).forEach((area) => {
                        this.$root.$on(`${area}-set-value`, areas[area]);
                    });
                }
            }
        },
    },

    computed: {
        filterClasses: function () {
            let base = ['p-2', 'flex', 'flex-col', 'lg:border', 'border-blue', 'lg:rounded-lg'];

            if (this.isSticky) {
                return base.concat(['bottom-0', 'left-0', 'bg-yellow', 'slide-up', 'w-full', 'z-max', 'lg:bg-grey-lightest', 'fixed', 'lg:sticky', 'lg:no-animation', 'lg:top-130px', 'lg:bottom-auto', 'lg:z-auto'])
            }

            return base.concat(['bg-blue-light', 'bg-opacity-20', 'lg:bg-grey-lightest', 'lg:bg-opacity-100']);
        }
    },

    watch: {
        currentTerm: function (newTerm, oldTerm) {
            if (oldTerm === '' || newTerm === oldTerm || newTerm === '') {
                return;
            }

            clearTimeout(this.timeout);

            this.timeout = setTimeout(() => {
                this.currentPage = 1;
                this.runSearch();
            }, 500);
        },

        areas: {
            deep: true,
            handler: function () {
                this.updateUrl();

                if (this.currentTerm !== '' && !this.loading) {
                    this.runSearch();
                }
            },
        }
    },
}
</script>
