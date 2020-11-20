<template>
    <div class="page-box">
        <module-filter-slider :show="showFilters"
                              :title="title"
                              :total-results="response.total"
                              :current-filters="filters"
                              :current-search="searchText"
        ></module-filter-slider>

        <module-list-top-bar :title="title" :currentLayout="layout" :url-prefix="urlPrefix"
                             :currentSearch="searchText"></module-list-top-bar>

        <pagination :current="response.current_page"
                    :lastPage="response.last_page"
                    :can-go-back="!! response.prev_page_url"
                    :can-go-forward="!! response.next_page_url"
        ></pagination>

        <div v-if="hasFilters">
            <ul class="flex -m-1">
                <li v-if="searchText !== ''"
                    class="m-1 bg-blue-light rounded-lg text-xs overflow-hidden flex justify-between">
                    <div class="py-1 px-3">Search: {{ searchText }}</div>
                    <div class="bg-yellow py-1 px-3 cursor-pointer" @click="clearSearch">
                        <font-awesome-icon :icon="['fas', 'times']"></font-awesome-icon>
                    </div>
                </li>
                <template v-for="filter in availableFilters">
                    <li v-for="option in filters[filter.value]"
                        class="m-1 bg-blue-light rounded-lg text-xs overflow-hidden flex justify-between">
                        <div class="py-1 px-3">{{ filter.label }}: {{ option }}</div>
                        <div class="bg-yellow py-1 px-3 cursor-pointer" @click="removeFilter(filter.value, option)">
                            <font-awesome-icon :icon="['fas', 'times']"></font-awesome-icon>
                        </div>
                    </li>
                </template>
            </ul>
        </div>

        <div v-if="isLoading" class="relative h-64">
            <loader :show="true"></loader>
        </div>

        <div v-else>
            <div class="flex flex-col my-2 md:flex-row md:flex-wrap -mx-2" ref="items">
                <module-list-item
                        v-for="(item, index) in response.data"
                        :key="item.id"
                        :module="module"
                        :item="item"
                        :index="index"
                        :page="currentPage"
                        :layout="layout"
                        :has-filters="hasFilters">
                </module-list-item>
            </div>
        </div>

        <pagination :current="response.current_page"
                    :lastPage="response.last_page"
                    :can-go-back="!! response.prev_page_url"
                    :can-go-forward="!! response.next_page_url"
        ></pagination>
    </div>
</template>

<script>
    import AvailableFilters from "./Resources/AvailableFilters";
    import FilterableUrls from "../Mixins/FilterableUrls";
    import LazyLoadsImages from "../Mixins/LazyLoadsImages";
    import GoogleEvents from "../Mixins/GoogleEvents";
    import Loader from "./Loader";
    import ModuleFilterSlider from "./ModuleFilterSlider";
    import ModuleListItem from "./ModuleListItem";
    import ModuleListTopBar from "./ModuleListTopBar";
    import Pagination from "./Pagination";

    export default {
        mixins: [FilterableUrls, GoogleEvents, LazyLoadsImages],

        components: {
            'loader': Loader,
            'module-filter-slider': ModuleFilterSlider,
            'module-list-item': ModuleListItem,
            'module-list-top-bar': ModuleListTopBar,
            'pagination': Pagination,
        },

        props: {
            module: {
                required: true,
                validator: (value) => {
                    return ['blogs', 'recipes', 'reviews'].indexOf(value) !== -1;
                }
            },
            title: {
                required: true,
                type: String,
            },
            urlPrefix: {
                required: true,
                type: String,
            }
        },

        data: () => ({
            response: {
                current_page: 1,
                last_page: 1,
                prev_page_url: '',
                next_page_url: '',
                total: 0,
            },
            isLoading: true,
            currentPage: 1,
            layout: 'tiles',
            showFilters: false,
            availableFilters: [],
            filters: {},
            searchText: '',
        }),

        mounted() {
            this.availableFilters = AvailableFilters[this.module];

            this.availableFilters.forEach((filter) => {
                this.$set(this.filters, filter.value, []);
            });

            this.parseUrl();
            this.events();
            this.loadData();
        },

        methods: {
            loadData() {
                if (!this.showFilters) {
                    this.isLoading = true;
                }

                coeliac().request()
                    .get(this.buildUrl(`/api/${this.module}`, this.currentPage, this.searchText, this.filters))
                    .then((response) => {
                        this.response = response.data.data;
                        this.isLoading = false;

                        window.history.pushState(null, null, this.buildUrl(window.location.href.split('?')[0], this.currentPage, this.searchText, this.filters, true))
                    });
            },

            removeFilter(name, filter) {
                this.$root.$emit('remove-filter', {
                    name: name,
                    value: filter,
                });
            },

            clearSearch() {
                this.searchText = '';
                this.$root.$emit('reset-search', '');
            },

            events() {
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

                    this.loadData();
                    this.$scrollTo(this.$refs.items, 500, {
                        offset : -200,
                    });
                });

                this.$root.$on('layout-change', (layout) => {
                    this.googleEvent('event', this.title, {
                        event_category: 'layout-change',
                        event_label: layout,
                    });

                    this.layout = layout;

                    this.loadLazyImages();
                });

                this.$root.$on('add-filter', (filter) => {
                    this.googleEvent('event', this.title, {
                        event_category: 'added-filter',
                        event_label: filter.name,
                    });


                    if (filter.single) {
                        this.filters[filter.name] = [];
                    }

                    this.filters[filter.name].push(filter.value);

                    this.currentPage = 1;
                    this.loadData();
                });

                this.$root.$on('clear-filters', () => {
                    this.googleEvent('event', this.title, {
                        event_category: 'cleared-filters',
                    });

                    this.availableFilters.forEach((availableFilter) => {
                        this.filters[availableFilter.value] = [];
                    });

                    this.currentPage = 1;
                    this.loadData();
                });

                this.$root.$on('remove-filter', (filter) => {
                    this.googleEvent('event', this.title, {
                        event_category: 'removed-filter',
                        event_label: filter.name,
                    });


                    this.filters[filter.name] = this.filters[filter.name].filter((thisFilter) => {
                        return thisFilter !== filter.value;
                    });

                    this.loadData();
                });

                this.$root.$on('toggle-filter-bar', () => {
                    this.showFilters = !this.showFilters;
                });

                this.$root.$on('module-search', (search) => {
                    this.googleEvent('event', this.title, {
                        event_category: 'used-search',
                        event_label: search,
                    });


                    this.searchText = search;
                    this.loadData();
                });
            },

            parseUrl() {
                let urlBits = window.location.href.split('?o=');
                if (urlBits.length > 1) {
                    let queryStrings = atob(urlBits[1]).split('&');
                    queryStrings.forEach((queryString) => {
                        let [key, value] = queryString.split('=');

                        if (key === 'page') {
                            this.currentPage = parseInt(value);
                        }

                        if (key === 'search') {
                            this.searchText = value;
                        }

                        if (value !== '' && /filter\[([a-z\-]+)\]/m.exec(key) !== null) {
                            let matches = /filter\[([a-z\-]+)\]/m.exec(key);
                            this.filters[matches[1]] = value.split(',');
                        }
                    });
                }
            }
        },

        computed: {
            hasFilters() {
                let hasFilter = false;

                if (this.searchText !== '') {
                    hasFilter = true;
                }

                Object.keys(this.filters).forEach((filter) => {
                    if (this.filters[filter] && this.filters[filter].length > 0) {
                        hasFilter = true;
                    }
                });

                return hasFilter;
            }
        },
    }
</script>
