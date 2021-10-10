const FormInput = () => import('~/Forms/Input' /* webpackChunkName: "chunk-form-input" */);
const FormOption = () => import('~/Forms/Option' /* webpackChunkName: "chunk-form-option" */);
const FormSelect = () => import('~/Forms/Select' /* webpackChunkName: "chunk-form-select" */);

export default {
  components: {
    'form-input': FormInput,
    'form-option': FormOption,
    'form-select': FormSelect,
  },

  props: {
    name: {
      type: String,
    },
    defaultData: {
      type: Object,
      required: true,
    },
    countryId: {
      type: Number,
      required: true,
    },
  },

  mounted() {
    Object.keys(this.validity).forEach((key) => {
      this.$root.$on(`${key}-error`, () => {
        this.validity[key] = false;
      });

      this.$root.$on(`${key}-valid`, () => {
        this.validity[key] = true;
      });

      this.$root.$on(`${key}-value`, (value) => {
        this.formData[key] = value;
      });

      this.$root.$on(`${key}-change`, (value) => {
        this.formData[key] = value;
      });

      if (this.defaultData[key] !== '') {
        this.$root.$emit(`${key}-set-value`, (this.defaultData[key]));
      }
    });

    const filterLength = Object.values(this.defaultData)
      .filter((value) => value === '')
      .length;

    if (!Object.values(this.defaultData).includes('') && filterLength !== Object.values(this.defaultData).length) {
      this.validateForm();
    }
  },

  methods: {
    submitForm(id) {
      if (this.validateForm()) {
        this.$root.$emit('checkout-continue', {
          id,
          data: this.formData,
        });
      }
    },

    goBack() {
      this.$root.$emit('checkout-back');
    },

    validateForm() {
      Object.keys(this.validity).forEach((key) => {
        this.validity[key] = true;
        this.$root.$emit(`${key}-validate`);
      });

      let isValid = true;

      Object.keys(this.validity).forEach((key) => {
        if (this.validity[key] === false) {
          isValid = false;
        }
      });

      return isValid;
    },
  },

  computed: {
    isDisabled() {
      return Object.values(this.validity).includes(false);
    },
  },

  watch: {
    validity: {
      deep: true,
      handler() {
        this.$root.$emit('payment-button-disabled', this.isDisabled);
      },
    },
  },
};
