<template>
  <div class="w-full">
    <div
      id="top-bar"
      class="z-max w-full px-2 py-0 text-white text-3xl md:p-0 z-10"
      :class="backgroundClasses"
      :style="stickyNav ? 'position: fixed!important;' : ''"
    >
      <div class="flex justify-between items-center inner-wrapper md:relative py-2 md:py-0">
        <global-layout-mobile-nav class="mr-2 md:hidden" />
        <a href="/">
          <global-layout-coeliac-icon
            class="js-mob-icon text-white md:hidden"
            style="height: 1.875rem"
          />
        </a>
        <coeliac-nav
          v-show="width > 500"
          class="hidden md:block"
        />
        <div class="flex md:absolute md:right-0 md:top-0 md:mr-2 leading-none h-full z-50">
          <user-manager class="mr-2" />
          <search-ui-header class="h-full flex items-center " />
        </div>
      </div>
    </div>
    <div id="top-bar-check" />
  </div>
</template>

<script>
import CoeliacNav from '~/Global/Layout/CoeliacNav';
import UserManager from '~/Global/UI/UserManager';

export default {

  components: {
    'coeliac-nav': CoeliacNav,
    'user-manager': UserManager,
  },
  props: {
    transparent: {
      required: false,
      type: Boolean,
      default: () => false,
    },
  },

  data: () => ({
    stickyNav: false,
  }),

  computed: {
    backgroundClasses() {
      if (this.stickyNav) {
        return ['top-0', 'bg-blue', 'slide-down'];
      }

      if (!this.transparent) {
        return ['bg-blue', 'bg-opacity-80', 'md:bg-opacity-100'];
      }

      return [];
    },

    width() {
      return window.innerWidth;
    },
  },

  mounted() {
    new IntersectionObserver((entries) => {
      if (window.scrollY === 0) {
        this.stickyNav = false;
        return;
      }
      this.stickyNav = entries[0].intersectionRatio === 0;
    }).observe(document.querySelector('#top-bar-check'));
  },
};
</script>
