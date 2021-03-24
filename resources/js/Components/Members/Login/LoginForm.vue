<template>
    <div class="flex justify-center items-center">
        <form
            class="rounded-lg border border-blue p-4 flex flex-col space-y-4 w-full max-w-basket-sidebar bg-grey-lightest"
            @submit.prevent="attemptLogin">
            <div class="mx-auto" style="width: 50px;">
                <global-layout-coeliac-icon colour="#80CCFC"></global-layout-coeliac-icon>
            </div>

            <form-input type="email" required name="email" placeholder="Email Address" :value="fields.email" autocomple="email"/>

            <form-input type="password" required name="password" placeholder="Password" :value="fields.password" autocomplete="password"/>

            <button
                class="rounded-lg bg-blue leading-none text-lg font-semibold text-white hover:bg-blue-light transition-bg flex items-center justify-center"
                style="height: 42px;"
                :class="isSubmitting ? 'py-2' : 'py-3'"
                :disabled="isSubmitting"
                @click.prevent="attemptLogin">
                <loader background-position=""
                        v-if="isSubmitting"
                        :show="true"
                        height="25px"
                        width="25px"
                        border-width="3px"
                        faded-border-color="border-white-50"
                        primary-border-color="white">
                </loader>
                <span v-else>Log In</span>
            </button>

            <div v-if="needsToVerify" class="border-red border p-2 rounded-sm bg-red-20 text-red font-semibold">
                You need to verify your email address before you can login,
                <a href="" class="text-black">Resend verification email</a>.
            </div>

            <div class="flex justify-between text-xs mt-2 font-semibold">
                <a class="text-blue hover:text-grey" href="/member/register">Sign up!</a>

                <a class="text-blue hover:text-grey" href="/member/forgot-password">Forgotten Password?</a>
            </div>
        </form>
    </div>
</template>

<script>
const FormInput = () => import('~/Forms/Input' /* webpackChunkName: "prefetch-form-input" */)
const Loader = () => import('~/Global/UI/Loader' /* webpackChunkName: "chunk-loader" */)

export default {
    components: {
        'form-input': FormInput,
        'loader': Loader,
    },

    data: () => ({
        isSubmitting: false,
        needsToVerify: false,

        fields: {
            email: '',
            password: '',
        },

        validity: {
            email: false,
            password: false,
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
    },

    methods: {
        attemptLogin() {
            if (!this.validateForm()) {
                coeliac().error('Please enter a valid name and email address!')
                return;
            }

            this.isSubmitting = true;

            coeliac().request().post('/api/member/login', this.fields)
                .then(() => {
                    window.location = '/member/dashboard';
                })
                .catch((err) => {
                    this.fields.password = '';
                    this.validity.password = false;

                    this.$root.$emit('password-set-value', (''));

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
