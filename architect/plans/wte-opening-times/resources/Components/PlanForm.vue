<template>
  <div>
    <div class="flex space-x-3 items-center">
      <span>Unknown / Not Set</span>

      <input
        type="checkbox"
        :checked="actualValue === null"
        @click="noOpeningTimes()"
      >
    </div>

    <template v-if="actualValue !== null">
      <div
        v-for="day in days"
        :key="day"
        class="flex justify-between space-y-2"
      >
        <label>{{ ucfirst(day) }}</label>
        <div class="flex space-x-2">
          <div>
            Closed
            <input
              type="checkbox"
              :checked="!actualValue[day]"
              @click="toggleDay(day)"
            >
          </div>
          <template v-if="actualValue[day]">
            <div class="flex space-x-1">
              <select v-model="actualValue[day][0][0]">
                <option
                  v-for="hour in hours"
                  :key="hour.value"
                  :value="hour.value"
                >
                  {{ hour.label }}
                </option>
              </select>

              <select v-model="actualValue[day][0][1]">
                <option
                  v-for="minute in minutes"
                  :key="minute.value"
                  :value="minute.value"
                >
                  {{ minute.label }}
                </option>
              </select>
            </div>

            <span>-</span>

            <div class="flex space-x-1">
              <select v-model="actualValue[day][1][0]">
                <option
                  v-for="hour in hours"
                  :key="hour.value"
                  :value="hour.value"
                >
                  {{ hour.label }}
                </option>
              </select>

              <select v-model="actualValue[day][1][1]">
                <option
                  v-for="minute in minutes"
                  :key="minute.value"
                  :value="minute.value"
                >
                  {{ minute.label }}
                </option>
              </select>
            </div>
          </template>
        </div>
      </div>
    </template>
  </div>
</template>

<script>
import { IsAFormField } from 'architect-js-helpers';

export default {
  mixins: [IsAFormField],

  computed: {
    days() {
      return Object.keys(this.actualValue);
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
    if (this.$route.params.id && this.actualValue === '') {
      // editing existing
      this.actualValue = null;
    }

    if (!this.$route.params.id) {
      this.actualValue = this.defaultValue();
    }
  },

  methods: {
    ucfirst(str) {
      return str.charAt(0).toUpperCase() + str.slice(1);
    },

    toggleDay(day) {
      if (this.actualValue[day]) {
        this.actualValue[day] = null;

        return;
      }

      this.actualValue[day] = [[0, 0, 0], [0, 0, 0]];
    },

    defaultValue() {
      return {
        monday: [[0, 0, 0], [0, 0, 0]],
        tuesday: [[0, 0, 0], [0, 0, 0]],
        wednesday: [[0, 0, 0], [0, 0, 0]],
        thursday: [[0, 0, 0], [0, 0, 0]],
        friday: [[0, 0, 0], [0, 0, 0]],
        saturday: [[0, 0, 0], [0, 0, 0]],
        sunday: [[0, 0, 0], [0, 0, 0]],
      };
    },

    noOpeningTimes() {
      if (this.actualValue) {
        this.actualValue = null;

        return;
      }

      this.actualValue = this.defaultValue();
    },
  },
};
</script>
