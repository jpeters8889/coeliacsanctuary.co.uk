<template>
  <div
    class="flex flex-col"
    :class="hasError ? 'border border-red rounded -mx-2 px-2 bg-red bg-opacity-20' : ''"
  >
    <div class="flex items-center cursor-pointer">
      <div
        class="p-2 pl-0"
        @click="select()"
      >
        <div
          class="border border-grey-off bg-grey-lightest p-1"
          :class="inputSize + ' ' + (value ? 'text-green' : 'text-grey-off-light')"
        >
          <font-awesome-icon :icon="['fas', 'check']" />
        </div>
      </div>
      <div
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
      required: true,
      type: String,
    },
    inputSize: {
      default: 'text-xl',
      type: String,
    },
  },

  methods: {
    select() {
      this.currentValue = !this.currentValue;
      this.validate();
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
