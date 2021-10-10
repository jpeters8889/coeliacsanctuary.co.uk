<template>
  <div>
    <div
      class="js-search-icon cursor-pointer"
      @click="showSearch()"
    >
      <font-awesome-icon :icon="['fas', 'search']" />
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    showSearch() {
      this.$root.$emit('show-quick-search');
    },
  },
};
</script>
