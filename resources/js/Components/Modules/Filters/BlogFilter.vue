<template>
  <div>
    <global-ui-accordion
      group="filters"
      name="tags"
    >
      <template #title>
        <div class="border-b border-grey-light p-2">
          <div class="flex flex-col">
            <h3 class="cursor-pointer text-lg font-medium mt-1 flex justify-between items-center">
              <span>Blog Tags</span>
              <font-awesome-icon
                class="text-blue"
                :icon="['fas', iconFor('tags')]"
              />
            </h3>
          </div>
          <div
            v-if="selectedTags.length > 0"
            class="text-grey-dark"
          >
            <ul class="flex flex-wrap text-sm -m-2px leading-none">
              <li
                v-for="(tag, index) in selectedTags"
                :key="index"
                class="rounded-lg bg-blue-light m-2px flex overflow-hidden"
              >
                <span class="px-3 py-1">{{ tag.title }}</span>
                <span
                  class="block bg-yellow px-2 py-1 cursor-pointer"
                  @click.stop="removeTag(tag)"
                >
                  <font-awesome-icon :icon="['fas', 'times']" />
                </span>
              </li>
            </ul>
          </div>
        </div>
      </template>

      <template #body>
        <div class="p-2">
          <div class="w-full flex mb-1">
            <input
              v-model="searchText"
              type="search"
              placeholder="Search Tags..."
              class="text-sm p-1 flex-1 bg-grey-lightest border border-grey-off rounded w-full"
            >
          </div>

          <ul>
            <li
              v-for="(tag, index) in filteredTags"
              :key="index"
              class="py-1 border-b border-dashed border-grey-off-dark transition-all cursor-pointer hover:bg-grey-off-dark"
              @click.prevent="selectTag(tag)"
            >
              <span>{{ tag.title }}</span>
              <span class="text-xs">({{ tag.blogs_count }} Blogs)</span>
            </li>
          </ul>
        </div>
      </template>
    </global-ui-accordion>

    <global-ui-accordion
      group="filters"
      name="year"
    >
      <template #title>
        <div class="border-b border-grey-light p-2">
          <div class="flex flex-col">
            <h3 class="cursor-pointer text-lg font-medium mt-1 flex justify-between items-center">
              <span>Year Posted</span>
              <font-awesome-icon
                class="text-blue"
                :icon="['fas', iconFor('year')]"
              />
            </h3>
          </div>
          <div
            v-if="selectedYear"
            class="text-grey-dark"
          >
            <ul class="flex flex-wrap text-sm -m-2px leading-none">
              <li class="rounded-lg bg-blue-light m-2px flex overflow-hidden">
                <span class="px-3 py-1">{{ selectedYear }}</span>
                <span
                  class="block bg-yellow px-2 py-1 cursor-pointer"
                  @click.stop="removeYear()"
                >
                  <font-awesome-icon :icon="['fas', 'times']" />
                </span>
              </li>
            </ul>
          </div>
        </div>
      </template>

      <template #body>
        <div class="p-2">
          <ul v-if="years.length > 0">
            <li
              v-for="year in years"
              :key="year"
              class="py-1 border-b border-dashed border-grey-off-dark transition-all cursor-pointer hover:bg-grey-off-dark"
              @click.prevent="selectYear(year.year)"
            >
              <span>{{ year.year }}</span>
              <span class="text-xs">({{ year.blogs_count }} Blogs)</span>
            </li>
          </ul>
        </div>
      </template>
    </global-ui-accordion>
  </div>
</template>

<script>
import FilterableUrls from '@/Mixins/FilterableUrls';

export default {
  mixins: [FilterableUrls],

  props: {
    currentFilters: {
      default: () => [],
      type: [Object, Array],
    },
    currentSearch: {
      type: String,
      default: '',
    },
  },

  data: () => ({
    tags: [],
    selectedTags: [],
    years: [],
    selectedYear: null,
    searchText: '',
    accordions: {
      tags: false,
      year: false,
    },
  }),

  computed: {
    filteredTags() {
      return this.tags.filter((tag) => {
        if (this.searchText !== '') {
          return tag.title.toLowerCase().includes(this.searchText) && this.selectedTags.indexOf(tag) === -1;
        }

        return this.selectedTags.indexOf(tag) === -1;
      }).slice(0, 14);
    },
  },

  watch: {
    currentFilters: {
      deep: true,
      handler() {
        this.getData();
      },
    },
    currentSearch: {
      deep: true,
      handler() {
        this.getData();
      },
    },
  },

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
      coeliac().request().get(this.buildUrl('/api/blogs/tags', 1, this.currentSearch, this.currentFilters))
        .then((response) => {
          this.tags = response.data.data;
          this.selectedTags = [];

          if (this.currentFilters) {
            this.currentFilters.tags.forEach((currentFilter) => {
              this.selectedTags.push(
                this.tags.filter((tag) => tag.slug === currentFilter)[0],
              );
            });
          }
        });

      coeliac().request().get(this.buildUrl('/api/blogs/years', 1, this.currentSearch, this.currentFilters))
        .then((response) => {
          this.years = response.data.data;

          this.selectedYear = this.currentFilters.year[0] || null;
        });
    },

    selectTag(tag) {
      this.selectedTags.push(tag);
      this.$root.$emit('add-filter', {
        name: 'tags',
        value: tag.slug,
      });
    },

    selectYear(year) {
      this.selectedYear = year;
      this.$root.$emit('add-filter', {
        name: 'year',
        value: year,
        single: true,
      });
    },

    removeTag(tag) {
      this.selectedTags = this.selectedTags.filter((tags) => tags.slug !== tag.slug);

      this.$root.$emit('remove-filter', {
        name: 'tags',
        value: tag.slug,
      });
    },

    removeYear() {
      const current = this.selectedYear;
      this.selectedYear = null;

      this.$root.$emit('remove-filter', {
        name: 'year',
        value: current,
      });
    },

    iconFor(filter) {
      return this.accordions[filter] ? 'chevron-up' : 'chevron-down';
    },
  },
};
</script>
