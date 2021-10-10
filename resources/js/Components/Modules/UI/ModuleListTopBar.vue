<template>
  <div class="w-full flex my-2 space-x-2">
    <div
      v-if="showFilterBar"
      class="flex-1"
    >
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
      class="w-auto inline-block leading-none px-4 bg-blue rounded h-12"
      @click.prevent="toggleFilter()"
    >
      Filter {{ title }}
    </button>
  </div>
</template>

<script>
import Vue from 'vue';
import { VTooltip } from 'v-tooltip';

const FormInput = () => import('~/Forms/Input' /* webpackChunkName: "chunk-form-input" */);

Vue.directive('tooltip', VTooltip);

export default {
  components: {
    'form-input': FormInput,
  },

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
    },
  },

  data: () => ({
    searchText: '',
    searchTimeout: null,
  }),

  watch: {
    searchText(value) {
      clearTimeout(this.searchTimeout);

      this.searchTimeout = setTimeout(() => {
        this.$root.$emit('module-search', value);
      }, 500);
    },

    currentSearch(value) {
      this.searchText = value;
    },
  },

  mounted() {
    this.searchText = this.currentSearch;

    this.$root.$on('search-change', (value) => {
      this.searchText = value;
    });

    this.$root.$on('search-value', (value) => {
      this.searchText = value;
    });

    this.$root.$on('reset-search', () => {
      this.searchText = '';
    });
  },

  methods: {
    toggleFilter() {
      this.$root.$emit('toggle-filter-bar');
    },
  },
};
</script>
