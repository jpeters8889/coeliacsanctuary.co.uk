<template>
    <div class="flex flex-col space-y-3">
        <h3 class="text-xl font-semibold">Shipping Address</h3>

        <p v-if="!isLoggedIn()">
            Thanks {{ name }}, next we need to know where to send your order.
        </p>

        <template v-else>
            <p>
                Hi {{ name }}, thanks for buying from our online shop, first we just need to know where to send your order.
            </p>

            <p v-if="savedAddresses.length > 0">
                You can either select one of your saved addresses below by clicking or tapping on it, or enter a new address.
            </p>
        </template>

        <template v-if="savedAddresses.length > 0">
            <div v-for="address in savedAddresses"
                 @click="selectSavedAddress(address)"
                 class="p-2 flex flex-col cursor-pointer transition-all bg-blue-light"
                 :class="address.id === formData.id ?
                        'bg-opacity-20 border-yellow border-4 text-black' :
                        'border text-black text-opacity-50 bg-opacity-50 border-white border-opacity-80 hover:bg-opacity-80 hover:border-white'"
            >
                <span class="font-semibold">{{ address.name }}</span>
                <span>{{ formatAddress(address) }}</span>
            </div>
        </template>

        <!-- Add New Address -->
        <template v-if="formData.id === null">
            <div class="flex relative">
                <form-input
                    class="flex-1"
                    required
                    label="Postcode"
                    name="postcode"
                    :pattern="postcodePattern"
                    pattern-error="Please enter a valid UK Postcode"
                    :disabled="!! formData.id"
                    :value="formData.postcode"
                    border-class="border-grey-off"
                />

                <div class="mt-auto">
                    <button class="py-2 px-4 text-sm rounded-lg font-semibold bg-blue-light ml-2 h-12"
                            v-if="canLookupPostcode()"
                            :disabled="!! formData.id"
                            @click="lookupPostcode()">
                        Search
                    </button>
                </div>

                <div v-if="canLookupPostcode() && displayLookup"
                     class="absolute w-full bg-grey-lightest border border-grey shadow max-h-map scrollable"
                     style="top: 100%">
                    <ul v-for="result in lookupResults">
                        <li class="p-2 border-b border-grey cursor-pointer hover:bg-grey-off-light transition-all"
                            @click="selectLookupResult(result)">
                            {{ result.friendly }}
                        </li>
                    </ul>
                </div>

            </div>

            <form-input
                required
                label="Address (Line 1)"
                name="address1"
                :value="formData.address1"
                :disabled="!! formData.id"
                border-class="border-grey-off"
            />

            <form-input
                label="Address Line 2"
                name="address2"
                :value="formData.address2"
                :disabled="!! formData.id"
                border-class="border-grey-off"
            />

            <form-input
                label="Address Line 3"
                name="address3"
                :value="formData.address3"
                :disabled="!! formData.id"
                border-class="border-grey-off"
            />

            <form-input
                required
                label="Town/City"
                name="town"
                :value="formData.town"
                :disabled="!! formData.id"
                border-class="border-grey-off"
            />
        </template>

        <div class="py-1 flex justify-between">
            <button class="py-3 px-6 rounded-lg font-semibold bg-blue-light" @click="goBack()">
                Back...
            </button>

            <button class="py-3 px-6 rounded-lg font-semibold bg-blue-light"
                    :class="isDisabled ? 'bg-opacity-50 cursor-not-allowed' : ''" :disabled="isDisabled"
                    @click="submitForm('shipping-address')">
                Next...
            </button>
        </div>
    </div>
</template>

<script>
import CheckoutComponent from "@/Mixins/CheckoutComponent";
import InteractsWithUser from "@/Mixins/InteractsWithUser";

export default {
    mixins: [CheckoutComponent, InteractsWithUser],

    data: () => ({
        savedAddresses: [],

        displayLookup: false,
        lookupResults: [],

        formData: {
            id: null,
            postcode: '',
            address1: '',
            address2: '',
            address3: '',
            town: '',
        },

        validity: {
            id: true,
            postcode: false,
            address1: false,
            address2: true,
            address3: true,
            town: false,
        }
    }),

    mounted() {
        if (this.isLoggedIn() && this.userHasVerifiedEmail()) {
            this.getUsersAddresses();

            if (this.defaultData.id) {
                this.$root.$emit('disable-country-change');
                this.formData.id = this.defaultData.id;
            }
        }
    },

    methods: {
        getUsersAddresses() {
            this.savedAddresses = [];

            coeliac().request().get('/api/member/addresses')
                .then((response) => {
                    this.savedAddresses = response.data.filter(address => address.type === 'Shipping');
                })
                .catch(() => {
                    //
                });
        },

        formatAddress(address) {
            return Array.from(['line_1', 'line_2', 'line_3', 'town', 'postcode', 'country'].map(key => address[key]))
                .filter(value => value !== null && value !== '')
                .join(', ');
        },

        validateForm() {
            if (this.formData.id) {
                return true;
            }

            return CheckoutComponent.methods.validateForm.call(this);
        },

        selectSavedAddress(address) {
            if (this.formData.id === address.id) {
                this.$root.$emit('enable-country-change');
                this.formData.id = null;

                this.formData.address1 = '';
                this.formData.address2 = '';
                this.formData.address3 = '';
                this.formData.town = '';
                this.formData.postcode = '';

                this.updateSessionStorage();
                return;
            }

            this.formData.address1 = address.line_1;
            this.formData.address2 = address.line_2;
            this.formData.address3 = address.line_3;
            this.formData.town = address.town;
            this.formData.postcode = address.postcode;

            this.$root.$emit('set-customer-name', (address.name));
            this.$root.$emit('disable-country-change');
            this.formData.id = address.id;
            this.$root.$emit('select-country', (address.country));

            this.updateSessionStorage();
        },

        updateSessionStorage() {
            let current = JSON.parse(sessionStorage.getItem('checkout-data'));

            current[1].data.id = this.formData.id;

            sessionStorage.setItem('checkout-data', JSON.stringify(current));
        },

        lookupPostcode() {
            if (!this.validity.postcode) {
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
        isDisabled() {
            if (this.formData.id) {
                return false;
            }

            return Object.values(this.validity).includes(false);
        },

        postcodePattern() {
            if (!this.canLookupPostcode()) {
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
