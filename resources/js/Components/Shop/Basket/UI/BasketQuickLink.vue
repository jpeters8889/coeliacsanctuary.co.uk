<template>
  <transition
    enter-active-class="duration-500 ease-out"
    enter-class="scale-50 translate-x-full opacity-0"
    enter-to-class="translate-x-0 scale-100 opacity-100"
    leave-active-class="duration-100 ease-in"
    leave-class="translate-x-0 scale-100 opacity-100"
    leave-to-class="translate-x-full scale-50 opacity-0"
  >
    <div
      v-if="isVisible"
      v-tooltip.left="{
        content: 'View your basket',
        classes: ['bg-blue-light', 'text-white', 'rounded-lg', 'mr-2', 'p-2', 'max-w-250', 'shadow']
      }"
      class="transition-all transform fixed bottom-1 right-1 leading-none bg-blue-light p-3 text-3xl text-white shadow-lg rounded cursor-pointer"
      @click="showBasket()"
    >
      <font-awesome-icon :icon="['fas', 'shopping-basket']" />
    </div>
  </transition>
</template>

<script>
import Vue from 'vue';
import { VTooltip } from 'v-tooltip';

Vue.directive('tooltip', VTooltip);

export default {
  data: () => ({
    isVisible: false,
  }),

  mounted() {
    new IntersectionObserver((entries) => {
      this.isVisible = entries[0].intersectionRatio === 0;
    }).observe(document.querySelector('#header-basket-detail'));
  },

  methods: {
    showBasket() {
      this.$root.$emit('show-basket');
    },
  },
};
</script>
