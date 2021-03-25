<template>
    <div>
        <div class="flex mt-2 flex-col">
            <div class="mb-5 flex-1">
                <form-input required name="name" :value="formData.name" placeholder="Your name..."></form-input>
            </div>
            <div class="mb-5 flex-1">
                <form-select required name="state" :value="formData.state" :options="stateOptions"></form-select>
            </div>
            <div class="mb-5 flex-1">
                <form-textarea required name="comment" :value="formData.comment" :rows="10"
                               placeholder="Your comment..."></form-textarea>
            </div>
        </div>

        <button
            class="mt-2 bg-blue-50 border border-blue rounded-lg px-6 py-2 text-xl text-black transition-bg hover:bg-blue-20"
            @click.prevent="submitForm()">
            Submit Comment
        </button>
    </div>
</template>

<script>
const FormInput = () => import('~/Forms/Input' /* webpackChunkName: "chunk-form-input" */)
const FormSelect = () => import('~/Forms/Select' /* webpackChunkName: "chunk-form-select" */)
const FormTextarea = () => import('~/Forms/Textarea' /* webpackChunkName: "chunk-form-textarea" */)

export default {
    components: {
        'form-input': FormInput,
        'form-select': FormSelect,
        'form-textarea': FormTextarea,
    },

    data: () => ({
        formData: {
            name: '',
            state: 'add',
            comment: '',
        },

        validity: {
            name: false,
            state: true,
            comment: false,
        },

        stateOptions: [
            {value: 'add', label: 'Add'},
            {value: 'remove', label: 'Remove'},
        ]
    }),

    mounted() {
        Object.keys(this.validity).forEach((key) => {
            this.$root.$on(`${key}-error`, () => {
                this.validity[key] = false;
            });

            this.$root.$on(`${key}-valid`, () => {
                this.validity[key] = true;
            });

            this.$root.$on(`${key}-value`, (value) => {
                this.formData[key] = value;
            });
        });
    },

    methods: {
        submitForm() {
            if (this.validateForm()) {
                coeliac().request().post('/api/wheretoeat/place-request', {
                    name: this.formData.name,
                    state: this.formData.state,
                    comment: this.formData.comment,
                }).then((response) => {
                    if (response.status === 200) {
                        Object.keys(this.validity).forEach((key) => {
                            this.formData[key] = '';
                            this.$root.$emit(`${key}-reset`);
                        });

                        coeliac().success('Thank you for your request, we\'ll check it out and add them to our eating out guide!');
                        return;
                    }

                    coeliac().error('Sorry, there was an error submitting your request, please try again.');
                }).catch(() => {
                    coeliac().error('Sorry, there was an error submitting your request, please try again.');
                });
            }
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
