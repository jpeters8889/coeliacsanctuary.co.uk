<template>
  <ul class="flex flex-wrap gap-2 items-center px-3">
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
      v-if="eatery.average_expense"
      class="hidden md:block bg-blue-light bg-opacity-25 rounded px-3 py-1 leading-none"
    >
      <a
        class="text-sm font-semibold text-grey hover:text-black transition-all ease-in-out"
      >
        <font-awesome-icon
          :icon="['fas', 'wallet']"
          class="mr-2"
        />
        <span>{{ averageExpense }} - {{ eatery.average_expense.label }}</span>
      </a>
    </li>

    <li
      v-if="eatery.openingTimes"
      class="hidden md:block bg-blue-light bg-opacity-25 rounded px-3 py-1 leading-none"
    >
      <a
        class="text-sm font-semibold text-grey hover:text-black transition-all ease-in-out cursor-pointer"
        @click.prevent="viewOpeningTimes = true"
      >
        <font-awesome-icon
          :icon="['far', 'clock']"
          class="mr-2"
        />
        <span>{{ openText }}</span>
      </a>
    </li>

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

    <portal
      v-if="viewOpeningTimes"
      to="modal"
    >
      <modal
        title="Opening Times"
        name="opening-times"
        modal-classes="w-full max-w-[400px]"
      >
        <opening-times-modal :opening-times="eatery.openingTimes" />
      </modal>
    </portal>
  </ul>
</template>

<script>
import Shareable from '@/Mixins/Shareable';
import GoogleEvents from '@/Mixins/GoogleEvents';
import DynamicMap from '~/Maps/Dynamic';
import WhereToEatOpeningTimes from '~/WhereToEat/Modals/WhereToEatOpeningTimes';

const Modal = () => import('~/Global/UI/Modal' /* webpackChunkName: "chunk-modal" */);

export default {
  components: {
    'dynamic-map': DynamicMap,
    modal: Modal,
    'opening-times-modal': WhereToEatOpeningTimes,
  },

  mixins: [Shareable, GoogleEvents],

  props: {
    eatery: {
      type: Object,
      required: true,
    },
  },

  data: () => ({
    viewMap: false,
    viewOpeningTimes: false,
  }),

  computed: {
    averageExpense() {
      if (!this.eatery.average_expense) {
        return null;
      }

      let rtr = '';

      for (let x = 0; x < parseInt(this.eatery.average_expense.value); x += 1) {
        rtr += '£';
      }

      return rtr;
    },

    openText() {
      if (!this.eatery.openingTimes.is_open_now) {
        return 'Currently Closed';
      }

      return `Open, closes at ${this.eatery.openingTimes.closes_at}`;
    },
  },

  mounted() {
    this.$root.$on('modal-closed', () => {
      this.viewMap = false;
      this.viewOpeningTimes = false;
    });
  },
};
</script>
