<template>
  <div class="block bg-gradient-to-br from-blue/50 to-blue-light/50 rounded p-2 space-y-2 shadow ">
    <div
      class="cursor-pointer z-10"
      @click="toggle()"
    >
      <h3 class="text-lg font-semibold mb-2">
        {{ country }}
      </h3>

      <p>
        We've got <strong>{{ details.count }}</strong> gluten places to eat
        across <strong>{{ details.counties }}</strong>
        county{{ details.counties !== 'one' ? 's' : '' }}
        within {{ country }} listed in our eating out guide.
      </p>
    </div>

    <div class="overflow-hidden">
      <transition
        enter-active-class="duration-500 ease-out"
        enter-class="-translate-y-full opacity-0"
        enter-to-class="translate-y-0 opacity-100"
        leave-active-class="duration-500 ease-in"
        leave-class="translate-y-0 opacity-100"
        leave-to-class="-translate-y-full opacity-0"
      >
        <div
          v-if="show"
          class="bg-white p-2 rounded transform"
        >
          <ul>
            <li
              v-for="county in details.list"
              :key="county.id"
              class="py-2 border-b border-blue-light first:pt-0 last:border-0"
            >
              <a :href="'/wheretoeat/'+county.slug">
                <h4 class="font-semibold text-blue-dark mb-2 text-md">{{ county.name }}</h4>
                <p
                  class="text-sm"
                  v-html="countyDescription(county.name, county.details)"
                />
              </a>
            </li>
          </ul>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    country: {
      required: true,
      type: String,
    },
    details: {
      required: true,
      type: Object,
    },
  },

  data: () => ({
    show: false,
  }),

  methods: {
    toggle() {
      if (this.show) {
        this.show = false;
        return;
      }

      if (this.details.list.length === 1) {
        window.location.href = `/wheretoeat/${this.details.list[0].slug}`;
        return;
      }

      this.show = true;
    },

    countyDescription(county, details) {
      const bits = [];

      if (details.eateries && details.eateries !== '0') {
        bits.push(`<strong>${this.formatNumber(details.eateries)}</strong> gluten free place${details.eateries !== '1' ? 's' : ''} to eat`);
      }

      if (details.attractions && details.attractions !== '0') {
        bits.push(`<strong>${this.formatNumber(details.attractions)}</strong> attraction${details.attractions !== '1' ? 's' : ''} with gluten free options`);
      }

      if (details.hotels && details.hotels !== '0') {
        bits.push(`<strong>${this.formatNumber(details.hotels)}</strong> hotel${details.hotels !== '1' ? 's' : ''} / B&B${details.hotels !== '1' ? 's' : ''} with gluten free options`);
      }

      if (bits.length === 1) {
        return `There is ${bits[0]} listed in ${county} in our eating out guide.`;
      }

      if (bits.length === 2) {
        return `There is ${bits[0]} and ${bits[1]} listed in ${county} in our eating out guide.`;
      }

      return `There is ${bits[0]}, ${bits[1]} and ${bits[2]} listed in ${county} in our eating out guide.`;
    },

    formatNumber(number) {
      switch (number) {
        case '1':
          return 'one';
        case '2':
          return 'two';
        case '3':
          return 'three';
        case '4':
          return 'four';
        case '5':
          return 'five';
        case '6':
          return 'six';
        case '7':
          return 'seven';
        case '8':
          return 'eight';
        case '9':
          return 'nine';
        case '10':
          return 'ten';
        default:
          return Intl.NumberFormat().format(number);
      }
    },
  },
};
</script>
