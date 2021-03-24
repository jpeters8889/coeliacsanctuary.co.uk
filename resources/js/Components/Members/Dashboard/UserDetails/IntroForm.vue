<template>
    <form class="bg-blue-gradient-30 p-2 rounded-lg" @submit.prevent="updateDetails">
        <div>
            <p class="text-sm">
                Here you can change your name and email address, scroll down to manage your addresses and your
                password.
            </p>

            <div v-for="input in form" class="py-4 border-b border-blue last:border-0">
                <label class="text-blue-dark font-semibold mb-1" :for="input.field">{{ input.label }}</label>
                <form-input :id="input.field" :type="input.type" :name="input.field" :required="input.required"
                            :value="fields[input.field]" :autocomplete="input.field"/>
                <span class="text-sm font-semibold leading-tight" v-if="input.help">{{ input.help }}</span>
            </div>
        </div>

        <div class="flex justify-end my-2">
            <button
                :disabled="submittingDetails"
                @click.prevent="updateDetails"
                style="min-width: 130px; height: 50px;"
                class="bg-blue rounded leading-none px-6 text-xl cursor-pointer transition-bg hover:bg-blue-light hover:shadow">
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
                help: 'If you change your email address, you will need to verify it.',
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
    }),

    mounted() {
        this.configureMainFormEvents();
    },

    methods: {
        configureMainFormEvents() {
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
        },

        updateDetails() {
            if (!this.validateForm()) {
                return;
            }

            this.submittingDetails = true;

            coeliac().request().post('/api/member/dashboard/details', this.fields)
                .then(() => {
                    coeliac().success('Your details have been updated.');
                })
                .catch(() => {
                    coeliac().error('There was an error updating your details, please try again');
                    this.validateForm();
                })
                .finally(() => {
                    this.submittingDetails = false;
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
    }
}
</script>
