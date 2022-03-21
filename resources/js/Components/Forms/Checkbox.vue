<template>
  <div
    class="flex flex-col group"
    :class="hasError ? 'border border-red rounded -mx-2 px-2 bg-red bg-opacity-20' : ''"
  >
    <div class="flex items-center cursor-pointer">
      <div
        :class="label ? 'p-2 pl-0' : 'p-0'"
        @click="select()"
      >
        <div :class="classes()">
          <font-awesome-icon :icon="['fas', 'check']" />
        </div>
      </div>
      <div
        v-if="label"
        class="flex-1"
        :class="inputSize"
        v-html="label"
      />
    </div>
  </div>
</template>

<script>
import IsFormField from '@/Mixins/IsFormField';

export default {
  mixins: [IsFormField],

  props: {
    value: {
      required: true,
      type: Boolean,
    },
    label: {
      required: false,
      type: String,
      default: undefined,
    },
    inputSize: {
      default: 'text-xl',
      type: String,
    },
    rounded: {
      type: Boolean,
      default: false,
    },
    bold: {
      type: Boolean,
      default: false,
    },
    highlightStyle: {
      type: String,
      default: 'colour',
      validator: (value) => ['colour', 'background'].includes(value),
    },
    highlightColour: {
      type: String,
      default: 'green',
    },
  },

  methods: {
    select() {
      this.currentValue = !this.currentValue;
      this.validate();
    },

    classes() {
      const classes = ['border', 'border-grey-off', 'p-1', 'transition'];

      classes.push(this.inputSize);

      if (!this.value) {
        classes.push('bg-grey-lightest text-grey-off-light hover:text-grey-off group-hover:text-grey-off');
      }

      if (this.value) {
        if (this.highlightStyle === 'colour') {
          classes.push('bg-grey-lightest');

          switch (this.highlightColour) {
            case 'blue-light':
              classes.push('text-blue-light');
              break;
            case 'green':
            default:
              classes.push('text-green');
              break;
          }
        }

        if (this.highlightStyle === 'background') {
          classes.push('text-white');

          switch (this.highlightColour) {
            case 'blue-light':
              classes.push('bg-blue-light');
              break;
            case 'green':
            default:
              classes.push('bg-green');
              break;
          }
        }
      }

      if (this.rounded) {
        classes.push('rounded');
      }

      if (this.bold) {
        classes.push('font-semibold');
      }

      return classes;
    },
  },
};
</script>

<style>
input:focus {
    outline: none;
}

input:-webkit-autofill {
    background: none;
}
</style>
