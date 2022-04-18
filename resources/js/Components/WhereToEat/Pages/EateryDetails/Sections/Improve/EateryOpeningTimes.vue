<template>
  <div class="text-sm">
    <ul class="flex flex-col space-y-px divide-y divide-grey-off">
      <li
        v-for="day in openingTimes"
        :key="day.key"
        class="flex flex-col w-full py-1 space-y-2 xs:flex-row xs:justify-between xs:space-x-2 xs:space-y-0 xs:items-center"
      >
        <div class="flex justify-between xs:flex-1 xs:items-center">
          <div>{{ day.label }}</div>

          <div class="flex space-x-2 items-center">
            <span>Closed</span>
            <form-checkbox
              :value="day.closed"
              :name="day.key+'_closed'"
              input-size="text-xs"
              highlight-style="background"
              highlight-colour="blue-light"
              rounded
            />
          </div>
        </div>

        <div class="flex space-x-1 items-center justify-between">
          <div class="flex space-x-px">
            <form-select
              :name="day.key+'_start_hour'"
              :options="hours"
              :value="!day.closed ? day.start[0] : 0"
              :disabled="day.closed"
              small
            />
            <form-select
              :name="day.key+'_start_minutes'"
              :options="minutes"
              :value="!day.closed ? day.start[1] : 0"
              :disabled="day.closed"
              small
            />
          </div>

          <span class="hidden xs:block">-</span>

          <div class="flex space-x-px">
            <form-select
              :name="day.key+'_end_hour'"
              :options="hours"
              :value="!day.closed ? day.end[0] : 0"
              :disabled="day.closed"
              small
            />
            <form-select
              :name="day.key+'_end_minutes'"
              :options="minutes"
              :value="!day.closed ? day.end[1] : 0"
              :disabled="day.closed"
              small
            />
          </div>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
const FormSelect = () => import('~/Forms/Select' /* webpackChunkName: "chunk-form-select" */);
const FormCheckbox = () => import('~/Forms/Checkbox' /* webpackChunkName: "chunk-form-checkbox" */);

export default {
  components: { FormSelect, FormCheckbox },

  props: {
    currentOpeningTimes: {
      required: true,
      type: Object,
    },
  },

  data: () => ({
    openingTimes: [],
  }),

  computed: {
    days() {
      return [
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday',
      ];
    },

    hours() {
      return Array.from({ length: 24 }).map((value, hour) => ({
        value: hour,
        label: (hour < 10 ? '0' : '') + hour.toString(),
      }));
    },

    minutes() {
      return [
        { value: 0, label: '00' },
        { value: 15, label: '15' },
        { value: 30, label: '30' },
        { value: 45, label: '45' },
      ];
    },
  },

  mounted() {
    this.openingTimes = this.days.map((day) => this.constructDay(day));

    this.days.forEach((day) => {
      const currentDayIndex = this.getCurrentDayIndex(day);

      this.$root.$on(`${day}_closed-change`, (checked) => {
        // this.openingTimes[currentDayIndex] = this.constructDay(day, checked);
        this.$set(this.openingTimes, currentDayIndex, this.constructDay(day, checked));

        this.emitChange();
      });

      this.$root.$on(`${day}_start_hour-change`, (time) => {
        this.openingTimes[currentDayIndex].start[0] = time;

        this.emitChange();
      });

      this.$root.$on(`${day}_start_minutes-change`, (time) => {
        this.openingTimes[currentDayIndex].start[1] = time;

        this.emitChange();
      });

      this.$root.$on(`${day}_end_hour-change`, (time) => {
        this.openingTimes[currentDayIndex].end[0] = time;

        this.emitChange();
      });

      this.$root.$on(`${day}_end_minutes-change`, (time) => {
        this.openingTimes[currentDayIndex].end[1] = time;

        this.emitChange();
      });
    });
  },

  methods: {
    constructDay(day, isClosed = null) {
      return {
        key: day,
        label: day.charAt(0).toUpperCase() + day.slice(1),
        closed: isClosed === null ? this.currentOpeningTimes[day][0] === null : isClosed,
        start: isClosed ? [null, null] : this.splitTime(this.currentOpeningTimes[day][0]),
        end: isClosed ? [null, null] : this.splitTime(this.currentOpeningTimes[day][1]),
      };
    },

    splitTime(time) {
      if (!time) {
        return [null, null];
      }

      const split = time.split(':');

      return [parseInt(split[0]), parseInt(split[1])];
    },

    getCurrentDayIndex(day) {
      const currentDay = this.openingTimes.filter((openingTime) => openingTime.key === day);

      return this.openingTimes.indexOf(currentDay[0]);
    },

    emitChange() {
      this.$root.$emit('opening_times-change', this.openingTimes);
    },
  },
};
</script>
