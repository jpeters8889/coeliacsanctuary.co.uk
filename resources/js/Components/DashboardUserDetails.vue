<template>
    <div class="flex flex-col">
        <div v-for="input in form" class="py-4 border-b border-blue last:border-0">
            <label class="text-blue-dark font-semibold mb-1" :for="input.field">{{ input.label }}</label>
            <form-input :id="input.field" :type="input.type" :name="input.field" :required="input.required" :value="fields[input.field]" />
            <span class="text-sm font-semibold" v-if="input.help">{{ input.help }}</span>
        </div>
    </div>
</template>

<script>
const FormInput = () => import('./Forms/FormInput' /* webpackChunkName: "chunk-form-input" */)

export default {
    components: {
        'form-input': FormInput,
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

    methods: {
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
