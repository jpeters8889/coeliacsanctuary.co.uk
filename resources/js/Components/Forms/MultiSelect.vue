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
      class="flex border rounded"
      :class="borderClass"
    >
      <div class="bg-grey-lightest p-0 flex-1 relative">
        <div
          :class="classes()"
          @click.stop="openOptionWindow()"
        >
          <div class="flex-1">
            <span>{{ selectLabel }}</span>
          </div>
          <div class="border-l border-grey-off px-2 -my-1 flex justify-center items-center">
            <font-awesome-icon :icon="['fas', showOptions ? 'chevron-up' : 'chevron-down']" />
          </div>
        </div>

        <transition
          enter-active-class="duration-400 ease-out"
          enter-class="scale-75 opacity-0"
          enter-to-class="scale-1 opacity-1"
          leave-active-class="duration-200 ease-in"
          leave-class="scale-1 opacity-1"
          leave-to-class="scale-75 opacity-0"
        >
          <div
            v-if="showOptions"
            v-click-outside.stop="closeOptionWindow"
            class="absolute bg-white shadow-lg w-full p-2 border rounded border-grey-dark transition transform"
          >
            <ul class="flex flex-col">
              <li
                v-for="option in options"
                :key="option.value"
                :class="liClasses(option)"
                @click="select(option)"
              >
                <div>
                  <div :class="checkboxClasses(option)">
                    <font-awesome-icon :icon="['fas', 'check']" />
                  </div>
                </div>

                <span>{{ option.label }}</span>
              </li>
              <li
                v-if="allowOther"
                :class="liClasses({value: '_other'})"
                @click="selectOther()"
              >
                <div>
                  <div :class="checkboxClasses({value: '_other'})">
                    <font-awesome-icon :icon="['fas', 'check']" />
                  </div>
                </div>

                <input
                  ref="otherInput"
                  v-model="selectOtherOption"
                  type="text"
                  class="border-0 border-b bg-transparent p-0 py-1 text-sm w-full"
                  :class="optionIsSelected({value: '_other'}) ? 'border-b-grey-off placeholder-grey-dark text-black font-semibold' : 'border-transparent placeholder-grey text-grey hover:placeholder-grey hover:text-grey-darkest cursor-pointer'"
                  :disabled="!optionIsSelected({value: '_other'})"
                  :placeholder="optionIsSelected({value: '_other'}) ? 'Please Specify...' : 'Other'"
                >
              </li>
            </ul>
          </div>
        </transition>
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
import ClickOutside from 'vue-click-outside';
import IsFormField from '@/Mixins/IsFormField';

export default {

  directives: {
    ClickOutside,
  },
  mixins: [IsFormField],

  props: {
    value: {
      required: true,
      type: Array,
    },
    options: {
      required: true,
      type: Array,
    },
    padding: {
      type: String,
      default: 'p-3',
    },
    allowOther: {
      type: Boolean,
      default: false,
    },
  },

  data: () => ({
    showOptions: false,
    selectedOptions: [],
    selectOtherOption: null,
  }),

  computed: {
    selectLabel() {
      if (!this.selectedOptions.length) {
        return 'Please select an option...';
      }

      let rtr = this.options.filter((option) => this.selectedOptions.includes(option.value))
        .map((option) => option.label)
        .join(', ');

      if (this.selectedOptions.includes('_other')) {
        let suffix = '';

        if (this.selectOtherOption) {
          suffix = ` (${this.selectOtherOption})`;
        }

        rtr += `, Other${suffix}`;
      }

      return rtr;
    },
  },

  mounted() {
    if (this.value.length) {
      this.refreshValues();
    }
  },

  methods: {
    refreshValues() {
      this.selectedOptions = this.value;

      const check = this.selectedOptions.filter((option) => option.startsWith('Other'));

      if (check.length) {
        const index = this.selectedOptions.indexOf(check[0]);
        const currentValue = this.selectedOptions[index];

        this.selectedOptions[index] = '_other';
        const value = currentValue.split('(');

        if (value.length >= 2) {
          this.selectOtherOption = value[1].replace(')', '');
        }
      }
    },

    classes() {
      const classes = IsFormField.methods.classes.call(this);

      classes.push(['disabled:text-grey', 'flex', 'cursor-pointer']);

      if (!this.small) {
        classes.push(this.padding);
      }

      return classes;
    },

    select(option) {
      if (!this.optionIsSelected(option)) {
        this.selectedOptions.push(option.value);

        return;
      }

      this.selectedOptions = this.selectedOptions.filter((selectedOption) => selectedOption !== option.value);
    },

    selectOther() {
      if (this.optionIsSelected({ value: '_other' })) {
        this.selectedOptions = this.selectedOptions.filter((option) => option.value !== '_other');
        this.selectOtherOption = null;

        return;
      }

      this.selectedOptions.push('_other');
      this.selectOtherOption = '';

      this.$nextTick(() => {
        this.$refs.otherInput.focus();
      });
    },

    optionIsSelected(option) {
      return this.selectedOptions.includes(option.value);
    },

    liClasses(option) {
      const classes = ['select-none', 'cursor-pointer', 'group', 'border-b', 'flex', 'items-center', 'border-grey-off', 'leading-none', 'p-2', 'transition', 'hover:bg-grey-light', 'last:border-b-0'];

      classes.push(this.optionIsSelected(option) ? 'text-black font-semibold' : 'text-grey hover:text-grey-darkest');

      return classes;
    },

    checkboxClasses(option) {
      const classes = ['border', 'p-1', 'transition', 'rounded', 'mr-3'];

      classes.push(this.optionIsSelected(option) ? 'text-white bg-blue border-blue' : 'border-grey-off bg-grey-lightest text-grey-off-light hover:text-grey-off group-hover:text-grey-off');

      return classes;
    },

    openOptionWindow() {
      this.showOptions = !this.showOptions;

      if (this.showOptions) {
        this.refreshValues();
      }
    },

    closeOptionWindow() {
      this.showOptions = false;

      this.currentValue = this.selectedOptions;

      if (this.currentValue.includes('_other')) {
        const index = this.currentValue.indexOf('_other');
        let suffix = '';

        if (this.selectOtherOption) {
          suffix = ` (${this.selectOtherOption})`;
        }

        this.currentValue[index] = `Other${suffix}`;
      }
    },
  },
};
</script>
