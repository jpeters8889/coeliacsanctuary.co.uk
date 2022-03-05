<template>
  <div class="flex flex-col space-y-3">
    <eatery-header :eatery="eatery" />

    <!-- Features -->
    <div
      v-if="eatery.features.length"
      class="page-box"
    >
      <p class="mb-2">
        Here are some highlights you can get at <strong>{{ eatery.name }}</strong>
      </p>

      <ul class="flex flex-wrap space-x-12">
        <li
          v-for="feature in eatery.features"
          :key="feature.id"
          class="leading-none items-center flex"
        >
          <div
            class="mr-2 flex-shrink-0 w-8"
          >
            <img
              :src="feature.image"
              :alt="feature.feature"
              class="w-full"
              width="100%"
              height="100%"
            >
          </div>

          <span class="block font-semibold leading-none">
            {{ feature.feature }}
          </span>
        </li>
      </ul>
    </div>

    <!-- Info -->
    <div class="page-box">
      <template v-if="eatery.restaurants.length">
        <div
          v-for="restaurant in eatery.restaurants"
          :key="restaurant.id"
        >
          <h4
            v-if="restaurant.restaurant_name"
            class="font-semibold"
          >
            {{ restaurant.restaurant_name }}
          </h4>

          <p class="text-sm">
            {{ restaurant.info }}
          </p>
        </div>
      </template>

      <template v-else>
        <p>{{ eatery.info }}</p>
      </template>

      <a
        class="cursor-pointer text-xs italic text-grey-dark cursor-pointer mt-2 font-semibold transition hover:text-grey-darkest"
        @click.prevent="showReportPlaceModal = true"
      >
        Is there a problem with this location? Let us know.
      </a>
    </div>

    <!-- Map -->
    <div
      v-if="eatery.county.id !== 1"
      class="page-box flex flex-col space-y-3 sm:flex-row sm:space-y-0 sm:space-x-3"
    >
      <div class="w-full h-map-small sm:w-1/2 lg:w-2/3 max-w-[600px]">
        <map-static
          :lat="eatery.lat"
          :lng="eatery.lng"
        />
      </div>

      <ul class="flex flex-col space-y-3 sm:w-1/2 lg:flex-1">
        <li class="flex items-center space-x-3">
          <font-awesome-icon
            :icon="['fas', 'map-marker-alt']"
            fixed-width
            class="text-xl"
          />
          <span class="text-sm font-semibold">{{ eatery.formatted_address }}</span>
        </li>

        <li v-if="eatery.website">
          <a
            :href="eatery.website"
            target="_blank"
            class="flex items-center space-x-3 transition hover:text-blue-dark"
          >
            <font-awesome-icon
              :icon="['fas', 'external-link-alt']"
              fixed-width
              class="text-xl"
            />

            <span class="text-sm font-semibold">Visit Website</span>
          </a>
        </li>

        <li
          v-if="eatery.phone"
        >
          <a
            :href="'tel:'+eatery.phone"
            class="flex items-center space-x-3 transition hover:text-blue-dark"
          >
            <font-awesome-icon
              :icon="['fas', 'mobile-alt']"
              fixed-width
              class="text-xl"
            />

            <span class="text-sm font-semibold">Call</span>
          </a>
        </li>
      </ul>
    </div>

    <eatery-reviews
      :id="eatery.id"
      :name="eatery.name"
      :reviews="eatery.userReviews"
      :has-been-rated="hasBeenRated"
    />

    <portal
      v-if="showReportPlaceModal"
      to="modal"
    >
      <modal :title="'Report ' + eatery.name">
        <report-place-modal :place="eatery" />
      </modal>
    </portal>
  </div>
</template>

<script>
import EateryHeader from '~/WhereToEat/Pages/EateryDetails/EateryHeader';
import EateryReviews from '~/WhereToEat/Pages/EateryDetails/EateryReviews';
import WhereToEatReportPlace from '~/WhereToEat/Modals/WhereToEatReportPlace';

const Modal = () => import('~/Global/UI/Modal' /* webpackChunkName: "chunk-modal" */);

export default {
  components: {
    'eatery-header': EateryHeader,
    'eatery-reviews': EateryReviews,
    modal: Modal,
    'report-place-modal': WhereToEatReportPlace,
  },

  props: {
    eatery: {
      type: Object,
      required: true,
    },
  },

  data: () => ({
    hasBeenRated: false,
    showReportPlaceModal: false,
  }),

  mounted() {
    this.hasBeenRated = this.eatery.has_been_rated;

    this.$root.$on('modal-closed', () => {
      this.showReportPlaceModal = false;
    });

    this.$root.$on('rated-place', (id) => {
      if (id !== this.eatery.id) {
        return;
      }

      this.hasBeenRated = true;
    });
  },
};
</script>
