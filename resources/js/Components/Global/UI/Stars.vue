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
    <template v-if="shouldShowEmptyStars()">
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
      let remaining = 5 - this.wholeNumber;

      if (this.hasHalf) {
        remaining -= 1;
      }

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

  methods: {
    shouldShowEmptyStars() {
      if (!this.showAll) {
        return false;
      }

      if (this.wholeNumber === 5) {
        return false;
      }

      if (this.wholeNumber === 4 && this.hasHalf) {
        return false;
      }

      return true;
    },
  },
};
</script>
