<template>
  <div>
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

    <div class="flex overflow-hidden border border-grey-off rounded">
      <div class="bg-grey-lightest flex-1">
        <textarea
          v-model="currentValue"
          :name="name"
          :placeholder="placeholder"
          :rows="rows"
          :maxlength="max"
          :class="classes()"
          @blur="validate()"
        />
      </div>

      <div
        v-if="hasError && showError"
        v-tooltip="{content: errorText, classes: ['bg-red', 'border-red', 'text-white']}"
        class="bg-red flex justify-center p-2 text-white pt-3"
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
    rows: {
      type: Number,
      default: 3,
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
