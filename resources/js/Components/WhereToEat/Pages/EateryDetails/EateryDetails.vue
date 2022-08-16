<template>
  <div class="flex flex-col space-y-3">
    <eatery-header :eatery="eatery" />

    <eatery-features
      v-if="eatery.features"
      :eatery="eatery"
    />

    <eatery-info :eatery="eatery" />

    <eatery-can-you-improve
      :id="eatery.id"
      :name="eatery.name"
    />

    <eatery-map
      :eatery="eatery"
      :has-images="eatery.userImages.length > 0"
    />

    <eatery-admin-review
      v-if="eatery.formattedReviews.admin"
      :eatery="eatery"
      :review="eatery.formattedReviews.admin[0]"
    />

    <eatery-photos :eatery="eatery" />

    <eatery-reviews
      :id="eatery.id"
      :name="eatery.name"
      :reviews="eatery.formattedReviews.guest || []"
      :has-been-rated="hasBeenRated"
      :is-nationwide="eatery.county.county === 'Nationwide'"
    />
  </div>
</template>

<script>
import Header from '~/WhereToEat/Pages/EateryDetails/Sections/Header/Header';
import EateryReviews from '~/WhereToEat/Pages/EateryDetails/Sections/Reviews/ReviewList';
import Features from '~/WhereToEat/Pages/EateryDetails/Sections/Features';
import Info from '~/WhereToEat/Pages/EateryDetails/Sections/Info';
import Map from '~/WhereToEat/Pages/EateryDetails/Sections/Map';
import CanYouImproveEatery from '~/WhereToEat/Pages/EateryDetails/Sections/Improve/CanYouImproveEatery';
import Photos from '~/WhereToEat/Pages/EateryDetails/Sections/Photos';
import AdminReview from './Sections/Reviews/AdminReview';

export default {
  components: {
    'eatery-header': Header,
    'eatery-reviews': EateryReviews,
    'eatery-admin-review': AdminReview,
    'eatery-features': Features,
    'eatery-info': Info,
    'eatery-map': Map,
    'eatery-photos': Photos,
    'eatery-can-you-improve': CanYouImproveEatery,
  },

  props: {
    eatery: {
      type: Object,
      required: true,
    },
  },

  data: () => ({
    hasBeenRated: false,
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
