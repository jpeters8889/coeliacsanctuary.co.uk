<template>
  <div :class="{'w-full': fullWidth}">
    <span
      v-if="label"
      class="block text-lg text-blue-dark font-semibold"
    >
      {{ label }}
      <span
        v-if="required"
        class="text-red"
      >*</span>
    </span>

    <div
      class="flex overflow-hidden border rounded"
      :class="borderClass"
    >
      <div class="bg-grey-lightest p-0 flex-1">
        <input
          :id="id"
          v-model="currentValue"
          :type="type"
          :name="name"
          :placeholder="placeholder"
          :min="min"
          :max="max"
          :disabled="disabled"
          :autocomplete="autocomplete"
          :class="classes()"
          @focus="onFocus()"
          @blur="validate()"
          @keyup.enter="handleEnter()"
          @keyup.escape="handleEscape()"
        >
      </div>

      <div
        v-if="hasError && showError"
        v-tooltip.left="{content: errorText, classes: ['bg-red', 'border-red', 'text-white'], boundariesElement: 'body'}"
        class="bg-red flex justify-center items-center p-2 text-white"
        :class="small ? 'text-xs' : ''"
      >
        <font-awesome-icon :icon="['fas', 'exclamation-circle']" />
      </div>
    </div>
  </div>
</template>

<script>
import IsFormField from '@/Mixins/IsFormField';

export default {
  mixins: [IsFormField],

  props: {
    fullWidth: {
      type: Boolean,
      default: false,
    },
    onEnter: {
      type: Function,
      default: null,
    },
    onEscape: {
      type: Function,
      default: null,
    },
  },

  methods: {
    validate() {
      this.$root.$emit(`${this.name}-blur`);

      IsFormField.methods.validate.bind(this)();
    },

    onFocus() {
      this.$root.$emit(`${this.name}-focus`);
    },

    classes() {
      const base = ['w-full', 'bg-transparent', 'border-0', 'm-0', 'text-grey-darkest'];

      if (this.disabled) {
        base.push('text-grey-light', 'cursor:not-allowed');
      }

      base.push(this.small ? 'p-1 text-sm' : 'p-3 text-base');

      return base;
    },

    handleEnter() {
      if (!this.onEnter) {
        return;
      }

      this.onEnter();
    },

    handleEscape() {
      if (!this.onEscape) {
        return;
      }

      this.onEscape();
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
