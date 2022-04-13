<template>
  <div class="page-box page-box-no-padding flex border border-grey-off shadow">
    <div class="hidden sm:flex flex-col w-1/3 bg-grey-light md:w-1/4 max-w-[250px]">
      <div class="h-8 px-3 flex items-center">
        <global-ui-stars
          :stars="review.rating"
          size="text-base md:text-lg"
          half-star="star-half-alt"
          show-all
        />
      </div>
      <div
        class="flex-1 border-r border-grey-off px-3 pt-0 pb-3 flex flex-col"
        :class="hasRatings ? 'justify-between' : 'justify-end'"
      >
        <ul
          v-if="hasRatings"
          class="flex flex-col space-y-px text-sm flex-1 mb-2"
        >
          <li v-if="review.how_expensive">
            {{ howExpensive(review) }}
          </li>
          <li v-if="review.food_rating">
            Food: {{ ucfirst(review.food_rating) }}
          </li>
          <li v-if="review.service_rating">
            Service: {{ ucfirst(review.service_rating) }}
          </li>
        </ul>

        <ul class="flex flex-col space-y-px text-xs">
          <li v-if="review.name">
            {{ review.name }}
          </li>
          <li>
            {{ formatDate(review.created_at) }}
          </li>
        </ul>
      </div>
    </div>

    <div class="flex flex-col w-full flex-1">
      <div
        class="bg-grey-light px-3 py-1 flex justify-between text-sm items-center border-b border-grey-off sm:h-8 sm:justify-end"
      >
        <div class="sm:hidden">
          <global-ui-stars
            :stars="review.rating"
            size="text-base"
            half-star="star-half-alt"
            show-all
          />
        </div>

        <span>{{ review.human_date }}</span>
      </div>

      <div class="p-3 space-y-3">
        <template v-if="review.body">
          <div class="flex flex-col space-y-2">
            <p>{{ review.body }}</p>

            <image-gallery
              v-if="review.images"
              :images="review.images"
              :alt-text="`Photo of ${eatery} by ${review.name}`"
            />
          </div>
        </template>
        <p
          v-else
          class="italic"
        >
          Reviewer didn't leave a comment...
        </p>
      </div>

      <div
        class="bg-grey-light px-3 py-1 flex justify-between text-sm items-center border-t border-grey-off sm:hidden"
      >
        <span>{{ review.name || '' }}</span>
        <span>{{ formatDate(review.created_at) }}</span>
      </div>
    </div>
  </div>
</template>

<script>
import HasWhereToEatHowExpensiveValues from '@/Mixins/HasWhereToEatHowExpensiveValues';
import FormatsDates from '@/Mixins/FormatsDates';
import ImageGallery from '~/WhereToEat/Pages/EateryDetails/Sections/Shared/ImageGallery';

export default {

  components: { ImageGallery },
  mixins: [HasWhereToEatHowExpensiveValues, FormatsDates],

  props: {
    review: {
      type: Object,
      required: true,
    },
    eatery: {
      type: String,
      required: true,
    },
  },

  computed: {
    hasRatings() {
      if (this.review.how_expensive) {
        return true;
      }

      if (this.review.food_rating) {
        return true;
      }

      if (this.review.service_rating) {
        return true;
      }

      return false;
    },
  },

  methods: {
    howExpensive() {
      let rtr = '';

      for (let x = 0; x < parseInt(this.review.how_expensive); x += 1) {
        rtr += '£';
      }

      return `${rtr} - ${this.howExpensiveValues[this.review.how_expensive].label}`;
    },

    ucfirst(str) {
      return str.charAt(0).toUpperCase() + str.slice(1);
    },
  },
};
</script>
