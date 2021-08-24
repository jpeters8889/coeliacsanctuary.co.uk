<template>
    <div class="w-full my-3 flex lg:space-x-1">
        <div
            v-if="isGte('lg') || showFilterModal"
            class="fixed flex w-full h-full top-0 left-0 p-4 bg-black bg-opacity-50 z-max lg:relative lg:w-1/3 xl:w-1/4 lg:p-0 lg:bg-none lg:h-auto lg:z-auto"
        >
            <div class="bg-white w-full shadow overflow-hidden lg:shadow-none">
                <div
                    class="flex justify-between mb-2 text-xl py-2 px-4 bg-grey-off-light border-b border-grey-off lg:bg-white">
                    <h2 class="font-semibold">Filter Results</h2>
                    <div class="cursor-pointer" @click="showFilterModal = false">
                        <font-awesome-icon :icon="['fas', 'times']"></font-awesome-icon>
                    </div>
                </div>
                <div class="px-4 overflow-y-scroll h-full pb-12 mb-1">
                    <div class="border-b border-grey-off-dark pb-2"
                         v-if="places.length > 0">
                        <a
                            class="bg-yellow bg-opacity-50 p-2 border-yellow border flex flex-col items-center justify-center text-center space-y-3"
                            :href="`/wheretoeat/browse/${places[0].lat},${places[0].lng}/13`"
                        >
                            <img :src="mapUrl" alt=""/>
                            <h3 class="text-lg font-semibold">View map of {{ places[0].town.town }}</h3>
                            <p class="text-xs">
                                Check out our interactive map of places to eat in and around {{ places[0].town.town }}!
                            </p>
                        </a>
                    </div>

                    <div class="border-b border-grey-off-dark pb-2">
                        <h3 class="text-lg font-semibold mb-2">Show Categories</h3>

                        <ul class="flex flex-col space-y-2">
                            <li
                                v-for="category in filters.categories"
                                class="flex-1 flex cursor-pointer group select-none"
                                @click="category.checked = !category.checked"
                            >
                                <div
                                    class="mr-2 w-5 h-5 border border-black rounded-sm text-xs leading-none flex justify-center items-center transition-all flex-shrink-0"
                                    :class="category.checked ? 'text-white bg-black' : 'bg-white text-grey-off-light group-hover:text-grey-off-dark'"
                                >
                                    <font-awesome-icon :icon="['fas', 'check']"></font-awesome-icon>
                                </div>

                                <div>{{ category.label }} ({{ category.count || '0' }})</div>
                            </li>
                        </ul>
                    </div>

                    <div class="border-b border-grey-off-dark py-2">
                        <h3 class="text-lg font-semibold mb-2">Show Venue Types</h3>

                        <ul class="flex flex-col space-y-2">
                            <li
                                v-for="venueType in filters.venueTypes"
                                class="flex-1 flex cursor-pointer group select-none"
                                @click="venueType.checked = !venueType.checked"
                            >
                                <div
                                    class="mr-2 w-5 h-5 border border-black rounded-sm text-xs leading-none flex justify-center items-center transition-all flex-shrink-0"
                                    :class="venueType.checked ? 'text-white bg-black' : 'bg-white text-grey-off-light group-hover:text-grey-off-dark'"
                                >
                                    <font-awesome-icon :icon="['fas', 'check']"></font-awesome-icon>
                                </div>

                                <div>{{ venueType.label }} ({{ venueType.count || '0' }})</div>
                            </li>
                        </ul>
                    </div>

                    <div class="border-b border-grey-off-dark py-2">
                        <h3 class="text-lg font-semibold mb-2">Special Features</h3>

                        <ul class="flex flex-col space-y-2">
                            <li
                                v-for="feature in filters.features"
                                class="flex-1 flex cursor-pointer group select-none"
                                @click="feature.checked = !feature.checked"
                            >
                                <div
                                    class="mr-2 w-5 h-5 border border-black rounded-sm text-xs leading-none flex justify-center items-center transition-all flex-shrink-0"
                                    :class="feature.checked ? 'text-white bg-black' : 'bg-white text-grey-off-light group-hover:text-grey-off-dark'"
                                >
                                    <font-awesome-icon :icon="['fas', 'check']"></font-awesome-icon>
                                </div>

                                <div>{{ feature.label }} ({{ feature.count || '0' }})</div>
                            </li>
                        </ul>
                    </div>

                    <div class="border-b border-grey-off-dark py-2" v-if="countyId !== 1">
                        <h3 class="text-lg font-semibold mb-2">Average Rating</h3>

                        <ul class="flex flex-col space-y-2">
                            <li
                                v-for="rating in filters.ratings"
                                class="flex-1 flex cursor-pointer group select-none"
                                @click="rating.checked = !rating.checked"
                            >
                                <div
                                    class="mr-2 w-5 h-5 border border-black rounded-sm text-xs leading-none flex justify-center items-center transition-all flex-shrink-0"
                                    :class="rating.checked ? 'text-white bg-black' : 'bg-white text-grey-off-light group-hover:text-grey-off-dark'"
                                >
                                    <font-awesome-icon :icon="['fas', 'check']"></font-awesome-icon>
                                </div>

                                <div>{{ rating.label }} ({{ rating.count || '0' }})</div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="fixed bottom-0 right-0 p-5 lg:hidden z-max">
            <div
                class="w-16 h-16 rounded-full bg-blue text-white text-3xl flex justify-center items-center cursor-pointer shadow-lg z-max"
                v-tooltip.left="{content: 'View Filters', classes: ['bg-yellow', 'text-black', 'rounded-lg']}"
                @click="showFilterModal = !showFilterModal;"
            >
                <font-awesome-icon :icon="['fas', 'list']"></font-awesome-icon>
            </div>
        </div>

        <div class="lg:w-2/3 xl:w-3/4">
            <div>
                <div v-if="!isLoading && places.length === 0" class="bg-white w-full p-2 mx-2">
                    <p class="text-red text-lg my-2">Sorry, no results found!</p>
                </div>

                <div v-if="places.length" class="lg:-mt-2 lg:-mr-2">
                    <div
                        v-for="(place, index) in places"
                        :key="place.id"
                        v-observe-visibility="hasMore && index === places.length - 1 ? {callback: visibilityChanged, once:true} : false"
                        class="flex flex-col p-3 bg-white m-2"
                    >
                        <wheretoeat-ui-place-details :place="place"/>
                    </div>
                </div>

                <wheretoeat-ui-sleleton-loader v-if="isLoading"/>

            </div>
        </div>
    </div>
