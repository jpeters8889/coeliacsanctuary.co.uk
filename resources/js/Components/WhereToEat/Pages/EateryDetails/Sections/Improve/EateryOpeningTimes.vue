<template>
  <div class="text-sm">
    <ul class="flex flex-col space-y-px divide-y divide-grey-off">
      <li
        v-for="day in openingTimes"
        :key="day.key"
        class="flex flex-col w-full py-1"
      >
        <span>{{ day.label }}</span>

        <div class="flex space-x-1 items-center justify-between">
          <div class="flex space-x-px">
            <form-select
              :name="day.key+'_start_hour'"
              :options="hours"
              :value="day.start[0]"
              small
            />
            <form-select
              :name="day.key+'_start_minutes'"
              :options="minutes"
              :value="day.start[1]"
              small
            />
          </div>

          <span class="hidden">-</span>

          <div class="flex space-x-px">
            <form-select
              :name="day.key+'_end_hour'"
              :options="hours"
              :value="day.end[0]"
              small
            />
            <form-select
              :name="day.key+'_end_minutes'"
              :options="minutes"
              :value="day.end[1]"
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

export default {
  components: { FormSelect },

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
    this.openingTimes = this.days.map((day) => ({
      key: day,
      label: day.charAt(0).toUpperCase() + day.slice(1),
      start: this.splitTime(this.currentOpeningTimes[day][0]),
      end: this.splitTime(this.currentOpeningTimes[day][1]),
    }));

    this.days.forEach((day) => {
      this.$root.$on(`${day}_start_hour-change`, (time) => {
        this.openingTimes[this.getCurrentDayIndex(day)].start[0] = time;

        this.emitChange();
      });

      this.$root.$on(`${day}_start_minutes-change`, (time) => {
        this.openingTimes[this.getCurrentDayIndex(day)].start[1] = time;

        this.emitChange();
      });

      this.$root.$on(`${day}_end_hour-change`, (time) => {
        this.openingTimes[this.getCurrentDayIndex(day)].end[0] = time;

        this.emitChange();
      });

      this.$root.$on(`${day}_end_minutes-change`, (time) => {
        this.openingTimes[this.getCurrentDayIndex(day)].end[1] = time;

        this.emitChange();
      });
    });
  },

  methods: {
    splitTime(time) {
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
