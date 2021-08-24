<template>
    <div>
        <div class="flex mt-2 flex-col space-y-5">
            <div class="flex-1">
                <form-input
                    required
                    name="name"
                    :value="formData.name"
                    label="Your name"
                />
            </div>

            <div class="flex-1">
                <form-input
                    required
                    name="email"
                    type="email"
                    :value="formData.email"
                    label="Your email address"
                />
            </div>

            <hr class="bg-blue border-blue"/>

            <div class="flex-1">
                <form-input
                    required
                    name="placeName"
                    :value="formData.placeName"
                    label="Place name"
                />
            </div>

            <div class="flex-1">
                <form-textarea
                    required
                    name="placeAddress"
                    :value="formData.placeAddress"
                    :rows="3"
                    label="Place location / address"
                />
            </div>

            <div class="flex-1">
                <form-input
                    name="placeWebsite"
                    :value="formData.placeWebsite"
                    label="Place web address"
                />
            </div>

            <div class="flex-1">
                <form-select
                    name="placeType"
                    label="Venue Type"
                    :value="formData.placeType"
                    :options="venueTypes" empty-option
                />
            </div>

            <div class="flex-1">
                <form-textarea
                    required
                    name="placeDetails"
                    :value="formData.placeDetails"
                    :rows="5"
                    label="Place details"
                />
            </div>
        </div>

        <button
            class="mt-2 bg-blue bg-opacity-50 border border-blue rounded-lg px-6 py-2 text-xl text-black transition-all hover:bg-opacity-20"
            @click.prevent="submitForm()">
            Send Recommendation
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

    props: {
        venueTypes: {
            type: Array,
            required: true,
        }
    },

    data: () => ({
        formData: {
            name: '',
            email: '',
            placeName: '',
            placeAddress: '',
            placeWebsite: '',
            placeType: '',
            placeDetails: '',
        },

        validity: {
            name: false,
            email: false,
            placeName: false,
            placeAddress: false,
            placeWebsite: true,
            placeType: true,
            placeDetails: false,
        },
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
            if (!this.validateForm()) {
                coeliac().error('Please complete all required fields before submitting!');

                return;
            }

            coeliac().request().post('/api/wheretoeat/recommend-a-place', {
                name: this.formData.name,
                email: this.formData.email,
                place_name: this.formData.placeName,
                place_location: this.formData.placeAddress,
                place_web_address: this.formData.placeWebsite,
                place_venue_type_id: this.formData.placeType,
                place_details: this.formData.placeDetails,
            }).then((response) => {
                if (response.status === 200) {
                    Object.keys(this.validity).forEach((key) => {
                        this.formData[key] = '';
                        this.$root.$emit(`${key}-reset`);
                    });

                    coeliac().success('Thank you for your recommendation, we\'ll check it out and add them to our eating out guide!');
                    return;
                }

                coeliac().error('Sorry, there was an error submitting your recommendation, please try again.');
            }).catch(() => {
                coeliac().error('Sorry, there was an error submitting your recommendation, please try again.');
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
