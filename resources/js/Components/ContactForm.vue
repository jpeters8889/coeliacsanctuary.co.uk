<template>
    <div class="js-contact-form">
        <div class="flex mt-2 flex-col">
            <p class="mb-5 flex-1">
                Need to get in touch with the Coeliac Sanctuary team? Complete this form and we'll get back to you as
                soon as we can!
            </p>

            <p class="mb-5 flex-1">
                Before you complete this form why not check our frequently asked questions, your question may have
                already been answered!
            </p>

            <p class="mb-5 flex-1">
                Are you suggesting a location to add to our Eating Out guide? Please use our Place Request form instead.
            </p>

            <div class="mb-5 flex-1">
                <form-input required name="name" :value="formData.name" placeholder="Your name..."></form-input>
            </div>

            <div class="mb-5 flex-1">
                <form-input required name="subject" :value="formData.subject"
                            placeholder="Your Subject..."></form-input>
            </div>

            <div class="mb-5 flex-1">
                <form-input required name="email" type="email" :value="formData.email"
                            placeholder="Your e  mail..."></form-input>
            </div>

            <div class="mb-5 flex-1">
                <form-textarea required name="message" :value="formData.message" :rows="10"
                               placeholder="Your message..."></form-textarea>
            </div>
        </div>

        <button
            class="mt-2 bg-blue-50 border border-blue rounded-lg px-6 py-2 text-xl text-black transition-bg hover:bg-blue-20"
            @click.prevent="submitForm()">
            Send Message
        </button>
    </div>
</template>

<script>
    const FormInput = () => import('./Forms/FormInput' /* webpackChunkName: "chunk-form-input" */)
    const FormTextarea = () => import('./Forms/FormTextarea' /* webpackChunkName: "chunk-form-textarea" */)

    export default {
        components: {
            'form-input': FormInput,
            'form-textarea': FormTextarea,
        },

        data: () => ({
            formData: {
                name: '',
                subject: '',
                email: '',
                message: '',
            },

            validity: {
                name: false,
                subject: false,
                email: false,
                message: false,
            }
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
                    coeliac().request().post('/api/contact', this.formData)
                        .then((response) => {
                            if (response.status === 200) {
                                Object.keys(this.validity).forEach((key) => {
                                    this.formData[key] = '';
                                    this.$root.$emit(`${key}-reset`);
                                });

                                coeliac().success('Thanks, your message has been sent!');
                                return;
                            }

                            coeliac().error('Sorry, there was an error submitting your message, please try again.');
                        }).catch(() => {
                        coeliac().error('Sorry, there was an error submitting your message, please try again.');
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