</template>

<script>
import FilterableUrls from "@/Mixins/FilterableUrls";

const Loader = () => import('~/Global/UI/Loader' /* webpackChunkName: "chunk-loader" */)
const Pagination = () => import('~/Global/UI/Pagination' /* webpackChunkName: "chunk-pagination" */)
import Vue from "vue";
import VueObserveVisibility from 'vue-observe-visibility'
import ResponsiveOptions from "@/Mixins/ResponsiveOptions";
import { VTooltip } from "v-tooltip";
import WhereToEatPlaceDetails from "~/WhereToEat/UI/WhereToEatPlaceDetails";
import WhereToEatPlaceSkeletonLoader from "~/WhereToEat/UI/WhereToEatPlaceSkeletonLoader";

Vue.directive('tooltip', VTooltip)
Vue.use(VueObserveVisibility)

export default {
    mixins: [FilterableUrls, ResponsiveOptions],

    components: {
        'wheretoeat-ui-place-details': WhereToEatPlaceDetails,
        'wheretoeat-ui-sleleton-loader': WhereToEatPlaceSkeletonLoader
    },

    props: {
        countyId: {
            type: Number,
            default: null,
        },
        townId: {
            type: Number,
            default: null,
        },
        searchTerm: {
            type: String,
            default: null,
        },
        searchRange: {
            type: String,
            default: null,
        }
    },

    data: () => ({
        showFilterModal: false,

        currentPage: 1,
        perPage: 5,
        hasMore: false,

        isLoading: true,
        noResults: false,

        places: [],

        filters: {
            categories: [
                {
                    label: 'Eateries',
                    count: 0,
                    id: 1,
                    checked: true,
                },
                {
                    label: 'Attractions',
                    count: 0,
                    id: 2,
                    checked: true,
                },
                {
                    label: 'Hotels',
                    count: 0,
                    id: 3,
                    checked: true,
                }
            ],
            venueTypes: [],
            features: [],
            ratings: [],
        },

        filterTimeout: null,
    }),

    mounted() {
        this.getData();
    },

    methods: {
        async getData() {
            this.isLoading = true;
            this.noResults = false;

            await this.getSummary();
            await this.getVenueTypes();
            await this.getFeatures();
            await this.getRatings();

            this.getPlaces();
        },

        async getSummary() {
            const response = await coeliac().request()
                .get(this.buildUrl('/api/wheretoeat/summary', 1, this.searchText, this.currentFilters), {validateStatus: false})

            return new Promise(resolve => {
                if (response.status !== 200) {
                    resolve(true);
                }

                this.filters.categories[0].count = response.data.eateries;
                this.filters.categories[1].count = response.data.attractions;
                this.filters.categories[2].count = response.data.hotels;

                resolve(true);
            });
        },

        async getVenueTypes() {
            const response = await coeliac().request()
                .get(this.buildUrl('/api/wheretoeat/venueTypes', 1, this.searchText, this.currentFilters), {validateStatus: false})

            return new Promise((resolve) => {
                if (response.status !== 200) {
                    resolve(true);
                }

                this.filters.venueTypes = response.data.map((data) => {
                    data['checked'] = false;

                    return data;
                });

                resolve(true);
            });
        },

        async getFeatures() {
            const response = await coeliac().request()
                .get(this.buildUrl('/api/wheretoeat/features', 1, this.searchText, this.currentFilters), {validateStatus: false})

            return new Promise((resolve) => {
                if (response.status !== 200) {
                    resolve(true);
                }

                this.filters.features = response.data.map((data) => {
                    data['checked'] = false;

                    return data;
                });

                resolve(true);
            });
        },

        async getRatings() {
            const response = await coeliac().request()
                .get(this.buildUrl('/api/wheretoeat/ratings', 1, this.searchText, this.currentFilters), {validateStatus: false})

            return new Promise((resolve) => {
                if (response.status !== 200) {
                    resolve(true);
                }

                this.filters.ratings = response.data.map((data) => {
                    data['checked'] = false;

                    return data;
                });

                resolve(true);
            });
        },

        getPlaces() {
            coeliac().request()
                .get(this.buildUrl('/api/wheretoeat', this.currentPage, this.searchText, this.currentFilters, false, this.perPage))
                .then((response) => {
                    this.places.push(...response.data.data.data);

                    this.places.forEach((place, index) => {
                        if (response.data.data.appends[place.id]) {
                            Object.keys(response.data.data.appends[place.id]).forEach((key) => {
                                this.$set(this.places[index], key, response.data.data.appends[place.id][key])
                            });
                        }
                    });

                    this.hasMore = this.currentPage < response.data.data.last_page;
                })
                .catch(() => {
                    this.noResults = true;
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },

        visibilityChanged(isVisible) {
            if (!isVisible) {
                return;
            }

            this.currentPage++
            this.getData();
        },
    },

    computed: {
        currentFilters() {
            const filters = {
                county: this.countyId,
                town: this.townId,
                type: this.filters.categories.filter((category) => category.checked).map((category) => category.id),
            }

            if (this.filters.features.filter(feature => feature.checked).length > 0) {
                filters['feature'] = this.filters.features.filter((feature) => feature.checked).map((feature) => feature.id);
            }

            if (this.filters.venueTypes.filter(venueType => venueType.checked).length > 0) {
                filters['venueType'] = this.filters.venueTypes.filter((venueType) => venueType.checked).map((venueType) => venueType.id);
            }

            if (this.filters.ratings.filter(rating => rating.checked).length > 0) {
                filters['rating'] = this.filters.ratings.filter((rating) => rating.checked).map((rating) => rating.id / 2);
            }

            return filters
        },

        windowWidth() {
            return window.innerWidth;
        },

        searchText() {
            if (!this.searchTerm) {
                return '';
            }

            return JSON.stringify({
                term: this.searchTerm,
                range: this.searchRange,
            });
        },

        mapUrl() {
            return `${window.config.baseUrl}/assets/images/shares/wheretoeat-map.jpg`;
        }
    },

    watch: {
        filters: {
            deep: true,
            handler: function () {
                if (this.isLoading) {
                    return;
                }

                if (this.isLte('md')) {
                    return;
                }

                this.filterTimeout = setTimeout(() => {
                    this.isLoading = true;
                    this.currentPage = 1;
                    this.places = [];
                    this.getPlaces()
                }, 500)
            }
        },

        showFilterModal: function () {
            if (this.isGt('md')) {
                return;
            }

            if (this.showFilterModal) {
                document.querySelector('body').classList.add('overflow-hidden');

                return;
            }

            document.querySelector('body').classList.remove('overflow-hidden');
            this.isLoading = true;
            this.currentPage = 1;
            this.places = [];
            this.getPlaces();
        }
    },
}
</script>
