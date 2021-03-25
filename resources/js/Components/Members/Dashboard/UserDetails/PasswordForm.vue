<template>
    <form class="bg-blue-gradient-30 p-2 rounded-lg mt-2" @submit.prevent="updatePassword">
        <h2 class="text-lg text-blue-dark font-semibold">Your Password</h2>

        <p class="text-sm ">
            If you want to change your password please enter your current password below along with your new
            Password.
        </p>

        <div class="py-4 border-b border-blue last:border-0">
            <label class="text-blue-dark font-semibold mb-1" for="current_password">
                Current Password
            </label>
            <form-input id="current_password" type="password" name="current_password" :min="8"
                        autocomplete="current_password"/>
        </div>

        <div class="py-4 border-b border-blue last:border-0">
            <label class="text-blue-dark font-semibold mb-1" for="new_password">
                New Password
            </label>
            <form-input id="new_password" type="password" name="new_password" :min="8" autocomplete="new_password"/>
        </div>

        <div class="py-4">
            <label class="text-blue-dark font-semibold mb-1" for="new_password_confirmation">
                Confirm New Password
            </label>
            <form-input id="new_password_confirmation" type="password" name="new_password_confirmation" :min="8"
                        autocomplete="new_password_confirmation" :match="fields.new"/>
        </div>

        <div class="flex justify-end my-2">
            <button
                :disabled="!fields.current || submittingPassword"
                @click.prevent="updatePassword"
                style="min-width: 215px; height: 50px;"
                :class="fields.current ? 'bg-blue hover:bg-blue-light hover:shadow cursor-pointer' : 'bg-blue-light-50 cursor-not-allowed'"
                class="leading-none px-6 text-xl transition-bg">
                <loader background-position=""
                        v-if="submittingPassword"
                        :show="true"
                        height="25px"
                        width="25px"
                        border-width="3px"
                        faded-border-color="border-black-50"
                        primary-border-color="black">
                </loader>
                <span v-else>Update Password</span>
            </button>
        </div>
    </form>
</template>

<script>
const FormInput = () => import('~/Forms/Input' /* webpackChunkName: "chunk-form-input" */)
const Loader = () => import('~/Global/UI/Loader' /* webpackChunkName: "chunk-loader" */)

export default {
    components: {
        'form-input': FormInput,
        'loader': Loader,
    },

    data: () => ({
        submittingPassword: false,

        fields: {
            current: '',
            new: '',
            new_confirmation: '',
        },

        validity: {
            current: true,
            new: true,
            new_confirmation: true,
        }
    }),

    mounted() {
        this.configurePasswordFormEvents();
    },

    methods: {
        configurePasswordFormEvents() {
            Object.keys(this.fields).forEach((field) => {
                this.$root.$on(`${field}-error`, () => {
                    this.validity[field] = false;
                });

                this.$root.$on(`${field}-valid`, () => {
                    this.validity[field] = true;
                });

                this.$root.$on(`${field}-change`, (value) => {
                    this.fields[field] = value;
                });
            });
        },

        updatePassword() {
            if (!this.validatePassword()) {
                return;
            }

            this.submittingPassword = true;

            coeliac().request().patch('/api/member/dashboard/details', this.fields)
                .then(() => {
                    coeliac().success('Your password has been updated.');
                })
                .catch(() => {
                    coeliac().error('There was an error changing your password, please try again');
                })
                .finally(() => {
                    this.resetPasswordForm();
                    this.submittingPassword = false;
                });
        },

        resetPasswordForm() {
            Object.keys(this.fields).forEach((field) => {
                this.$root.$emit(`${field}-set-value`, (''));
                this.fields[field] = '';
                this.validity[field] = true;
            });
        },

        validatePassword() {
            if (!this.fields.current) {
                return false;
            }

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
