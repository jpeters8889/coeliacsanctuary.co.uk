<template>
    <div class="w-full my-3">
        <div>
            <div class="w-full mb-1">
                <ul class="flex flex-col leading-none xs:flex-row">
                    <li v-for="tab in mainTabs" v-if="tab.count > 0"
                        @click="changeTab(tab)"
                        class="w-full cursor-pointer py-2 px-4 border-2 w-full block transition-bg mb-px rounded-b xs:w-auto xs:mb-0 xs:mr-px"
                        :class="currentTab === tab.id ? 'bg-yellow border-yellow hover:bg-yellow-80' : 'bg-blue-light border-blue-light hover:bg-blue-light-80'">
                        {{ tab.label }} ({{ tab.count }})
                    </li>
                </ul>
            </div>

            <div class="w-full mb-1">
                <div
                    class="text-sm w-full cursor-pointer py-2 px-4 border-2 w-full block transition-bg mb-px rounded-b bg-yellow-50 border-yellow hover:bg-yellow-40 xs:hidden"
                    @click="viewTabs = !viewTabs">
                    View Venue Categories (Currently viewing category: {{ getVenueTypeName() }})
                </div>

                <div :class="windowWidth >= 500 || viewTabs ? 'block' : 'hidden'">
                    <ul class="flex flex-col leading-none xs:flex-row xs:flex-wrap xs:-m-px">
                        <li @click="changeVenueType({id: 0})"
                            class="w-full cursor-pointer py-2 px-4 border-2 w-full block transition-bg mb-px rounded-b xs:w-auto xs:m-px"
                            :class="currentVenueType === 0 ? 'bg-yellow-50 border-yellow hover:bg-yellow-40' : 'bg-blue-light-50 border-blue-light hover:bg-blue-light-40'">
                            View All
                        </li>

                        <li v-for="venueType in venueTypeTabs" v-if="venueType.count > 0"
                            @click="changeVenueType(venueType)"
                            class="w-full cursor-pointer py-2 px-4 border-2 w-full block transition-bg mb-px rounded-b xs:w-auto xs:m-px"
                            :class="currentVenueType === venueType.id ? 'bg-yellow-50 border-yellow hover:bg-yellow-40' : 'bg-blue-light-50 border-blue-light hover:bg-blue-light-40'">
                            {{ venueType.label }} ({{ venueType.count }})
                        </li>
                    </ul>
                </div>
            </div>

            <slot name="intro"></slot>
        </div>

        <div>
            <pagination :current="places.current_page"
                        :lastPage="places.last_page"
                        :can-go-back="!! places.prev_page_url"
                        :can-go-forward="!! places.next_page_url"
            ></pagination>

            <div v-if="isLoading" class="relative h-64">
                <loader :show="true"></loader>
            </div>

            <div v-else-if="noResults">
                <p class="text-red text-lg my-2">Sorry, no results found!</p>
            </div>

            <div v-else>
                <div class="flex flex-col my-2 md:flex-row md:flex-wrap -mx-2">
                    <component
                        v-for="(place, index) in places.data"
                        :key="place.id"
                        :is="resolveTemplate(place)"
                        :place="place"
                        :index="index">
                    </component>
                </div>
            </div>

            <pagination :current="places.current_page"
                        :lastPage="places.last_page"
                        :can-go-back="!! places.prev_page_url"
                        :can-go-forward="!! places.next_page_url"
            ></pagination>
        </div>
    </div>
</template>

<script>
import FilterableUrls from "@/Mixins/FilterableUrls";

const Loader = () => import('~/Global/UI/Loader' /* webpackChunkName: "chunk-loader" */)
const Pagination = () => import('~/Global/UI/Pagination' /* webpackChunkName: "chunk-pagination" */)
import WhereToEatAttraction from "~/WhereToEat/Renders/WhereToEatAttraction";
import WhereToEatEatery from "~/WhereToEat/Renders/WhereToEatEatery";
import WhereToEatHotel from "~/WhereToEat/Renders/WhereToEatHotel";
import WhereToEatNationwide from "~/WhereToEat/Tabs/WhereToEatNationwide";

