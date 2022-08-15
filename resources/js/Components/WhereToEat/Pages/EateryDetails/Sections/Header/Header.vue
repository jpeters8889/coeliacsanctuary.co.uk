<template>
  <div class="page-box page-box-no-padding flex flex-col space-y-3">
    <header-breadcrumbs :eatery="eatery" />

    <div>
      <div class="flex justify-between px-3">
        <h1 class="text-3xl font-coeliac font-semibold leading-tight">
          {{ eatery.name }}
        </h1>

        <div class="w-6 pt-2 xs:w-7">
          <img
            :src="eatery.icon"
            alt=""
            width="100%"
            height="100%"
          >
        </div>
      </div>

      <div
        v-if="eatery.userReviews.length > 0"
        class="px-3 flex justify-between items-center sm:flex-row-reverse"
      >
        <span class="flex-1 sm:mr-2">
          Rated <strong>{{ eatery.average_rating }} stars</strong> from
          <strong>{{ eatery.userReviews.length }} review{{ eatery.userReviews.length > 1 ? 's' : '' }}</strong>
        </span>

        <global-ui-stars
          :stars="eatery.average_rating"
          half-star="star-half-alt"
          show-all
        />
      </div>

      <div class="flex space-x-3 text-sm font-semibold px-3 text-grey-darker mt-1">
        {{ eatery.venueType.venue_type }}{{ eatery.cuisine.cuisine ? ', ' + eatery.cuisine.cuisine : '' }}
      </div>

      <div
        v-if="eatery.town.town !== 'Nationwide'"
        class="flex space-x-3 text-xs font-semibold px-3 text-grey-darker mt-1"
      >
        {{ eatery.town.town }}, {{ eatery.county.county }}
      </div>
    </div>

    <header-links :eatery="eatery" />

    <div
      v-if="eatery.formattedReviews.length"
      class="flex flex-col space-y-3 bg-grey-light p-3"
    >
      <div class="flex space-x-1 text-sm items-center leading-none">
        <span>Rated</span>
        <global-ui-stars
          :stars="eatery.average_rating"
          size="text-base"
          half-star="star-half-alt"
          show-all
        />
        <span>from <strong>{{ eatery.formattedReviews.length }}</strong> review{{
          eatery.formattedReviews.length > 1 ? 's' : ''
        }}</span>
      </div>
    </div>

    <div v-else />
  </div>
</template>

<script>
import ResponsiveOptions from '@/Mixins/ResponsiveOptions';
import Shareable from '@/Mixins/Shareable';
import GoogleEvents from '@/Mixins/GoogleEvents';
import Breadcrumbs from '~/WhereToEat/Pages/EateryDetails/Sections/Header/Breadcrumbs';
import Links from '~/WhereToEat/Pages/EateryDetails/Sections/Header/Links';

export default {
  components: {
    'header-breadcrumbs': Breadcrumbs,
    'header-links': Links,
  },

  mixins: [ResponsiveOptions, Shareable, GoogleEvents],

  props: {
    eatery: {
      type: Object,
      required: true,
    },
  },

};
</script>
