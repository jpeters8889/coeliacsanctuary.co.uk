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

    <div
      class="flex overflow-hidden border rounded"
      :class="borderClass"
    >
      <div class="bg-grey-lightest p-0 flex-1">
        <select
          v-model="currentValue"
          :name="name"
          class="w-full bg-transparent border-0 m-0 text-grey-darkest"
          :class="padding"
          @blur="validate()"
        >
          <option
            v-if="emptyOption"
            value=""
            disabled
            class="text-grey"
          >
            Please select...
          </option>
          <option
            v-for="option in options"
            :key="option.value"
            :value="option.value"
            v-text="option.label"
          />
        </select>
      </div>

      <div
        v-if="hasError && showError"
        v-tooltip.bottom="{content: errorText, classes: ['bg-red', 'border-red', 'text-white']}"
        class="bg-red flex justify-center items-center p-2 text-white"
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
    options: {
      required: true,
      type: Array,
    },
    padding: {
      type: String,
      default: 'p-3',
    },
    emptyOption: {
      type: Boolean,
      default: false,
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
