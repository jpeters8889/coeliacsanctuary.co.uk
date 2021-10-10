<template>
  <div>
    <module-filter-slider
      v-if="showFilterBar"
      :show="showFilters"
      :title="title"
      :total-results="response.total"
      :current-filters="filters"
      :current-search="searchText"
    />

    <div
      v-show="!initialLoad"
      class="flex flex-col space-y-3"
    >
      <div
        v-if="showFilterBar || response.last_page > 1"
        class="bg-white p-4 flex flex-col space-y-3"
      >
        <module-list-top-bar
          :title="title"
          :show-filter-bar="showFilterBar"
          :current-search="searchText"
        />

        <pagination
          :current="response.current_page"
          :last-page="response.last_page"
          :can-go-back="!! response.prev_page_url"
          :can-go-forward="!! response.next_page_url"
        />
      </div>

      <div
        v-if="searchText !== '' || Object.values(filters).filter(arr => arr.length > 0).length"
        class="page-box"
      >
        <ul class="flex -m-1">
          <li
            v-if="searchText !== ''"
            class="m-1 bg-blue-light rounded-lg text-xs overflow-hidden flex justify-between"
          >
            <div class="py-1 px-3">
              Search: {{ searchText }}
            </div>
            <div
              class="bg-yellow py-1 px-3 cursor-pointer"
              @click="clearSearch"
            >
              <font-awesome-icon :icon="['fas', 'times']" />
            </div>
          </li>
          <template v-for="filter in availableFilters">
            <li
              v-for="(option, index) in filters[filter.value]"
              :key="index"
              class="m-1 bg-blue-light rounded-lg text-xs overflow-hidden flex justify-between"
            >
              <div v-if="filter.value === 'tags' && module === 'blogs'">
                <blog-tag-daily-update-subscribe :tag="option" />
              </div>
              <div class="py-1 px-3">
                {{ filter.label }}: {{ option }}
              </div>
              <div
                class="bg-yellow py-1 px-3 cursor-pointer"
                @click="removeFilter(filter.value, option)"
              >
                <font-awesome-icon :icon="['fas', 'times']" />
              </div>
            </li>
          </template>
        </ul>
      </div>

      <div
        v-if="isLoading"
        class="relative h-64"
      >
        <loader :show="true" />
      </div>

      <div
        v-else
        ref="items"
        class="grid grid-cols-1 gap-y-3 md:grid-cols-6 md:gap-x-3"
      >
        <module-list-item
          v-for="(item, index) in response.data"
          :key="item.id"
          :module="module"
          :item="item"
          :index="index"
          :page="currentPage"
          :layout="layout"
          :url-prefix="urlPrefix"
          :has-filters="hasFilters"
        />
      </div>

      <div class="page-box">
        <pagination
          :current="response.current_page"
          :last-page="response.last_page"
          :can-go-back="!! response.prev_page_url"
          :can-go-forward="!! response.next_page_url"
        />
      </div>
    </div>
  </div>
</template>

<script>
import AvailableFilters from '@/Resources/AvailableFilters';
import FilterableUrls from '@/Mixins/FilterableUrls';
import LazyLoadsImages from '@/Mixins/LazyLoadsImages';
import GoogleEvents from '@/Mixins/GoogleEvents';
import ModuleFilterSlider from '~/Modules/UI/ModuleFilterSlider';
import ModuleListItem from '~/Modules/UI/ModuleListItem';
import ModuleListTopBar from '~/Modules/UI/ModuleListTopBar';
import BlogTagDailyUpdateSubscribe from '~/Modules/UI/Blogs/BlogTagDailyUpdateSubscribe';

const Loader = () => import('~/Global/UI/Loader' /* webpackChunkName: "chunk-loader" */);
const Pagination = () => import('~/Global/UI/Pagination' /* webpackChunkName: "chunk-pagination" */);

export default {

  components: {
    loader: Loader,
    'module-filter-slider': ModuleFilterSlider,
    'module-list-item': ModuleListItem,
    'module-list-top-bar': ModuleListTopBar,
    pagination: Pagination,
    'blog-tag-daily-update-subscribe': BlogTagDailyUpdateSubscribe,
  },
  mixins: [FilterableUrls, GoogleEvents, LazyLoadsImages],

  props: {
    module: {
      required: true,
      validator: (value) => ['blogs', 'collection', 'recipes', 'reviews'].indexOf(value) !== -1,
    },
    title: {
      required: true,
      type: String,
    },
    urlPrefix: {
      required: true,
      type: String,
    },
    showFilterBar: {
      type: Boolean,
      default: () => true,
    },
  },

  data: () => ({
    initialLoad: true,
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
    },
  },

  mounted() {
    if (this.showFilterBar) {
      this.availableFilters = AvailableFilters[this.module];

      this.availableFilters.forEach((filter) => {
        this.$set(this.filters, filter.value, []);
      });
    }

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
          this.initialLoad = false;

          window.history.pushState(null, null, this.buildUrl(window.location.href.split('?')[0], this.currentPage, this.searchText, this.filters, true));
        });
    },

    removeFilter(name, filter) {
      this.$root.$emit('remove-filter', {
        name,
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
          offset: -200,
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

        this.filters[filter.name] = this.filters[filter.name].filter((thisFilter) => thisFilter !== filter.value);

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
      const urlBits = window.location.href.split('?o=');
      if (urlBits.length > 1) {
        const queryStrings = atob(urlBits[1]).split('&');
        queryStrings.forEach((queryString) => {
          const [key, value] = queryString.split('=');

          if (key === 'page') {
            this.currentPage = parseInt(value);
          }

          if (key === 'search') {
            this.searchText = value;
          }

          if (value !== '' && /filter\[([a-z-]+)]/m.exec(key) !== null) {
            const matches = /filter\[([a-z-]+)]/m.exec(key);
            this.filters[matches[1]] = value.split(',');
          }
        });
      }
    },
  },
};
</script>
