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
      <div
        v-for="review in reviews"
        :key="review.id"
        class="page-box page-box-no-padding flex flex-col"
      >
        <div class="bg-grey-light px-3 py-1 flex justify-between text-sm items-center border-b border-grey-off">
          <global-ui-stars
            :stars="review.rating"
            size="text-base"
            half-star="star-half-alt"
            show-all
          />

          <span v-if="review.price_range">
            {{ priceRange(review) }} - {{ review.price.label }}
          </span>

          <span>{{ review.human_date }}</span>
        </div>

        <div class="p-3 space-y-3">
          <p v-if="review.body">
            {{ review.body }}
          </p>
          <p
            v-else
            class="italic"
          >
            Reviewer didn't leave a comment...
          </p>
        </div>

        <div
          class="bg-grey-light px-3 py-1 flex justify-between text-sm items-center border-t border-grey-off"
        >
          <span>{{ review.name || '' }}</span>
          <span>{{ formatDate(review.created_at) }}</span>
        </div>
      </div>
    </template>
  </div>
</template>

<script>
import FormatsDates from '@/Mixins/FormatsDates';
import EateryAddReview from '~/WhereToEat/Pages/EateryDetails/EateryAddReview';

export default {
  components: { EateryAddReview },
  mixins: [FormatsDates],

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

  methods: {
    priceRange(review) {
      let rtr = '';

      for (let x = 0; x < parseInt(review.price_range); x += 1) {
        rtr += '£';
      }

      return rtr;
    },
  },
};
</script>
