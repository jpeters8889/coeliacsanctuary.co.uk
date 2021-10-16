<template>
  <div
    class="flex text-yellow text-lg"
    :class="align === 'center' ? 'justify-center sm:justify-start' : 'justify-end'"
  >
    <font-awesome-icon
      v-for="n in wholeNumber"
      :key="n"
      :icon="['fas', 'star']"
    />
    <font-awesome-icon
      v-if="hasHalf"
      :icon="['fas', 'star-half']"
    />
  </div>
</template>

<script>
export default {
  props: {
    stars: {
      required: true,
      type: String,
    },
    align: {
      type: String,
      default: 'center',
    },
  },

  data: () => ({
    wholeNumber: 0,
    hasHalf: false,
  }),

  mounted() {
    const parts = this.stars.split('.');

    this.wholeNumber = parseInt(parts[0]);
    const remainingNumber = parts[1] ? parseInt(parts[1].charAt(0)) : 0;

    this.hasHalf = remainingNumber > 3 && remainingNumber < 7;

    if (remainingNumber > 0 && remainingNumber <= 3) {
      this.wholeNumber -= 1;
    }

    if (remainingNumber >= 7) {
      this.wholeNumber += 1;
    }
  },
};
</script>
