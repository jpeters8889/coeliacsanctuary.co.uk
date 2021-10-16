<template>
  <transition
    enter-active-class="duration-300 ease-out"
    enter-class="opacity-0"
    enter-to-class="opacity-100"
    leave-active-class="duration-200 ease-in"
    leave-class="opacity-100"
    leave-to-class="opacity-0"
    @enter="$root.$emit('background-entered')"
  >
    <!-- black bg -->
    <div
      v-if="show"
      class="transition-all transform fixed inset-0 h-full bg-black bg-opacity-50 w-full z-max overflow-hidden"
      @click.self.exact.stop="closeFilterBar()"
    >
      <transition
        enter-active-class="duration-400 ease-out"
        enter-class="translate-x-full"
        enter-to-class="translate-x-0"
        leave-active-class="duration-200 ease-in"
        leave-class="translate-x-0"
        leave-to-class="translate-x-full"
      >
        <div
          v-if="show && hasBackground"
          class="transition-all transform w-11/12 h-full absolute top-0 right-0 bg-white border-l border-grey-off-dark z-20 shadow-lg flex flex-col overflow-y-scroll"
          style="max-width: 400px;"
        >
          <div class="flex mb-1 items-center p-2">
            <h2 class="flex-1 text-xl font-medium">
              Filter {{ title }}
            </h2>
            <div
              class="cursor-pointer"
              @click.exact.stop="closeFilterBar()"
            >
              <font-awesome-icon :icon="['fas', 'times']" />
            </div>
          </div>

          <div class="bg-blue-light bg-opacity-20 p-2 text-md">
            {{ totalResults }} {{ title }} shown...
          </div>

          <component
            :is="component"
            :current-filters="currentFilters"
            :current-search="currentSearch"
          />

          <div class="flex justify-between p-2">
            <button
              class="px-4 inline-block leading-none p-2 bg-blue rounded"
              @click="clearFilters()"
            >
              Clear
            </button>
            <button
              class="px-4 inline-block leading-none p-2 bg-blue rounded"
              @click="closeFilterBar()"
            >
              Apply
            </button>
          </div>
        </div>
      </transition>
    </div>
  </transition>
</template>

<script>
import GoogleEvents from '@/Mixins/GoogleEvents';
import BlogFilter from '~/Modules/Filters/BlogFilter';
import RecipeFilter from '~/Modules/Filters/RecipeFilter';
import ReviewsFilter from '~/Modules/Filters/ReviewsFilter';

export default {

  components: {
    'blogs-filter': BlogFilter,
    'recipes-filter': RecipeFilter,
    'reviews-filter': ReviewsFilter,
  },
  mixins: [GoogleEvents],

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
      default: () => [],
      type: [Object, Array],
    },
    currentSearch: {
      type: String,
      default: '',
    },
  },

  data: () => ({
    hasBackground: false,
  }),

  computed: {
    component() {
      return `${this.title.toLowerCase()}-filter`;
    },
  },

  watch: {
    show(value) {
      if (value) {
        this.googleEvent('event', 'modules', {
          event_category: 'opened-filter-bar',
          event_label: this.title,
        });

        document.querySelector('html').classList.add('bg-black', 'bg-opacity-80', 'overflow-hidden');
        document.querySelector('html').classList.remove('bg-grey-light');
      } else {
        document.querySelector('html').classList.add('bg-grey-light');
        document.querySelector('html').classList.remove('bg-black', 'bg-opacity-80', 'overflow-hidden');
      }
    },
  },

  mounted() {
    this.$root.$on('background-entered', () => {
      this.hasBackground = true;
    });
  },

  methods: {
    closeFilterBar() {
      this.hasBackground = false;
      this.$root.$emit('toggle-filter-bar');
    },

    clearFilters() {
      this.$root.$emit('clear-filters');
    },
  },
};
</script>
