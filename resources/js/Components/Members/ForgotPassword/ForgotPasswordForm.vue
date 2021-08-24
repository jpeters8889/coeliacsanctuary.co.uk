<template>
    <div class="page-box p-4 rounded-lg shadow">
        <div class="max-w-lg mx-auto">
            <p class="mb-4 text-lg text-center">
                Forgot your password? Just enter the email associated with your account below and we'll send you a link
                to
                reset it!
            </p>

            <form class="flex flex-col space-y-4 w-full"
                  v-if="!isCompleted"
                  @submit.prevent="submitForgotPassword">

                <form-input type="email" required name="email" placeholder="Email Address" :value="fields.email"
                            autocomple="email"/>

                <button
                    class="rounded-lg bg-blue leading-none text-lg font-semibold text-white hover:bg-blue-light transition-all flex items-center justify-center"
                    style="height: 42px;"
                    :class="isSubmitting ? 'py-2' : 'py-3'"
                    :disabled="isSubmitting"
                    @click.prevent="submitForgotPassword">
                    <loader background-position=""
                            v-if="isSubmitting"
                            :show="true"
                            height="25px"
                            width="25px"
                            border-width="3px"
                            faded-border-color="border-white border-opacity-50"
                            primary-border-color="white">
                    </loader>
                    <span v-else>Submit</span>
                </button>
            </form>
            <template v-else>
                <p class="text-lg font-semibold text-center">
                    Thanks! We've received your request and have sent you a link to reset your email.
                </p>
                <p class="mt-2 text-center">
                    <a href="/">Back Home</a>
                </p>
            </template>
        </div>
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

        isCompleted: false,

        fields: {
            email: '',
        },

        validity: {
            email: false,
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

            this.$root.$on(`${field}-change`, (value) => {
                this.fields[field] = value;
            });
        });
    },

    methods: {
        submitForgotPassword() {
            if (!this.validateForm()) {
                coeliac().error('Please enter a valid email address!')
                return;
            }

            this.isSubmitting = true;

            coeliac().request().post('/api/member/forgot-password', this.fields)
                .then(() => {
                    this.isCompleted = true;
                })
                .catch((err) => {
                    coeliac().error('There was an error processing your forgot password request, please try again!');
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
