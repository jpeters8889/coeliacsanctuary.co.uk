<template>
  <div class="flex flex-col space-y-3">
    <div class="page-box space-y-3">
      <h2 class="text-xl font-semibold">
        Your Reviews ({{ reviews.length }})
      </h2>

      <p class="bg-blue bg-opacity-20 p-2 border border-blue text-sm rounded-lg">
        All the reviews and ratings below have been submitted by visitors to our website and App,
        ratings are applied straight away but text reviews must be validated by an admin before
        they are visible.
      </p>
    </div>

    <EateryAddReview
      v-if="!hasBeenRated"
      :id="id"
      :name="name"
    />

    <div
      v-if="hasJustBeenRated"
      class="page-box"
    >
      <p>
        Thank you for leaving your review of <strong>{{ name }}</strong>
      </p>
    </div>

    <template v-if="reviews.length">
      <template v-for="review in reviews">
        <eatery-review
          :key="review.id"
          :eatery="name"
          :review="review"
        />
      </template>
    </template>
  </div>
</template>

<script>
import EateryAddReview from '~/WhereToEat/Pages/EateryDetails/Sections/Reviews/Add';
import Review from '~/WhereToEat/Pages/EateryDetails/Sections/Reviews/Review';

export default {
  components: { EateryAddReview, 'eatery-review': Review },

  props: {
    id: {
      type: Number,
      required: true,
    },
    name: {
      type: String,
      required: true,
    },
    reviews: {
      type: Array,
      required: true,
    },
    hasBeenRated: {
      type: Boolean,
      required: true,
    },
  },

  data: () => ({
    hasJustBeenRated: false,
  }),

  mounted() {
    this.$root.$on('rated-place', (id) => {
      if (id !== this.id) {
        return;
      }

      this.hasJustBeenRated = true;
    });
  },
};
</script>
