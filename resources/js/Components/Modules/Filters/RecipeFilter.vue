<template>
  <div>
    <global-ui-accordion
      group="filters"
      name="freefrom"
    >
      <template #title>
        <div class="border-b border-grey-light p-2">
          <div class="flex flex-col">
            <h3 class="cursor-pointer text-lg font-medium mt-1 flex justify-between items-center">
              <span>Free From</span>
              <font-awesome-icon
                class="text-blue"
                :icon="['fas', iconFor('freefrom')]"
              />
            </h3>
          </div>
          <div
            v-if="selectedAllergens.length > 0"
            class="text-grey-dark"
          >
            <ul class="flex flex-wrap text-sm -m-2px leading-none">
              <li
                v-for="allergen in selectedAllergens"
                :key="allergen.id"
                class="rounded-lg bg-blue-light m-2px flex overflow-hidden"
              >
                <span class="px-3 py-1">{{ allergen.title }}</span>
                <span
                  class="block bg-yellow px-2 py-1 cursor-pointer"
                  @click.stop="removeAllergen(allergen)"
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
          <ul>
            <li
              v-for="(allergen, index) in filteredAllergens"
              :key="index"
              class="py-1 border-b border-dashed border-grey-off-dark transition-all cursor-pointer hover:bg-grey-off-dark"
              @click.prevent="selectAllergen(allergen)"
            >
              <span>{{ allergen.title }}</span>
              <span class="text-xs">({{ allergen.recipes_count }} Recipes)</span>
            </li>
          </ul>
        </div>
      </template>
    </global-ui-accordion>

    <global-ui-accordion
      group="filters"
      name="meals"
    >
      <template #title>
        <div class="border-b border-grey-light p-2">
          <div class="flex flex-col">
            <h3 class="cursor-pointer text-lg font-medium mt-1 flex justify-between items-center">
              <span>Meal</span>
              <font-awesome-icon
                class="text-blue"
                :icon="['fas', iconFor('meals')]"
              />
            </h3>
          </div>
          <div
            v-if="selectedMeals.length > 0"
            class="text-grey-dark"
          >
            <ul class="flex flex-wrap text-sm -m-2px leading-none">
              <li
                v-for="(meal, index) in selectedMeals"
                :key="index"
                class="rounded-lg bg-blue-light m-2px flex overflow-hidden"
              >
                <span class="px-3 py-1">{{ meal.title }}</span>
                <span
                  class="block bg-yellow px-2 py-1 cursor-pointer"
                  @click.stop="removeMeal(meal)"
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
          <ul>
            <li
              v-for="(meal, index) in filteredMeals"
              :key="index"
              class="py-1 border-b border-dashed border-grey-off-dark transition-all cursor-pointer hover:bg-grey-off-dark"
              @click.prevent="selectMeal(meal)"
            >
              <span>{{ meal.title }}</span>
              <span class="text-xs">({{ meal.recipes_count }} Recipes)</span>
            </li>
          </ul>
        </div>
      </template>
    </global-ui-accordion>

    <global-ui-accordion
      group="filters"
      name="features"
    >
      <template #title>
        <div class="border-b border-grey-light p-2">
          <div class="flex flex-col">
            <h3 class="cursor-pointer text-lg font-medium mt-1 flex justify-between items-center">
              <span>Features</span>
              <font-awesome-icon
                class="text-blue"
                :icon="['fas', iconFor('meals')]"
              />
            </h3>
          </div>
          <div
            v-if="selectedFeatures.length > 0"
            class="text-grey-dark"
          >
            <ul class="flex flex-wrap text-sm -m-2px leading-none">
              <li
                v-for="(feature, index) in selectedFeatures"
                :key="index"
                class="rounded-lg bg-blue-light m-2px flex overflow-hidden"
              >
                <span class="px-3 py-1">{{ feature.title }}</span>
                <span
                  class="block bg-yellow px-2 py-1 cursor-pointer"
                  @click.stop="removeFeature(feature)"
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
          <ul>
            <li
              v-for="(feature, index) in filteredFeatures"
              :key="index"
              class="py-1 border-b border-dashed border-grey-off-dark transition-all cursor-pointer hover:bg-grey-off-dark"
              @click.prevent="selectFeature(feature)"
            >
              <span>{{ feature.title }}</span>
              <span class="text-xs">({{ feature.recipes_count }} Recipes)</span>
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
    allergens: [],
    selectedAllergens: [],

    features: [],
    selectedFeatures: [],

    meals: [],
    selectedMeals: [],

    accordions: {
      freefrom: false,
      meals: false,
      features: false,
    },
  }),

  computed: {
    filteredAllergens() {
      return this.allergens.filter((allergen) => this.selectedAllergens.indexOf(allergen) === -1).slice(0, 14);
    },

    filteredFeatures() {
      return this.features.filter((feature) => this.selectedFeatures.indexOf(feature) === -1).slice(0, 14);
    },

    filteredMeals() {
      return this.meals.filter((meal) => this.selectedMeals.indexOf(meal) === -1).slice(0, 14);
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
      coeliac().request().get(this.buildUrl('/api/recipes/allergens', 1, this.currentSearch, this.currentFilters))
        .then((response) => {
          this.allergens = response.data.data;
          this.selectedAllergens = [];

          if (this.currentFilters) {
            this.currentFilters.freefrom.forEach((currentFilter) => {
              this.selectedAllergens.push(
                this.allergens.filter((allergen) => allergen.title === currentFilter)[0],
              );
            });
          }
        });

      coeliac().request().get(this.buildUrl('/api/recipes/features', 1, this.currentSearch, this.currentFilters))
        .then((response) => {
          this.features = response.data.data;
          this.selectedFeatures = [];

          if (this.currentFilters) {
            this.currentFilters.feature.forEach((currentFilter) => {
              this.selectedFeatures.push(
                this.features.filter((feature) => feature.title === currentFilter)[0],
              );
            });
          }
        });

      coeliac().request().get(this.buildUrl('/api/recipes/meals', 1, this.currentSearch, this.currentFilters))
        .then((response) => {
          this.meals = response.data.data;
          this.selectedMeals = [];

          if (this.currentFilters) {
            this.currentFilters.meal.forEach((currentFilter) => {
              this.selectedMeals.push(
                this.meals.filter((meal) => meal.title === currentFilter)[0],
              );
            });
          }
        });
    },

    selectAllergen(allergen) {
      this.$root.$emit('add-filter', {
        name: 'freefrom',
        value: allergen.title,
      });
    },

    removeAllergen(allergen) {
      this.selectedAllergens = this.selectedAllergens.filter((allergens) => allergens.title !== allergen.title);

      this.$root.$emit('remove-filter', {
        name: 'freefrom',
        value: allergen.title,
      });
    },

    selectFeature(feature) {
      this.$root.$emit('add-filter', {
        name: 'feature',
        value: feature.title,
      });
    },

    removeFeature(feature) {
      this.selectedFeatures = this.selectedFeatures.filter((selectedFeature) => selectedFeature.title !== feature.title);

      this.$root.$emit('remove-filter', {
        name: 'feature',
        value: feature.title,
      });
    },

    selectMeal(meal) {
      this.$root.$emit('add-filter', {
        name: 'meal',
        value: meal.title,
      });
    },

    removeMeal(meal) {
      this.selectedMeals = this.selectedMeals.filter((meals) => meals.title !== meal.title);

      this.$root.$emit('remove-filter', {
        name: 'meal',
        value: meal.title,
      });
    },

    iconFor(filter) {
      return this.accordions[filter] ? 'chevron-up' : 'chevron-down';
    },
  },
};
</script>
