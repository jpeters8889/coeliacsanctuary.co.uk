<template>
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