export default {
    mixins: [FilterableUrls],

    components: {
        'loader': Loader,
        'pagination': Pagination,
        'wheretoeat-place-attraction': WhereToEatAttraction,
        'wheretoeat-place-eatery': WhereToEatEatery,
        'wheretoeat-place-hotel': WhereToEatHotel,
        'wheretoeat-place-nationwide': WhereToEatNationwide,
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
        currentPage: 1,
        viewTabs: false,

        currentTab: 0,
        currentVenueType: 0,
        reviews: false,

        mainTabs: [
            {
                label: 'View All',
                count: 0,
                id: 0,
            },
            {
                label: 'Eateries',
                count: 0,
                id: 1,
            },
            {
                label: 'Attractions',
                count: 0,
                id: 2,
            },
            {
                label: 'Hotels',
                count: 0,
                id: 3,
            },
            {
                label: 'Reviews',
                count: 0,
                id: 4,
            }
        ],

        venueTypeTabs: [],

        isLoading: true,
        noResults: false,

        places: {
            current_page: 1,
            last_page: 1,
            prev_page_url: '',
            next_page_url: '',
            total: 0,
        },
    }),

    mounted() {
        this.getData();

        this.$root.$on('pagination-click', (page) => {
            if (page === 'next') {
                page = this.currentPage + 1;
            }

            if (page === 'prev') {
                page = this.currentPage - 1;
            }

            this.currentPage = page;

            this.getData();
        });
    },

    methods: {
        getData() {
            this.isLoading = true;
            this.noResults = false;
            this.getTabData();
            this.getVenueTypeData();
            this.getPlaces();
        },

        getTabData() {
            coeliac().request()
                .get(this.buildUrl('/api/wheretoeat/summary', 1, this.searchText, this.currentFilters))
                .then((response) => {
                    this.mainTabs[0].count = response.data.total;
                    this.mainTabs[1].count = response.data.eateries;
                    this.mainTabs[2].count = response.data.attractions;
                    this.mainTabs[3].count = response.data.hotels;
                    this.mainTabs[4].count = response.data.reviews;
                })
                .catch(() => {
                    this.noResults = true;
                });
        },

        getVenueTypeData() {
            coeliac().request()
                .get(this.buildUrl('/api/wheretoeat/venueTypes', 1, this.searchText, this.currentFilters))
                .then((response) => {
                    this.venueTypeTabs = response.data;
                })
                .catch(() => {
                    this.noResults = true;
                })
        },

        getPlaces() {
            coeliac().request()
                .get(this.buildUrl('/api/wheretoeat', this.currentPage, this.searchText, this.currentFilters))
                .then((response) => {
                    this.places = response.data.data;

                    this.places.data.forEach((place, index) => {
                        if (this.places.appends[place.id]) {
                            Object.keys(this.places.appends[place.id]).forEach((key) => {
                                this.$set(this.places.data[index], key, this.places.appends[place.id][key])
                            });
                        }
                    });
                })
                .catch(() => {
                    this.noResults = true;
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },

        changeTab(tab) {
            this.currentTab = tab.id;
            this.reviews = this.currentTab === 4;
            this.currentVenueType = 0;

            this.getVenueTypeData();
            this.getPlaces();
        },

        changeVenueType(venueType) {
            this.currentVenueType = venueType.id;
            this.getPlaces();
        },

        getVenueTypeName() {
            let venueType = this.venueTypeTabs.find(tab => tab.id === this.currentVenueType);

            if (venueType && venueType.label) {
                return venueType.label;
            }

            return 'All';
        },

        resolveTemplate(place) {
            if (place.country.country === 'Nationwide') {
                return 'wheretoeat-place-nationwide';
            }

            if (place.type.type === 'wte') {
                return 'wheretoeat-place-eatery';
            }

            if (place.type.type === 'att') {
                return 'wheretoeat-place-attraction';
            }

            if (place.type.type === 'hotel') {
                return 'wheretoeat-place-hotel';
            }
        }
    },

    computed: {
        currentFilters() {
            return {
                county: this.countyId,
                town: this.townId,
                type: this.currentTab !== 0 && this.currentTab < 4 ? this.currentTab : null,
                venueType: this.currentVenueType !== 0 ? this.currentVenueType : null,
                has: this.currentTab === 4 ? 'reviews' : null,
            };
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
        }
    }
}
</script>
