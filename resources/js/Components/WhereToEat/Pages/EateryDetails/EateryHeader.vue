<template>
  <div class="page-box page-box-no-padding flex flex-col space-y-3">
    <div class="flex justify-between items-center bg-grey-light p-3">
      <a
        v-if="eatery.county.id > 1"
        class="flex-1 text-xs font-semibold font-sans hover:text-blue-dark transition-all"
        :href="'/wheretoeat/'+eatery.county.slug+'/'+eatery.town.slug"
      >
        <font-awesome-icon
          :icon="['fas', 'arrow-left']"
          class="mr-2"
        />
        Back to all locations in {{ eatery.town.town }}
      </a>

      <a
        v-else
        class="flex-1 text-xs font-semibold font-sans hover:text-blue-dark transition-all"
        href="/wheretoeat/nationwide"
      >
        <font-awesome-icon
          :icon="['fas', 'arrow-left']"
          class="mr-2"
        />
        Back to all nationwide eateries
      </a>

      <div class="flex justify-center relative">
        <div
          class="mr-2 text-3xl text-grey cursor-pointer hover:text-social-facebook transition-all"
          @click.prevent="facebookShare()"
        >
          <font-awesome-icon :icon="['fab', 'facebook-square']" />
        </div>

        <div
          class="mr-2 text-3xl text-grey cursor-pointer hover:text-social-twitter transition-all"
          @click.prevent="twitterShare()"
        >
          <font-awesome-icon :icon="['fab', 'twitter-square']" />
        </div>

        <div
          class="mr-2 text-3xl text-grey cursor-pointer hover:text-social-pinterest transition-all"
          @click.prevent="pinterestShare()"
        >
          <font-awesome-icon :icon="['fab', 'pinterest-square']" />
        </div>

        <div
          class="text-3xl text-grey cursor-pointer hover:text-social-reddit transition-all"
          @click.prevent="redditShare()"
        >
          <font-awesome-icon :icon="['fab', 'reddit-square']" />
        </div>
      </div>
    </div>

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

      <div class="flex space-x-3 text-sm font-semibold px-3 text-grey-darker mt-1">
        {{ eatery.venueType.venue_type }}, {{ eatery.cuisine.cuisine }}
      </div>
    </div>

    <ul
      class="flex space-x-2 items-center px-3"
    >
      <li
        v-if="eatery.county.id > 1"
        class="bg-blue-light bg-opacity-25 rounded px-3 py-1 leading-none"
      >
        <a
          class="text-sm font-semibold text-grey hover:text-black transition-all ease-in-out cursor-pointer"
          @click.prevent="viewMap = true"
        >
          <font-awesome-icon
            :icon="['far', 'map']"
            class="mr-1"
          />

          <span>Map</span>
        </a>
      </li>

      <li
        v-if="eatery.website"
        class="bg-blue-light bg-opacity-25 rounded px-3 py-1 leading-none"
      >
        <a
          class="text-sm font-semibold text-grey hover:text-black transition-all ease-in-out"
          :href="eatery.website"
          target="_blank"
        >
          <font-awesome-icon
            :icon="['fas', 'external-link-alt']"
            class="mr-2"
          />
          <span>Website</span>
        </a>
      </li>

      <li
        v-if="eatery.phone"
        class="bg-blue-light bg-opacity-25 rounded px-3 py-1 leading-none"
      >
        <a
          class="text-sm font-semibold text-grey hover:text-black transition-all ease-in-out"
          :href="'tel:'+eatery.phone"
          target="_blank"
        >
          <font-awesome-icon
            :icon="['fas', 'mobile-alt']"
            class="mr-2"
          />
          <span>Phone</span>
        </a>
      </li>

      <li
        v-if="eatery.gf_menu_link"
        class="hidden xs:block bg-blue-light bg-opacity-25 rounded px-3 py-1 leading-none"
      >
        <a
          class="text-sm font-semibold text-grey hover:text-black transition-all ease-in-out"
          :href="eatery.gf_menu_link"
          target="_blank"
        >
          <font-awesome-icon
            :icon="['far', 'sticky-note']"
            class="mr-2"
          />
          <span>GF Menu</span>
          <font-awesome-icon
            :icon="['fas', 'link']"
            class="ml-1"
          />
        </a>
      </li>

      <li
        v-if="eatery.average_price_range"
        class="hidden md:block bg-blue-light bg-opacity-25 rounded px-3 py-1 leading-none"
      >
        <a
          class="text-sm font-semibold text-grey hover:text-black transition-all ease-in-out"
        >
          <font-awesome-icon
            :icon="['fas', 'wallet']"
            class="mr-2"
          />
          <span>{{ averagePriceRange }} - {{ eatery.average_price_range.label }}</span>
        </a>
      </li>
    </ul>

    <div class="flex flex-col space-y-3 bg-grey-light p-3">
      <div class="flex space-x-1 text-sm items-center leading-none">
        <span>Rated</span>
        <global-ui-stars
          :stars="eatery.average_rating"
          size="text-base"
          half-star="star-half-alt"
          show-all
        />
        <span>from <strong>{{ eatery.userReviews.length }}</strong> review{{
          eatery.userReviews.length > 1 ? 's' : ''
        }}</span>
      </div>
    </div>

    <portal
      v-if="viewMap"
      to="modal"
    >
      <modal
        modal-classes="w-full h-full"
        :title="eatery.formatted_address"
        name="map"
      >
        <dynamic-map
          :lat="eatery.lat"
          :lng="eatery.lng"
        />
      </modal>
    </portal>
  </div>
</template>

<script>
import ResponsiveOptions from '@/Mixins/ResponsiveOptions';
import DynamicMap from '~/Maps/Dynamic';
import Shareable from '@/Mixins/Shareable';
import GoogleEvents from '@/Mixins/GoogleEvents';

const Modal = () => import('~/Global/UI/Modal' /* webpackChunkName: "chunk-modal" */);

export default {
  components: {
    'dynamic-map': DynamicMap,
    modal: Modal,
  },

  mixins: [ResponsiveOptions, Shareable, GoogleEvents],

  props: {
    eatery: {
      type: Object,
      required: true,
    },
  },

  data: () => ({
    viewMap: false,
  }),

  computed: {
    averagePriceRange() {
      if (!this.eatery.average_price_range) {
        return null;
      }

      let rtr = '';

      for (let x = 0; x < parseInt(this.eatery.average_price_range.value); x += 1) {
        rtr += '£';
      }

      return rtr;
    },
  },

  mounted() {
    this.$root.$on('modal-closed', () => {
      this.viewMap = false;
    });
  },
};
</script>
