<template>
  <div class="my-2 w-full">
    <div v-if="ratings.length > 0">
      <div class="flex justify-between items-center sm:flex-row-reverse">
        <span class="flex-1 sm:mr-2">
          Rated <strong>{{ average }} stars</strong> from
          <strong>{{ ratings.length }} review{{ ratings.length > 1 ? 's' : '' }}</strong>
        </span>
        <global-ui-stars :stars="average" />
      </div>
      <a
        class="mt-2 font-semibold text-blue transition-all cursor-pointer hover:text-grey"
        @click="showDetails = true"
      >
        View Comments and Ratings
      </a>
    </div>

    <div class="mt-2">
      <h3>Have you visited {{ name }}? How would you rate it?</h3>

      <em v-if="hasBeenRated">Sorry, you've already rated this location...</em>
      <div
        v-else
        class="text-3xl flex justify-center sm:justify-start xs:mt-1"
      >
        <span
          v-for="n in 5"
          :key="n+1"
          class="wteRater cursor-pointer"
          :class="n <= hoveringOn ? 'text-yellow' : 'text-grey-off'"
          @mouseover="hoveringOn = n"
          @mouseleave="hoveringOn = null"
          @click.prevent="rate(n)"
        >
          <font-awesome-icon :icon="['fas', 'star']" />
        </span>
      </div>
    </div>

    <portal
      v-if="showDetails"
      to="modal"
    >
      <modal
        name="showDetails"
        :title="'Ratings for '+name"
      >
        <div class="flex flex-col p-3">
          <p class="pb-2 mb-2 border-b border-blue border-opacity-50">
            All the reviews and ratings below have been submitted by visitors to our website and App,
            ratings are applied straight away but text reviews must be validated by an admin before
            they are visible.
          </p>

          <div
            v-for="rating in ratings"
            :key="rating.id"
          >
            <template v-if="!rating.body">
              <div class="font-semibold mb-2">
                {{ formatDate(rating.created_at) }}
                <global-ui-stars :stars="rating.rating.toString()" />
              </div>
              <div class="mt-1">
                <em>Reviewer didn't leave a comment...</em>
              </div>
            </template>
            <template v-else>
              <div class="font-semibold mb-2">
                {{ rating.name }}, {{ formatDate(rating.created_at) }}
                <global-ui-stars :stars="rating.rating.toString()" />
              </div>
              <div class="mt-1">
                {{ rating.body }}
              </div>
            </template>
          </div>
        </div>
      </modal>
    </portal>

    <portal
      v-if="showCreateRating"
      to="modal"
    >
      <modal
        name="showCreate"
        title="Do you want to save a review with your rating?"
      >
        <wheretoeat-create-rating
          :id="id"
          :rating="ratingToSubmit"
        />
      </modal>
    </portal>
  </div>
</template>

<script>
import FormatsDates from '@/Mixins/FormatsDates';
import GoogleEvents from '@/Mixins/GoogleEvents';
import WhereToEatCreateRating from '~/WhereToEat/Modals/WhereToEatCreateRating';

const Modal = () => import('~/Global/UI/Modal' /* webpackChunkName: "chunk-modal" */);

export default {

  components: {
    modal: Modal,
    'wheretoeat-create-rating': WhereToEatCreateRating,
  },
  mixins: [FormatsDates, GoogleEvents],

  props: {
    id: {
      type: Number,
      required: true,
    },
    name: {
      type: String,
      required: true,
    },
    ratings: {
      type: Array,
      required: true,
    },
    average: {
      type: [String, null],
      required: true,
    },
    hasRated: {
      type: Boolean,
      required: true,
      default: false,
    },
  },

  data: () => ({
    hoveringOn: null,
    showDetails: false,
    showCreateRating: false,
    ratingToSubmit: 0,

    hasBeenRated: false,
  }),

  watch: {
    showDetails() {
      if (this.showDetails) {
        this.googleEvent('event', 'wheretoeat', {
          event_category: 'showed-rating-details',
          event_label: this.id,
        });
      }
    },

    showCreateRating() {
      if (this.showCreateRating) {
        this.googleEvent('event', 'wheretoeat', {
          event_category: 'created-rating',
          event_label: this.id,
        });
      }
    },
  },

  mounted() {
    this.hasBeenRated = this.hasRated;

    this.$root.$on('modal-closed', (modal) => {
      if (modal === 'showDetails') {
        this.showDetails = false;
      }

      if (modal === 'showCreate') {
        this.showCreateRating = false;
      }
    });

    this.$root.$on('rated-place', (id) => {
      if (id === this.id) {
        this.hasBeenRated = true;
      }
    });
  },

  methods: {
    rate(rating) {
      this.ratingToSubmit = rating;
      this.showCreateRating = true;
    },
  },
};
</script>
