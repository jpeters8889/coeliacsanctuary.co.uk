<template>
  <div class="p-4">
    <ul class="space-y-2">
      <li
        v-for="(day, index) in days"
        :key="index"
        class="flex justify-between"
      >
        <span class="mr-4">{{ ucfirst(day) }}</span>
        <span
          v-if="isOpenOn(day)"
          v-text="openingTimeToString(day)"
        />
        <span v-else>Closed</span>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    openingTimes: {
      type: Object,
      required: true,
    },
  },

  data: () => ({
    days: ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'],
  }),

  methods: {
    isOpenOn(day) {
      return !!this.openingTimes[`${day}_start`];
    },

    openingTimeToString(day) {
      const openingTimes = this.openingTimesFor(day);

      return `${openingTimes.open} - ${openingTimes.close}`;
    },

    openingTimesFor(day) {
      return {
        open: this.formatTime(this.openingTimes[`${day}_start`]),
        close: this.formatTime(this.openingTimes[`${day}_end`]),
      };
    },

    formatTime(time) {
      const bits = time.split(':');

      return `${bits[0]}:${bits[1]}`;
    },

    ucfirst(str) {
      return str.charAt(0).toUpperCase() + str.slice(1);
    },
  },
};
</script>
