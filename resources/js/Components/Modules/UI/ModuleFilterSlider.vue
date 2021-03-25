<template>
    <div class="w-screen h-screen fixed inset-0 bg-black-80 z-max" v-show="show" @click.self="closeFilterBar()">
        <div
            class="w-11/12 h-full absolute top-0 right-0 bg-white border-l border-grey-off-dark z-20 shadow-lg flex flex-col overflow-y-scroll"
            style="max-width: 350px;">
            <div class="flex mb-1 items-center p-2">
                <h2 class="flex-1 text-xl font-medium">Filter {{ title }}</h2>
                <div class="cursor-pointer" @click="closeFilterBar()">
                    <font-awesome-icon :icon="['fas', 'times']"></font-awesome-icon>
                </div>
            </div>

            <div class="bg-blue-light-20 p-2 text-md">
                {{ totalResults }} {{ title }} shown...
            </div>

            <component :is="component" :current-filters="currentFilters" :current-search="currentSearch"></component>

            <div class="flex justify-between p-2">
                <button class="px-4 inline-block leading-none p-2 bg-blue rounded" @click="clearFilters()">Clear
                </button>
                <button class="px-4 inline-block leading-none p-2 bg-blue rounded" @click="closeFilterBar()">Apply
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import GoogleEvents from "@/Mixins/GoogleEvents";
import BlogFilter from "~/Modules/Filters/BlogFilter";
import RecipeFilter from "~/Modules/Filters/RecipeFilter";
import ReviewsFilter from "~/Modules/Filters/ReviewsFilter";

export default {
    mixins: [GoogleEvents],

    components: {
        'blogs-filter': BlogFilter,
        'recipes-filter': RecipeFilter,
        'reviews-filter': ReviewsFilter
    },

    props: {
        show: {
            type: Boolean,
            default: false,
        },
        title: {
            type: String,
            required: true,
        },
        totalResults: {
            type: Number,
            required: true,
        },
        currentFilters: {
            type: Object | Array,
        },
        currentSearch: {
            type: String,
            default: '',
        }
    },

    methods: {
        closeFilterBar() {
            this.$root.$emit('toggle-filter-bar')
        },

        clearFilters() {
            this.$root.$emit('clear-filters');
        }
    },

    computed: {
        component() {
            return this.title.toLowerCase() + '-filter';
        }
    },

    watch: {
        show: function (value) {
            if (value) {
                this.googleEvent('event', 'modules', {
                    event_category: 'opened-filter-bar',
                    event_label: this.title,
                });

                document.querySelector('html').classList.add('bg-black-80', 'overflow-hidden');
                document.querySelector('html').classList.remove('bg-grey-light');
            } else {
                document.querySelector('html').classList.add('bg-grey-light');
                document.querySelector('html').classList.remove('bg-black-80', 'overflow-hidden');
            }
        }
    }
}
</script>
