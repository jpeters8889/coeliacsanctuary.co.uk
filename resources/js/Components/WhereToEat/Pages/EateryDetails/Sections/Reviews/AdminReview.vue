<template>
  <div class="page-box flex flex-col w-full flex-1 space-y-2">
    <h3 class="text-lg font-semibold">
      Our Review
    </h3>

    <p>Here's what we thought when we visited <strong>{{ eatery.name }}</strong> on {{ formatDate(review.created_at) }}</p>

    <div class="flex flex-col space-y-2">
      <ul
        v-if="hasRatings"
        class="flex flex-col flex-1 mb-2 space-y-1 bg-blue-light bg-opacity-25 border border-blue rounded p-1 text-sm xs:flex-row xs:justify-around xs:space-y-0"
      >
        <li
          v-if="review.how_expensive"
          v-html="howExpensive(review)"
        />
        <li v-if="review.food_rating">
          <strong>Food</strong>: {{ ucfirst(review.food_rating) }}
        </li>
        <li v-if="review.service_rating">
          <strong>Service</strong>: {{ ucfirst(review.service_rating) }}
        </li>
      </ul>

      <p v-html="review.body.replaceAll('\n', '<br />')" />

      <div
        v-if="review.images"
        class="flex flex-col bg-blue-light bg-opacity-25 border border-blue rounded p-2"
      >
        <p class="font-semibold text-md">
          Our Photos
        </p>

        <image-gallery
          :images="review.images"
          with-margin
          :alt-text="`Our photos of ${eatery} by on ${formatDate(review.created_at)}`"
        />
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
      type: Object,
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

      return `<strong>${rtr}</strong> - ${this.howExpensiveValues[this.review.how_expensive - 1].label}`;
    },

    ucfirst(str) {
      return str.charAt(0).toUpperCase() + str.slice(1);
    },
  },
};
</script>
