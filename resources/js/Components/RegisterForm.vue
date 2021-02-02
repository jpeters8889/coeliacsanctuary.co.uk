<template>
    <div class="flex justify-center items-center">
        <form
            class="rounded-lg border border-blue p-4 flex flex-col space-y-4 w-full max-w-basket-sidebar bg-grey-lightest"
            @submit.prevent="submitRegistration">
            <div class="mx-auto" style="width: 50px;">
                <coeliac-icon colour="#80CCFC"></coeliac-icon>
            </div>

            <p>
                Register an account on Coeliac Sanctuary today and get access to our member dashboard where you can
                create lists of your favourite recipes and blogs, subscribe to get notified when we add places to eat
                near you, view your order history in our shop, plus much more!
            </p>

            <form-input type="text" required name="name" placeholder="Your Name" :value="fields.name"
                        autocomple="name"/>

            <form-input type="email" required name="email" placeholder="Email Address" :value="fields.email"
                        autocomple="email"/>

            <form-input type="password" required name="password" placeholder="Password" :value="fields.password"
                        autocomplete="password"/>

            <form-input type="password" required name="password_confirmation" placeholder="Confirm your password"
                        :match="fields.password" :value="fields.password_confirmation"
                        autocomplete="password_confirmation"/>

            <form-checkbox required name="terms" input-size="text-base"
                           label="I accept the <a href='/terms' target='_blank'>Terms and Conditions</a>"
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

            <div class="flex justify-end text-xs mt-2 font-semibold">
                <a class="text-blue hover:text-grey" href="/member/forgot-password">Forgotten Password?</a>
            </div>
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
            name: false,
            email: false,
            password: false,
            password_confirmation: false,
            terms: false,
        }
    }),

    mounted() {
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
                    //
                })
                .catch((err) => {
                    coeliac().error('There was an error logging you in...');
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
    },
}
</script>
