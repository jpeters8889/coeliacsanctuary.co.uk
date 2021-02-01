<template>
    <div class="flex justify-center items-center">
        <div
            class="rounded-lg border border-blue p-4 flex flex-col space-y-4 w-full max-w-basket-sidebar bg-grey-lightest">
            <div class="mx-auto" style="width: 50px;">
                <coeliac-icon colour="#80CCFC"></coeliac-icon>
            </div>

            <form-input type="email" required name="email" placeholder="Email Address" :value="fields.email"/>

            <form-input type="password" required name="password" placeholder="Password" :value="fields.password"/>

            <button
                class="rounded-lg bg-blue leading-none text-lg font-semibold text-white hover:bg-blue-light transition-bg flex items-center justify-center"
                style="height: 42px;"
                :class="isSubmitting ? 'py-2' : 'py-3'"
                :disabled="isSubmitting"
                @click="attemptLogin">
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

            <div class="flex justify-between text-xs mt-2 font-semibold">
                <a class="text-blue hover:text-grey" href="/member/register">Sign up!</a>

                <a class="text-blue hover:text-grey" href="/member/forgot-password">Forgotten Password?</a>
            </div>
        </div>
    </div>
</template>

<script>
const FormInput = () => import('../Components/Forms/FormInput' /* webpackChunkName: "prefetch-form-input" */)
const Loader = () => import('./Loader' /* webpackChunkName: "chunk-loader" */)

export default {
    components: {
        'form-input': FormInput,
        'loader': Loader,
    },

    data: () => ({
        isSubmitting: false,

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
                .then((response) => {
                    console.log(response);
                })
                .catch((err) => {
                    if(err.response.status === 422) {
                        //
                    }

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
