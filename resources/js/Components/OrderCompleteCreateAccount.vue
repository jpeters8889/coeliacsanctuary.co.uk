<template>
    <div class="bg-white-50 rounded-lg mb-2 p-2 shadow lg:w-1/3 mr-2">
        <p class="text-center font-semibold">
            Why not create an account with us to be able to see your order history, create and manage
            personal scrapbooks, get notified about places to eat near you, and much more!
        </p>

        <form class="flex flex-col space-y-2 mt-2" @submit.prevent="submitRegistration">
            <form-input type="password" name="password" autocomplete="password" placeholder="Password" required
                        :min="8" :value="fields.password"/>

            <form-input type="password" name="password_confirmation" autocomplete="password_confirmation"
                        placeholder="Confirm Your Password" required :min="8" :value="fields.password_confirmation"
                        :match="fields.password"/>

            <form-checkbox required name="terms" input-size="text-base"
                           label="I accept the <a href='/terms-of-use' target='_blank' class='font-semibold hover:underline'>Terms and Conditions</a>"
                           :value="fields.terms"/>

            <button
                class="rounded-lg bg-blue leading-none text-lg font-semibold text-white hover:bg-blue-light transition-bg flex items-center justify-center"
                style="height: 42px;"
                :class="isSubmitting ? 'py-2' : 'py-3'"
                :disabled="isSubmitting"
                @click.prevent="submitRegistration">
                <loader background-position=""
                        v-if="isSubmitting"
                        :show="true"
                        height="25px"
                        width="25px"
                        border-width="3px"
                        faded-border-color="border-white-50"
                        primary-border-color="white">
                </loader>
                <span v-else>Join now!</span>
            </button>
        </form>
    </div>
</template>

<script>
const FormInput = () => import('../Components/Forms/FormInput' /* webpackChunkName: "prefetch-form-input" */)
const FormCheckbox = () => import('../Components/Forms/FormCheckbox' /* webpackChunkName: "prefetch-form-checkbox" */)
const Loader = () => import('./Loader' /* webpackChunkName: "chunk-loader" */)

export default {
    components: {
        'form-input': FormInput,
        'form-checkbox': FormCheckbox,
        'loader': Loader,
    },

    props: {
        name: {
            required: true,
            type: String,
        },
        email: {
            required: true,
            type: String,
        },
    },

    data: () => ({
        isSubmitting: false,

        fields: {
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            terms: false,
        },

        validity: {
            password: false,
            password_confirmation: false,
            terms: false,
        },

        errors: {
            password: '',
            password_confirmation: '',
            generic: '',
        }
    }),

    mounted() {
        this.fields.name = this.name;
        this.fields.email = this.email;

        Object.keys(this.fields).forEach((field) => {
            this.$root.$on(`${field}-error`, () => {
                this.validity[field] = false;
            });

            this.$root.$on(`${field}-valid`, () => {
                this.validity[field] = true;
            });

            this.$root.$on(`${field}-value`, (value) => {
                this.fields[field] = value;
            });
        });

        this.$root.$on('terms-change', (value) => {
            this.fields.terms = value;
            this.validity.terms = value;
        })
    },

    methods: {
        submitRegistration() {
            if (!this.validateForm()) {
                coeliac().error('Please complete all fields!')
                return;
            }

            this.isSubmitting = true;

            coeliac().request().post('/api/member/register', this.fields)
                .then(() => {
                    window.location = '/member/dashboard';
                })
                .catch((err) => {
                    if(err.response.status === 422 && err.response.data.errors.email && err.response.data.errors.email[0] === 'Your email is already associated with an account!') {
                        coeliac().error('Your email is already associated with an account, please log in to view your order history!');
                        return;
                    }

                    coeliac().error('Please correct any errors before continuing!');

                    this.fields.password = '';
                    this.validity.password = false;
                    this.fields.password_confirmation = '';
                    this.validity.password_confirmation = false;
                    this.fields.terms = false;
                    this.validity.terms = false;

                    this.$root.$emit('password-set-value', (''));
                    this.$root.$emit('password_confirmation-set-value', (''));
                    this.$root.$emit('terms-set-value', false);
                })
                .finally(() => {
                    this.isSubmitting = false;
                });
        },

        validateForm() {
            Object.keys(this.validity).forEach((key) => {
                this.$root.$emit(`${key}-get-value`)
            });

            let isValid = true;

            Object.keys(this.validity).forEach((key) => {
                if (this.validity[key] === false) {
                    isValid = false;
                }
            });

            return isValid;
        }
    }
}
</script>
