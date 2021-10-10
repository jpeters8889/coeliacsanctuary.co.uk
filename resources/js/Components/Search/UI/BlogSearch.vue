<template>
  <div class="flex">
    <input
      v-model="searchText"
      type="search"
      placeholder="Search..."
      class="text-sm p-1 flex-1 bg-grey-lightest border border-grey-off"
      style="border-top-left-radius: 0.25rem; border-bottom-left-radius: 0.25rem"
      @keyup.enter="search()"
    >
    <button
      class="bg-blue text-grey-lightest px-2"
      style="border-top-right-radius: 0.25rem; border-bottom-right-radius: 0.25rem"
      @click="search()"
    >
      <font-awesome-icon :icon="['fas', 'search']" />
    </button>
  </div>
</template>

<script>
export default {
  data: () => ({
    searchText: '',
  }),

  methods: {
    search() {
      const searchText = btoa(`search=${this.searchText}`);
      window.location.href = `/blog?o=${searchText}`;
    },
  },
};
</script>
