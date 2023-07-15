<template>
  <div
    v-if="eatery.county.id !== 1 || branch"
    class="page-box flex flex-col space-y-3 sm:flex-row sm:space-y-0 sm:space-x-3"
  >
    <div class="w-full h-map-small sm:w-1/2 lg:w-2/3 max-w-[600px]">
      <map-static v-bind="latLng"/>
    </div>

    <ul class="flex flex-col space-y-3 sm:w-1/2 lg:flex-1">
      <li class="flex items-center space-x-3">
        <font-awesome-icon
          :icon="['fas', 'map-marker-alt']"
          fixed-width
          class="text-xl"
        />
        <span class="text-sm font-semibold" v-html="address" />
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

          <span class="text-sm font-semibold">{{ eatery.phone }}</span>
        </a>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    eatery: {
      type: Object,
      required: true,
    },
    hasImages: {
      type: Boolean,
      required: true,
    },
    branch: {
      type: Object,
      required: false,
    },
  },

  computed: {
    latLng() {
      if (this.branch) {
        return {
          lat: this.branch.lat,
          lng: this.branch.lng,
        };
      }

      return {
        lat: this.eatery.lat,
        lng: this.eatery.lng,
      };
    },

    address() {
      return this.branch ? this.branch.formatted_address : this.eatery.formatted_address;
    }
  },
};
</script>
