<template>
    <div class="w-full flex my-2 space-x-2">
        <div class="flex-1" v-if="showFilterBar">
            <form-input
                type="search"
                :placeholder="'Search ' + title + '...'"
                name="search"
                :value="searchText"
                border-class="border-grey-off"
                full-width
            />
        </div>

        <button
            v-if="showFilterBar"
            @click.prevent="toggleFilter()"
            class="w-auto inline-block leading-none px-4 bg-blue rounded h-12"
        >
            Filter {{ title }}
        </button>
    </div>
</template>

<script>
import Vue from "vue";
import { VTooltip } from "v-tooltip";

const FormInput = () => import('~/Forms/Input' /* webpackChunkName: "chunk-form-input" */)

Vue.directive('tooltip', VTooltip)

export default {
    components: {
        'form-input': FormInput
    },

    data: () => ({
        searchText: '',
        searchTimeout: null,
    }),

    props: {
        title: {
            required: true,
            type: String,
        },
        currentSearch: {
            type: String,
            default: '',
        },
        showFilterBar: {
            type: Boolean,
            default: () => false,
        }
    },

    mounted() {
        this.searchText = this.currentSearch;

        this.$root.$on(`search-change`, (value) => {
            this.searchText = value
        });

        this.$root.$on(`search-value`, (value) => {
            this.searchText = value;
        });

        this.$root.$on('reset-search', () => {
            this.searchText = '';
        });
    },

    methods: {
        toggleFilter() {
            this.$root.$emit('toggle-filter-bar');
        }
    },

    watch: {
        searchText: function (value) {
            clearTimeout(this.searchTimeout);

            this.searchTimeout = setTimeout(() => {
                this.$root.$emit('module-search', value);
            }, 500);
        },

        currentSearch: function (value) {
            this.searchText = value;
        }
    },
}
</script>
