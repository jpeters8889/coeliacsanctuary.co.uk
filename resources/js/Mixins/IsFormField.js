import Vue from "vue";
import VTooltip from "v-tooltip";

Vue.use(VTooltip);

export default {
    data: () => ({
        hasError: false,
        showError: false,
        errorText: '',
        currentValue: '',
    }),

    props: {
        type: {
            type: String,
            default: 'text',
        },
        name: {
            type: String,
            required: true,
        },
        value: {
            type: String,
            default: '',
        },
        placeholder: {
            type: String,
            default: '',
        },
        required: {
            type: Boolean,
            default: false,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        min: {
            type: Number,
            default: null,
        },
        max: {
            type: Number,
            default: null,
        },
        pattern: {
            type: RegExp,
            default: null,
        },
        patternError: {
            type: String,
            default: 'Field is Invalid',
        },
        match: {
            type: String,
            default: null,
        },
        autocomplete: {
            type: String,
            default: null,
        }
    },

    mounted() {
        this.currentValue = this.value;

        if (this.required && this.currentValue === '') {
            this.hasError = true;
        }

        this.$root.$on(this.name + '-get-value', () => {
            this.validate();
            this.$root.$emit(this.name + '-value', this.currentValue);
        });

        this.$root.$on(this.name + '-set-value', (value) => {
            this.currentValue = value;
            this.hasError = true;
            this.validate();
        });

        this.$root.$on(this.name + '-reset', () => {
            this.currentValue = '';
            this.showError = false;
        });

        this.$root.$on(this.name + '-validate', () => {
            this.hasError = true;
            this.validate();
        });
    },

    methods: {
        validate() {
            this.showError = true;

            if (this.required && (this.currentValue === '' || this.currentValue === false)) {
                this.errorText = 'Field is required';
                this.pushError();
                return;
            }

            if (this.pattern) {
                if (this.required || this.currentValue !== '') {
                    if (!this.currentValue.match(this.pattern)) {
                        this.errorText = this.patternError;
                        this.pushError();
                        return;
                    }
                }
            }

            if (this.match) {
                if (this.currentValue !== this.match) {
                    this.errorText = 'Field does not match';
                    this.pushError();
                    return;
                }
            }

            switch (this.type) {
                case 'email':
                    if (!this.checkEmail()) {
                        this.errorText = 'Must be a valid email address';
                        this.pushError();
                        return;
                    }
            }

            this.hasError = false;
            this.errorText = '';

            this.$root.$emit(this.name + '-valid');
        },

        checkEmail() {
            const emailRegex = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return emailRegex.test(this.currentValue);
        },

        pushError() {
            this.hasError = true;
            this.$root.$emit(this.name + '-error', this.errorText);
        }
    },

    watch: {
        hasError: function () {
            if (this.hasError) {
                this.$root.$emit(this.name + '-error', this.errorText);
                return;
            }

            this.$root.$emit(this.name + '-valid');
        },

        currentValue: function (value) {
            this.$root.$emit(this.name + '-change', value);
        }
    }
}
