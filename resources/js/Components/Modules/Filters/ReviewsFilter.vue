<template>
    <div>
        <global-ui-accordion group="filters" name="counties">
            <template v-slot:title>
                <div class="border-b border-grey-light p-2">
                    <div class="flex flex-col">
                        <h3 class="cursor-pointer text-lg font-medium mt-1 flex justify-between items-center">
                            <span>Counties</span>
                            <font-awesome-icon class="text-blue"
                                               :icon="['fas', iconFor('counties')]"></font-awesome-icon>
                        </h3>
                    </div>
                    <div v-if="selectedCounties.length > 0" class="text-grey-dark">
                        <ul class="flex flex-wrap text-sm -m-2px leading-none">
                            <li v-for="county in selectedCounties"
                                class="rounded-lg bg-blue-light m-2px flex overflow-hidden">
                                <span class="px-3 py-1">{{ county.county }}, {{ county.country }}</span>
                                <span class="block bg-yellow px-2 py-1 cursor-pointer"
                                      @click.stop="removeCounty(county)">
                                    <font-awesome-icon :icon="['fas', 'times']"></font-awesome-icon>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </template>

            <template v-slot:body>
                <div class="p-2">
                    <ul>
                        <li v-for="(countyList, country) in filteredCountries"
                            class="py-1">
                            <h3 class="w-full font-semibold text-xl text-blue-dark">{{ country }}</h3>
                            <ul>
                                <li v-for="(count, county) in countyList"
                                    class="py-1 border-b border-dashed border-grey-off-dark transition-bg cursor-pointer hover:bg-grey-off-dark"
                                    @click.prevent="selectCounty(county, country)">
                                    <span>{{ county }}</span>
                                    <span class="text-xs">({{ count }} Reviews)</span>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </template>
        </global-ui-accordion>

        <global-ui-accordion group="filters" name="ratings">
            <template v-slot:title>
                <div class="border-b border-grey-light p-2">
                    <div class="flex flex-col">
                        <h3 class="cursor-pointer text-lg font-medium mt-1 flex justify-between items-center">
                            <span>Rating</span>
                            <font-awesome-icon class="text-blue"
                                               :icon="['fas', iconFor('ratings')]"></font-awesome-icon>
                        </h3>
                    </div>
                    <div v-if="selectedRatings.length > 0" class="text-grey-dark">
                        <ul class="flex flex-wrap text-sm -m-2px leading-none">
                            <li v-for="rating in selectedRatings"
                                class="rounded-lg bg-blue-light m-2px flex overflow-hidden">
                                <span class="px-3 py-1">{{ rating }}</span>
                                <span class="block bg-yellow px-2 py-1 cursor-pointer"
                                      @click.stop="removeRating(rating)">
                                    <font-awesome-icon :icon="['fas', 'times']"></font-awesome-icon>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </template>

            <template v-slot:body>
                <div class="p-2">
                    <ul>
                        <li v-for="(count, rating) in filteredRatings"
                            class="py-1 border-b border-dashed border-grey-off-dark transition-bg cursor-pointer hover:bg-grey-off-dark"
                            @click.prevent="selectRating(rating)">
                            <span>{{ rating }}</span>
                            <span class="text-xs">({{ count }} Reviews)</span>
                        </li>
                    </ul>
                </div>
            </template>
        </global-ui-accordion>
    </div>
</template>

<script>
import FilterableUrls from "@/Mixins/FilterableUrls";

export default {
    mixins: [FilterableUrls],

    props: {
        currentFilters: {
            type: Object | Array,
        },
        currentSearch: {
            type: String,
            default: '',
        }
    },

    data: () => ({
        counties: {},
        selectedCounties: [],

        ratings: {},
        selectedRatings: {},

        accordions: {
            counties: false,
            ratings: false,
        }
    }),

    mounted() {
        this.getData();

        this.$root.$on('accordion-toggled', (event) => {
            if (this.accordions[event.name] !== undefined) {
                this.$set(this.accordions, event.name, event.visible);
            }
        });

        this.$root.$on('clear-filters', () => {
            this.selectedTags = [];
            this.selectedYear = '';
        });
    },

    methods: {
        getData() {
            coeliac().request().get(this.buildUrl(`/api/reviews/counties`, 1, this.currentSearch, this.currentFilters))
                .then((response) => {
                    this.counties = response.data.data;
                    this.selectedCounties = [];

                    if (this.currentFilters) {
                        this.currentFilters.counties.forEach((currentFilter) => {
                            Object.keys(this.counties).forEach((country) => {
                                Object.keys(this.counties[country]).forEach((county) => {
                                    if (county === currentFilter) {
                                        this.selectedCounties.push({
                                            country,
                                            county
                                        })
                                    }
                                });
                            });
                        });
                    }
                });

            coeliac().request().get(this.buildUrl('/api/reviews/ratings', 1, this.currentSearch, this.currentFilters))
                .then((response) => {
                    this.ratings = response.data.data;
                    this.selectedRatings = [];

                    if (this.currentFilters) {
                        this.currentFilters.ratings.forEach((currentFilter) => {
                            Object.keys(this.ratings).forEach((rating) => {
                                if (rating === currentFilter) {
                                    this.selectedCounties.push(rating)
                                }
                            });
                        });
                    }
                })
        },

        selectCounty(county, country) {
            this.selectedCounties.push({
                county,
                country,
            });

            this.$root.$emit('add-filter', {
                name: 'counties',
                value: county,
            });
        },

        removeCounty(county) {
            this.selectedCounties = this.selectedCounties.filter((thisCounty) => {
                return thisCounty.county !== county.county
            });


            this.$root.$emit('remove-filter', {
                name: 'counties',
                value: county.county,
            });
        },

        selectRating(rating) {
            this.selectedRatings.push(rating);

            this.$root.$emit('add-filter', {
                name: 'ratings',
                value: rating,
            });
        },

        removeRating(rating) {
            this.selectedRatings = this.selectedRatings.filter((thisRating) => {
                return thisRating !== rating;
            });

            this.$root.$emit('remove-filter', {
                name: 'ratings',
                value: rating,
            });
        },

        iconFor(filter) {
            return this.accordions[filter] ? 'chevron-up' : 'chevron-down';
        },
    },

    computed: {
        filteredCountries() {
            let rtr = {};

            Object.keys(this.counties).forEach((country) => {
                let thisCountry = {};
                Object.keys(this.counties[country]).forEach((county) => {
                    if (JSON.stringify(this.selectedCounties).indexOf(JSON.stringify({country, county})) === -1) {
                        this.$set(thisCountry, county, this.counties[country][county]);
                    }
                });

                this.$set(rtr, country, thisCountry);
            });

            return rtr;
        },

        filteredRatings() {
            let rtr = {};

            Object.keys(this.ratings).forEach((rating) => {
                if (this.selectedRatings.indexOf(rating) === -1) {
                    this.$set(rtr, rating, this.ratings[rating]);
                }
            });

            return rtr;
        }
    },

    watch: {
        currentFilters: {
            deep: true,
            handler: function () {
                this.getData();
            }
        },
        currentSearch: {
            deep: true,
            handler: function () {
                this.getData();
            }
        }
    }
}
</script>
