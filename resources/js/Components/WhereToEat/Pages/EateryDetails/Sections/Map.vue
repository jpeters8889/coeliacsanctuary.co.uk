<template>
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
</template>

<script>
export default {
  props: {
    eatery: {
      type: Object,
      required: true,
    },
  },
};
</script>
