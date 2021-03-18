<template>
    <div class="flex flex-col leading-none">
        <div class="py-1 flex relative">
            <form-input class="flex-1" required placeholder="Postcode" name="postcode"
                        :pattern="postcodePattern" pattern-error="Please enter a valid UK Postcode"
                        :value="formData.postcode"></form-input>
            <button class="py-2 px-4 text-sm rounded-lg font-semibold bg-yellow ml-2"
                    v-if="canLookupPostcode()"
                    @click="lookupPostcode()">
                Search
            </button>
            <div v-if="canLookupPostcode() && displayLookup"
                 class="absolute w-full bg-grey-lightest border border-grey shadow max-h-map scrollable"
                 style="top: 100%">
                <ul v-for="result in lookupResults">
                    <li class="p-2 border-b border-grey cursor-pointer hover:bg-grey-off-light transition-bg"
                        @click="selectLookupResult(result)">
                        {{ result.friendly }}
                    </li>
                </ul>
            </div>
        </div>

        <div class="py-1">
            <form-input required placeholder="Address Line 1" name="address1" :value="formData.address1"></form-input>
        </div>

        <div class="py-1">
            <form-input placeholder="Address Line 2 (Optional)" name="address2"
                        :value="formData.address2"></form-input>
        </div>

        <div class="py-1">
            <form-input placeholder="Address Line 3 (Optional)" name="address3"
                        :value="formData.address3"></form-input>
        </div>

        <div class="py-1">
            <form-input required placeholder="Town/City" name="town" :value="formData.town"></form-input>
        </div>

        <div class="py-1 flex justify-between">
            <button class="py-3 px-6 rounded-lg font-semibold bg-yellow" @click="goBack()">
                Back...
            </button>

            <button class="py-3 px-6 rounded-lg font-semibold"
                    :class="isDisabled ? 'bg-yellow-50 cursor-not-allowed' : 'bg-yellow'" :disabled="isDisabled"
                    @click="submitForm('shipping-address')">
                Next...
            </button>
        </div>
    </div>
</template>

<script>
    import CheckoutComponent from "@/Mixins/CheckoutComponent";

    export default {
        mixins: [CheckoutComponent],

        data: () => ({
            displayLookup: false,
            lookupResults: [],

            formData: {
                postcode: '',
                address1: '',
                address2: '',
                address3: '',
                town: '',
            },

            validity: {
                postcode: false,
                address1: false,
                address2: true,
                address3: true,
                town: false,
            }
        }),

        methods: {
            lookupPostcode() {
                if(!this.validity.postcode) {
                    coeliac().error('Please enter a valid UK Postcode or change the delivery country above!');

                    return;
                }

                coeliac().request().post('/api/shop/lookup', {
                    postcode: this.formData.postcode,
                }).then((response) => {
                    if (response.status === 200) {
                        this.lookupResults = response.data.data;
                        this.displayLookup = true;

                        return;
                    }

                    coeliac().error('There was an error looking up this postcode');
                }).catch(() => {
                    coeliac().error('There was an error looking up this postcode');
                });
            },

            selectLookupResult(result) {
                this.formData.address1 = result.address_1;
                this.formData.address2 = result.address_2 || '';
                this.formData.address3 = result.address_3 || '';
                this.formData.town = result.town;
                this.formData.postcode = result.postcode;

                this.displayLookup = false;
                this.lookupResults = [];

                Object.keys(this.validity).forEach((key) => {
                    this.$root.$emit(`${key}-set-value`, (this.formData[key]));
                });
            },

            canLookupPostcode() {
                return this.countryId === 1;
            }
        },

        computed: {
            postcodePattern() {
                if(!this.canLookupPostcode()) {
                    return /.*/;
                }

                return /^[A-Z]{1,2}\d[A-Z\d]? ?\d[A-Z]{2}$/i;
            }
        },

        watch: {
            displayLookup: function (value) {
                if (value) {
                    document.querySelector('body').classList.add('overflow-hidden');
                    return;
                }

                document.querySelector('body').classList.remove('overflow-hidden');
            },
        }
    }
</script>
