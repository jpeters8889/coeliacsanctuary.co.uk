<template>
  <div
    v-if="!loading"
    :class="wrapperClasses"
  >
    <div
      class="flex justify-between items-center"
      :class="{'cursor-pointer': details.status !== 'New'}"
    >
      <div
        class="text-2xl"
        @click="expand()"
      >
        {{ details.location }}
      </div>
      <div>{{ details.status }}</div>
    </div>

    <div
      v-show="expanded"
      class="flex flex-col space-y-2 w-full"
    >
      <div class="flex flex-col w-full">
        <div class="text-lg mb-2">
          <strong>Field</strong>
          {{ details.field_label }}
        </div>
        <div class="flex space-x-2 w-full">
          <div class="w-1/2 flex flex-col">
            <strong>Current Value</strong>
            <div v-html="processCurrentValue" />
          </div>

          <div class="w-1/2 flex flex-col">
            <strong>Recommended Value</strong>
            <div v-html="processedRecommendedValue" />
          </div>
        </div>
      </div>

      <div class="flex space-x-2">
        <a
          class="block rounded bg-blue-500 py-2 px-4 font-semibold hover:bg-opacity-75 cursor-pointer"
          :href="`/cs-adm/blueprints/wheretoeat/${details.eatery_id}`"
          target="_blank"
        >
          Open Eatery
        </a>

        <a
          v-if="details.status === 'New'"
          class="block rounded bg-green-500 py-2 px-4 font-semibold hover:bg-opacity-75 cursor-pointer"
          @click.prevent="accept()"
        >
          Mark as accepted
        </a>

        <a
          v-if="details.status === 'New'"
          class="block rounded bg-red-500 py-2 px-4 font-semibold hover:bg-opacity-75 cursor-pointer"
          @click.prevent="reject()"
        >
          Reject / Ignore
        </a>
      </div>
    </div>

    <div class="text-xs">
      <span>
        Created: {{ details.created_at }},
        last updated: {{ details.updated_at }}
      </span>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    data: {
      type: Object,
      required: true,
    },
    labels: {
      type: Array,
      required: false,
      default: () => [],
    },
  },

  data: () => ({
    loading: true,
    details: {},
    expanded: true,
  }),

  computed: {
    wrapperClasses() {
      const classes = ['flex', 'flex-col', 'space-y-2', '-m-4', 'p-4'];

      if (this.details.status === 'Accepted') {
        classes.push('bg-green-200', 'bg-opacity-75');
      }

      if (this.details.status === 'Rejected') {
        classes.push('bg-red-200', 'bg-opacity-75');
      }

      return classes;
    },

    processCurrentValue() {
      let rtr;

      switch (this.details.field) {
        case 'opening_times':
          if (!this.details.currentValue) {
            return 'None set';
          }

          // eslint-disable-next-line no-case-declarations
          const openingTimes = JSON.parse(this.details.currentValue);

          // eslint-disable-next-line no-case-declarations
          rtr = '<ul class="flex flex-col space-y-1">';

          openingTimes.forEach((openingTime) => {
            rtr += '<li class="flex space-x-2 items-center">';
            rtr += `<span class="font-semibold">${openingTime.label}</span>`;

            if (openingTime.closed) {
              rtr += '<span>Closed</span>';
            } else {
              delete openingTime.start[2];
              delete openingTime.end[2];

              if (openingTime.start[0] < 10) {
                openingTime.start[0] = `0${openingTime.start[0]}`;
              }
              if (openingTime.start[1] === 0) {
                openingTime.start[1] = '00';
              }
              if (openingTime.end[0] < 10) {
                openingTime.end[0] = `0${openingTime.end[0]}`;
              }
              if (openingTime.end[1] === 0) {
                openingTime.end[1] = '00';
              }

              rtr += `<span>${openingTime.start.join(':')}</span>`;
              rtr += '<span>-</span>';
              rtr += `<span>${openingTime.end.join(':')}</span>`;
            }

            rtr += '</li>';
          });

          rtr += '</ul>';

          break;
        case 'features':
          // eslint-disable-next-line no-case-declarations
          const features = JSON.parse(this.details.currentValue);

          // eslint-disable-next-line no-case-declarations
          rtr = '<ul class="flex flex-col space-y-1">';

          Object.keys(features).forEach((feature) => {
            rtr += '<li class="flex space-x-2 items-center">';
            rtr += `<span class="font-semibold">${feature}</span>`;
            rtr += '<span>-</span>';
            rtr += `<span class="${features[feature] ? 'text-green-500' : 'text-red-500'}">${features[feature] ? 'Yes' : 'No'}</span>`;
            rtr += '</li>';
          });

          rtr += '</ul>';

          break;
        default:
          return this.details.currentValue;
      }

      return rtr;
    },

    processedRecommendedValue() {
      let rtr;

      switch (this.details.field) {
        case 'opening_times':
          // eslint-disable-next-line no-case-declarations
          const openingTimes = JSON.parse(this.details.recommendedValue);

          // eslint-disable-next-line no-case-declarations
          rtr = '<ul class="flex flex-col space-y-1">';

          openingTimes.forEach((openingTime) => {
            rtr += '<li class="flex space-x-2 items-center">';
            rtr += `<span class="font-semibold">${openingTime.label}</span>`;

            if (openingTime.closed) {
              rtr += '<span>Closed</span>';
            } else {
              if (openingTime.start[0] < 10) {
                openingTime.start[0] = `0${openingTime.start[0]}`;
              }
              if (openingTime.start[1] === 0) {
                openingTime.start[1] = '00';
              }
              if (openingTime.end[0] < 10) {
                openingTime.end[0] = `0${openingTime.end[0]}`;
              }
              if (openingTime.end[1] === 0) {
                openingTime.end[1] = '00';
              }

              rtr += `<span>${openingTime.start.join(':')}</span>`;
              rtr += '<span>-</span>';
              rtr += `<span>${openingTime.end.join(':')}</span>`;
            }

            rtr += '</li>';
          });

          rtr += '</ul>';

          break;
        case 'features':
          // eslint-disable-next-line no-case-declarations
          const features = JSON.parse(this.details.recommendedValue);

          // eslint-disable-next-line no-case-declarations
          rtr = '<ul class="flex flex-col space-y-1">';

          features.forEach((feature) => {
            rtr += '<li class="flex space-x-2 items-center">';
            rtr += `<span class="font-semibold">${feature.label}</span>`;
            rtr += '<span>-</span>';
            rtr += `<span class="${feature.selected ? 'text-green-500' : 'text-red-500'}">${feature.selected ? 'Yes' : 'No'}</span>`;
            rtr += '</li>';
          });

          rtr += '</ul>';

          break;
        default:
          return this.details.recommendedValue;
      }

      return rtr;
    },
  },

  mounted() {
    Architect.request().get(`/external/coeliac-wte-suggested-edits/get/${this.data.id}`).then((response) => {
      this.details = response.data;
      this.loading = false;
      this.expanded = this.details.status === 'New';
    });
  },

  methods: {
    expand() {
      if (this.details.status === 'New') {
        return;
      }

      this.expanded = !this.expanded;
    },

    accept() {
      Architect.request().put(`/external/coeliac-wte-suggested-edits/accept/${this.data.id}`).then(() => {
        this.details.accepted = true;
        this.details.status = 'Accepted';
        this.expanded = false;
      });
    },

    reject() {
      Architect.request().delete(`/external/coeliac-wte-suggested-edits/reject/${this.data.id}`).then(() => {
        this.details.rejected = true;
        this.details.status = 'Rejected';
        this.expanded = false;
      });
    },
  },
};
</script>
