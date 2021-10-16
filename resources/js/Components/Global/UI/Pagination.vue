<template>
  <ul
    v-if="lastPage > 1"
    class="flex flex-wrap font-semibold leading-none justify-center"
  >
    <li
      v-if="canGoBack"
      class="border border-blue-light bg-blue-light text-white rounded m-px cursor-pointer transition-all transition-all hover:bg-white hover:text-blue-light"
    >
      <a
        class="p-2 block"
        @click.prevent="goTo('prev')"
      >
        Previous
      </a>
    </li>

    <li
      v-for="page in pageArray"
      :key="page.goto"
      class="border border-blue-light rounded m-px cursor-pointer transition-all"
      :class="page.goTo !== current ? 'bg-blue-light text-white hover:bg-white hover:text-blue-light' : 'bg-white text-blue-light'"
    >
      <a
        class="p-2 block"
        @click.prevent="goTo(page.goTo)"
      >
        {{ page.label }}
      </a>
    </li>

    <li
      v-if="canGoForward"
      class="border border-blue-light bg-blue-light text-white rounded m-px cursor-pointer transition-all hover:bg-white hover:text-blue-light"
    >
      <a
        class="p-2 block"
        @click.prevent="goTo('next')"
      >Next</a>
    </li>
  </ul>
</template>

<script>
export default {
  props: {
    current: {
      required: true,
      type: Number,
    },
    lastPage: {
      required: true,
      type: Number,
    },
    canGoBack: {
      required: true,
      type: Boolean,
    },
    canGoForward: {
      required: true,
      type: Boolean,
    },
  },

  computed: {
    pageArray() {
      const data = [];
      const multiples = Math.ceil(this.lastPage / 5);
      const groups = [];

      // eslint-disable-next-line no-plusplus
      for (let x = 0; x < multiples; x++) {
        const group = [];
        // eslint-disable-next-line no-plusplus
        for (let y = 1; y <= 5; y++) {
          group.push((x * 5) + y);
        }
        groups.push(group);
      }

      data.push({
        label: '1',
        goTo: 1,
      });

      if (this.current > 5) {
        data.push({
          label: '...',
          goTo: this.current - 1,
        });
      }

      const currentGroup = groups.findIndex((page) => page.indexOf(this.current) !== -1);

      groups[currentGroup].forEach((page) => {
        if (page > 1 && page < this.lastPage) {
          data.push({
            label: page.toString(),
            goTo: page,
          });
        }
      });

      if (currentGroup + 1 < groups.length) {
        data.push({
          label: '...',
          goTo: groups[currentGroup + 1][0],
        });
      }

      data.push({
        label: this.lastPage.toString(),
        goTo: this.lastPage,
      });

      return data;
    },
  },

  methods: {
    goTo(page) {
      this.$root.$emit('pagination-click', page);
    },
  },
};
</script>
