<template>
  <div
    class="flex text-yellow"
    :class="[
      {
        'justify-center sm:justify-start': align === 'center',
        'justifyEnd': align !== 'center',
      },
      size,
    ]"
  >
    <font-awesome-icon
      v-for="n in wholeNumber"
      :key="n"
      :icon="['fas', 'star']"
    />
    <font-awesome-icon
      v-if="hasHalf"
      :icon="['fas', halfStar]"
    />
    <template v-if="showAll && (wholeNumber < 5 || (wholeNumber < 4 && hasHalf))">
      <font-awesome-icon
        v-for="n in remainingStars"
        :key="n"
        :icon="['far', 'star']"
      />
    </template>
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
    size: {
      type: String,
      default: 'text-lg',
    },
    halfStar: {
      type: String,
      default: 'star-half',
    },
    showAll: {
      type: Boolean,
      default: () => false,
    },
  },

  data: () => ({
    wholeNumber: 0,
    hasHalf: false,
  }),

  computed: {
    remainingStars() {
      const remaining = 5 - this.wholeNumber;

      return new Array(remaining);
    },
  },

  mounted() {
    let stars = '0.0';

    if (this.stars) {
      stars = this.stars;
    }

    const parts = stars.split('.');

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
