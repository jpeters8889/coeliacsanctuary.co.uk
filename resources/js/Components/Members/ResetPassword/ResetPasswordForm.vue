<template>
    <div
        class="rounded-lg border border-blue bg-gradient-to-br from-blue/30 to-blue-light/30 p-4">
        <form class="flex flex-col space-y-4 w-full max-w-basket-sidebar"
            v-if="!isCompleted"
              @submit.prevent="submitResetPassword">

            <form-input type="email" required name="email" placeholder="Email Address" :value="fields.email"
                        autocomple="email"/>

            <form-input type="password" required name="password" placeholder="Password" :value="fields.password"
                        autocomplete="password"/>

            <form-input type="password" required name="password_confirmation" placeholder="Confirm your password"
                        :match="fields.password" :value="fields.password_confirmation"
                        autocomplete="password_confirmation"/>

            <button
                class="rounded-lg bg-blue leading-none text-lg font-semibold text-white hover:bg-blue-light transition-all flex items-center justify-center"
                style="height: 42px;"
                :class="isSubmitting ? 'py-2' : 'py-3'"
                :disabled="isSubmitting"
                @click.prevent="submitResetPassword
               ">
                <loader background-position=""
                        v-if="isSubmitting"
                        :show="true"
                        height="25px"
                        width="25px"
                        border-width="3px"
                        faded-border-color="border-white border-opacity-50"
                        primary-border-color="white">
                </loader>
                <span v-else>Reset Password</span>
            </button>
        </form>
        <template v-else>
            <p class="text-lg font-semibold text-center">
                Thanks! We've reset your password, please log in below.
            </p>
            <div class="mt-2 text-center">
                <member-login-form></member-login-form>
            </div>
        </template>
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

    props: {
        token: {
            required: true,
            type: String,
        },
    },

    data: () => ({
        isSubmitting: false,
        needsToVerify: false,

        isCompleted: false,

        fields: {
            token: '',
            email: '',
            password: '',
            password_confirmation: '',
        },

        validity: {
            token: true,
            email: false,
            password: false,
            password_confirmation: false,
        }
    }),

    mounted() {
        this.fields.token = this.token;

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

            this.$root.$on(`${field}-change`, (value) => {
                this.fields[field] = value;
            });
        });
    },

    methods: {
        submitResetPassword() {
            if (!this.validateForm()) {
                coeliac().error('Make sure you\'ve completed the form!')
                return;
            }

            this.isSubmitting = true;

            coeliac().request().post('/api/member/reset-password', this.fields)
                .then(() => {
                    coeliac().success("You've changed your password!")
                    this.isCompleted = true;
                })
                .catch((err) => {
                    coeliac().error('There was an error resetting your password, please try again!');
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
