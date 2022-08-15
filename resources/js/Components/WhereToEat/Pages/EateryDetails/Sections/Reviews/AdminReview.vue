<template>
  <div class="page-box flex flex-col w-full flex-1 space-y-2">
    <h3 class="text-lg font-semibold">
      Our Review
    </h3>

    <div class="flex flex-col space-y-2">
      <ul
        v-if="hasRatings"
        class="flex flex-col flex-1 mb-2 space-y-1 bg-blue-light bg-opacity-25 border border-blue rounded p-1 text-sm xs:flex-row xs:justify-around xs:space-y-0"
      >
        <li class="flex space-x-1 text-md mb-2">
          <strong>Our Rating</strong>
          <global-ui-stars
            :stars="review.rating"
            size="text-base md:text-lg"
            half-star="star-half-alt"
            show-all
          />
        </li>
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

      <p v-html="reviewBody()" />

      <template v-if="reviewLength > 500 && !displayFullReview">
        <a
          class="text-lg text-blue-dark hover:underline font-semibold cursor-pointer"
          @click.prevent="displayFullReview = true"
        >Read our full review!</a>
      </template>

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
          :alt-text="`Our photos of ${eatery.name}`"
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

  data: () => ({
    displayFullReview: false,
  }),

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

    reviewLength() {
      return this.review.body.length;
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

    reviewBody() {
      let { body } = this.review;

      if (this.reviewLength > 500 && !this.displayFullReview) {
        body = `${body.substring(0, body.indexOf(' ', 500))}...`;
      }

      return body.replaceAll('\n', '<br />');
    },
  },
};
</script>
