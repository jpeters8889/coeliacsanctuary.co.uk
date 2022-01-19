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
      ref="openBasketIcon"
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
    observer: null,
    foundElement: false,
    isVisible: false,
  }),

  watch: {
    isVisible() {
      this.offsetIcon();
    },
  },

  mounted() {
    new IntersectionObserver((entries) => {
      this.isVisible = entries[0].intersectionRatio === 0;
    }).observe(document.querySelector('#header-basket-detail'));

    this.observer = new MutationObserver((mutations) => {
      mutations.forEach((mutation) => {
        if (this.foundElement) {
          return;
        }

        mutation.addedNodes.forEach((node) => {
          if (this.foundElement) {
            return;
          }

          if (node === document.querySelector('.adsbygoogle-noablate[data-ad-status="filled"]')) {
            this.offsetIcon();
            this.foundElement = true;
            this.observer = null;
          }
        });
      });
    });

    this.observer.observe(document.querySelector('body'), { attributes: true, childList: true, subtree: true });
  },

  methods: {
    showBasket() {
      this.$root.$emit('show-basket');
    },

    offsetIcon() {
      this.$nextTick(() => {
        if (!this.$refs.openBasketIcon) {
          return;
        }

        const adElement = document.querySelector('.adsbygoogle-noablate[data-ad-status="filled"]');

        if (!adElement || adElement.offsetHeight === 0) {
          return;
        }

        if (adElement.style.top === '0px') {
          return;
        }

        const height = adElement.offsetHeight + 10;

        this.$refs.openBasketIcon.style.margin = `${height}px`;
      });
    },
  },
};
</script>
