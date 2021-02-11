<template>
    <div class="flex flex-col">
        <div>
            <div>
                <div v-for="input in form" class="py-4 border-b border-blue last:border-0">
                    <label class="text-blue-dark font-semibold mb-1" :for="input.field">{{ input.label }}</label>
                    <form-input :id="input.field" :type="input.type" :name="input.field" :required="input.required"
                                :value="fields[input.field]"/>
                    <span class="text-sm font-semibold leading-tight" v-if="input.help">{{ input.help }}</span>
                </div>
            </div>

            <div class="flex justify-end my-2">
                <button
                    :disabled="submittingDetails"
                    @click.prevent="updateDetails"
                    style="width: 130px; height: 45px;"
                    class="bg-yellow rounded leading-none py-3 px-6 text-xl cursor-pointer transition-bg hover:bg-yellow-light hover:shadow">
                    <loader background-position=""
                            v-if="submittingDetails"
                            :show="true"
                            height="25px"
                            width="25px"
                            border-width="3px"
                            faded-border-color="border-black-50"
                            primary-border-color="black">
                    </loader>
                    <span v-else>Update!</span>
                </button>
            </div>
        </div>

        <div class="bg-blue-gradient-30 p-2 rounded-lg">
            <h2 class="text-lg text-blue-dark font-semibold">Your Password</h2>

            <p class="text-sm mb-2">
                If you want to change your password please enter your current password below along with your new
                Password.
            </p>

            <p class="text-sm">
                If you don't want to change your password please leave the fields blank.
            </p>

            <div class="py-4 border-b border-blue last:border-0">
                <label class="text-blue-dark font-semibold mb-1" for="current_password">
                    Current Password
                </label>
                <form-input id="current_password" type="password" name="current_password" :min="8"/>
            </div>

            <div class="py-4 border-b border-blue last:border-0">
                <label class="text-blue-dark font-semibold mb-1" for="new_password">
                    New Password
                </label>
                <form-input id="new_password" type="password" name="new_password" :min="8"/>
            </div>

            <div class="py-4">
                <label class="text-blue-dark font-semibold mb-1" for="new_password_confirmation">
                    Confirm New Password
                </label>
                <form-input id="new_password_confirmation" type="password" name="new_password_confirmation" :min="8"
                            :match="password.fields.new"/>
            </div>

            <div class="flex justify-end my-2">
                <button
                    :disabled="!password.fields.current || submittingPassword"
                    @click.prevent="updatePassword"
                    style="width: 215px; height: 45px;"
                    :class="password.fields.current ? 'bg-blue hover:bg-blue-light hover:shadow cursor-pointer' : 'bg-blue-light-50 cursor-not-allowed'"
                    class="leading-none py-3 px-6 text-xl transition-bg">
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
        </div>
    </div>
</template>

<script>
const FormInput = () => import('./Forms/FormInput' /* webpackChunkName: "chunk-form-input" */)
const Loader = () => import('./Loader' /* webpackChunkName: "chunk-loader" */)

export default {
    components: {
        'form-input': FormInput,
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
        phone: {
            required: false,
            type: String,
        }
    },

    data: () => ({
        form: [
            {
                label: 'Your Name',
                field: 'name',
                required: true,
                type: 'text',
            },
            {
                label: 'Email Address',
                help: 'You will need to verify your new email address.',
                field: 'email',
                required: true,
                type: 'email',
            },
            {
                label: 'Phone Number',
                help: 'This is only used if there\'s a problem with any of your orders through our shop.',
                field: 'phone',
                required: false,
                type: 'phone',
            }
        ],

        submittingDetails: false,
        submittingPassword: false,

        fields: {
            name: '',
            email: '',
            phone: '',
        },

        validity: {
            name: false,
            email: false,
            phone: true,
        },

        password: {
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
        }
    }),

    mounted() {
        Object.keys(this.fields).forEach((field) => {
            this.fields[field] = this[field];
            coeliac().$emit(`${field}-set-value`, (this.fields[field]));

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

        Object.keys(this.password.fields).forEach((field) => {
            this.$root.$on(`${field}-error`, () => {
                this.password.validity[field] = false;
            });

            this.$root.$on(`${field}-valid`, () => {
                this.password.validity[field] = true;
            });

            this.$root.$on(`${field}-change`, (value) => {
                this.password.fields[field] = value;
            });
        });
    },

    methods: {
        updateDetails() {
            if (!this.validateForm()) {
                return;
            }

            this.submittingDetails = true;


            coeliac().request().post('/api/member/dashboard/details', this.fields)
                .then((response) => {
                    //
                })
                .catch((err) => {

                })
                .finally(() => {
                    //
                });
        },

        updatePassword() {
            if (!this.validatePassword()) {
                return;
            }

            this.submittingPassword = true;

            coeliac().request().post('/api/member/dashboard/details', this.fields)
                .then((response) => {
                    //
                })
                .catch((err) => {

                })
                .finally(() => {
                    //
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
        },

        validatePassword() {
            if(!this.password.fields.current) {
                return false;
            }

            Object.keys(this.password.validity).forEach((key) => {
                this.$root.$emit(`${key}-get-value`)
            });

            let isValid = true;

            Object.keys(this.password.validity).forEach((key) => {
                if (this.password.validity[key] === false) {
                    isValid = false;
                }
            });

            return isValid;
        }
    }
}
</script>
