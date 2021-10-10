<template>
  <loader
    background="bg-black bg-opacity-80"
    background-position="fixed"
    :show="loading"
  />
</template>

<script>
const Loader = () => import('~/Global/UI/Loader' /* webpackChunkName: "chunk-loader" */);

export default {

  components: {
    loader: Loader,
  },
  data: () => ({
    loading: false,
  }),

  watch: {
    loading(value) {
      if (value) {
        document.querySelector('body').classList.add('overflow-hidden');
        return;
      }

      document.querySelector('body').classList.remove('overflow-hidden');
    },
  },

  mounted() {
    this.$root.$on('full-page-load', () => {
      this.loading = true;
    });

    this.$root.$on('hide-page-load', () => {
      this.loading = false;
    });
  },
};
</script>
