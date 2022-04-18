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

    <div class="flex items-center max-w-[600px]">
      <div
        class="flex justify-start"
        :class="wrapperClasses"
      >
        <template v-for="(option, index) in options">
          <span
            :key="option.value"
            class="cursor-pointer"
            :class="[isSelected(index) ? selectedClass : baseClass, iconClasses]"
            @mouseover="hoveringOn = index"
            @mouseleave="hoveringOn = null"
            @click.prevent="selectOption(option, index)"
          >
            <font-awesome-icon :icon="!isSelected(index) && unselectedIcon ? unselectedIcon : icon" />
          </span>
        </template>
      </div>

      <template v-if="!hideOptionText">
        <transition
          enter-active-class="duration-300 ease-out"
          enter-class="opacity-0"
          enter-to-class="opacity-100"
          leave-active-class="duration-200 ease-in"
          leave-class="opacity-100"
          leave-to-class="opacity-0"
        >
          <div class="flex h-6 items-center flex-1 min-w-[180px] transition">
            <div class="border border-[0.75rem] border-transparent border-r-yellow" />
            <div class="px-4 bg-yellow h-6 items-center text-center font-semibold w-full">
              {{ displayText }}
            </div>
          </div>
        </transition>
      </template>
    </div>

    <!--      <div-->
    <!--        v-if="hasError && showError"-->
    <!--        v-tooltip.bottom="{content: errorText, classes: ['bg-red', 'border-red', 'text-white']}"-->
    <!--        class="bg-red flex justify-center items-center p-2 text-white"-->
    <!--      >-->
    <!--        <font-awesome-icon :icon="['fas', 'exclamation-circle']" />-->
    <!--      </div>-->
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
    selectedClass: {
      required: false,
      type: String,
      default: 'text-yellow',
    },
    baseClass: {
      required: false,
      type: String,
      default: 'text-grey-off',
    },
    iconClasses: {
      required: false,
      type: [String, Array],
      default: '',
    },
    wrapperClasses: {
      required: false,
      type: [String, Array],
      default: () => ['text-3xl'],
    },
    icon: {
      required: false,
      type: Array,
      default: () => ['fas', 'circle'],
    },
    unselectedIcon: {
      required: false,
      type: Array,
      default: () => ['far', 'circle'],
    },
    hideOptionText: {
      required: false,
      type: Boolean,
      default: false,
    },
    defaultText: {
      required: false,
      type: String,
      default: 'Select an option',
    },
  },

  data: () => ({
    hoveringOn: null,
    selectedOption: '',
    currentIndex: null,
  }),

  computed: {
    displayText() {
      if (this.hoveringOn !== null) {
        return this.options[this.hoveringOn].label || '';
      }

      if (this.selectedOption !== '') {
        return this.selectedOption;
      }

      return this.defaultText;
    },
  },

  methods: {
    selectOption(option, index) {
      this.currentValue = option.value;
      this.currentIndex = index;
      this.selectedOption = option.label || null;
    },

    isSelected(index) {
      if (this.hoveringOn !== null && index <= this.hoveringOn) {
        return true;
      }

      if (this.currentIndex && index <= this.currentIndex) {
        return true;
      }

      return false;
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
