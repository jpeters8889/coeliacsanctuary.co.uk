<template>
  <div :id="'accordion-'+name">
    <div @click="toggleAccordion()">
      <slot name="title" />
    </div>

    <div
      v-show="showBody"
      class="overflow-hidden"
    >
      <div :class="showBody ? 'slide-down' : ''">
        <slot name="body" />
      </div>
    </div>
  </div>
</template>

<script>
import GoogleEvents from '@/Mixins/GoogleEvents';

export default {
  mixins: [GoogleEvents],

  props: {
    group: {
      type: String,
      default: '',
    },
    name: {
      type: String,
      required: true,
    },
  },

  data: () => ({
    showBody: false,
  }),

  watch: {
    showBody(value) {
      if (value) {
        this.$scrollTo(`#accordion-${this.name}`, 500, {
          offset: -200,
        });
      }
    },
  },

  methods: {
    toggleAccordion() {
      this.googleEvent('event', 'accordion', {
        event_category: 'toggled',
        event_label: this.name,
      });

      this.showBody = !this.showBody;

      this.$root.$emit('accordion-toggled', {
        group: this.group,
        name: this.name,
        visible: this.showBody,
      });

      this.$root.$emit('accordion-hide', {
        group: this.group,
        name: this.name,
      });

      this.$root.$on('accordion-hide', (event) => {
        if (event.group && event.group === this.group && event.name !== this.name) {
          this.showBody = false;
        }
      });
    },
  },
};
</script>
