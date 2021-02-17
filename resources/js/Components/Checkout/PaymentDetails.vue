<template>
    <div class="flex flex-col leading-none">
        <div class="py-1">
            <form-option required name="provider" label="Payment Method" :value="formData.provider"
                         :options="paymentProviders"></form-option>
        </div>

        <template v-if="formData.provider === 'stripe'">
            <div class="py-1">
                <form-select required label="Billing Address" name="shippingAddress" :value="formData.shippingAddress"
                             :options="billingOptions"></form-select>
            </div>

            <template v-if="formData.shippingAddress === '0'">
                <div v-if="savedAddresses.length > 0">
                    <p class="text-lg mb-3 font-semibold">Choose Saved Address</p>

                    <div class="flex flex-col space-y-3">
                        <div v-for="address in savedAddresses"
                             @click="selectSavedAddress(address)"
                             class="p-2 flex flex-col cursor-pointer transition-bg"
                             :class="address.id === formData.id ?
                        'bg-blue-light-20 border-yellow border-4 text-black' :
                        'border text-black-50 bg-blue-light-50 border-white-80 hover:bg-blue-light-80 hover:border-white'"
                        >
                            <span class="font-semibold">{{ address.name }}</span>
                            <span>{{ formatAddress(address) }}</span>
                        </div>
                    </div>
                </div>

                <div v-if="formData.billingId === null">
                    <p v-if="savedAddresses.length > 0" class="text-lg my-3 font-semibold">Or Add New Address</p>

                    <div class="py-1">
                        <form-input required placeholder="Billing Name"
                                    name="billingName" :value="formData.billingName"></form-input>
                    </div>

                    <div class="py-1">
                        <form-input required placeholder="Billing Address Line 1"
                                    name="billingAddress1" :value="formData.billingAddress1"></form-input>
                    </div>

                    <div class="py-1">
                        <form-input placeholder="Billing Address Line 2 (Optional)"
                                    name="billingAddress2" :value="formData.billingAddress2"></form-input>
                    </div>

                    <div class="py-1">
                        <form-input placeholder="Billing Address Line 3 (Optional)"
                                    name="billingAddress3" :value="formData.billingAddress3"></form-input>
                    </div>

                    <div class="py-1">
                        <form-input required placeholder="Town/City"
                                    name="billingTown" :value="formData.billingTown"></form-input>
                    </div>

                    <div class="py-1">
                        <form-input required placeholder="Billing Postcode"
                                    name="billingPostcode" :value="formData.billingPostcode"></form-input>
                    </div>

                    <div class="py-1">
                        <form-input required placeholder="Billing Country"
                                    name="billingCountry" :value="formData.billingCountry"></form-input>
                    </div>
                </div>
            </template>

            <stripe-checkout></stripe-checkout>
        </template>

        <template v-if="formData.provider === 'paypal'">
            <paypal-checkout></paypal-checkout>
        </template>
    </div>
</template>

<script>
import CheckoutComponent from "../../Mixins/CheckoutComponent";
import StripeCheckout from "../StripeCheckout";
import PayPalCheckout from "../PayPalCheckout";
import InteractsWithUser from "../../Mixins/InteractsWithUser";

export default {
    mixins: [CheckoutComponent, InteractsWithUser],

    components: {
        'stripe-checkout': StripeCheckout,
        'paypal-checkout': PayPalCheckout,
    },

    data: () => ({
        paymentProviders: [
            {value: 'stripe', label: 'by Credit / Debit Card'},
            {value: 'paypal', label: 'by PayPal'},
        ],

        billingOptions: [
            {value: '1', label: 'Same as Shipping Address'},
            {value: '0', label: 'Other'},
        ],

        savedAddresses: [],

        formData: {
            provider: '',
            shippingAddress: '1',
            billingId: '',
            billingName: '',
            billingAddress1: '',
            billingAddress2: '',
            billingAddress3: '',
            billingTown: '',
            billingPostcode: '',
            billingCountry: '',
        },

        validity: {
            provider: false,
            shippingAddress: true,
            billingId: true,
            billingName: true,
            billingAddress1: true,
            billingAddress2: true,
            billingAddress3: true,
            billingTown: true,
            billingPostcode: true,
            billingCountry: true,
            card: false,
        },
    }),

    mounted() {
        if(this.isLoggedIn() && this.userHasVerifiedEmail()) {
            this.getUsersAddresses();

            if (this.defaultData.id) {
                this.formData.billingId = this.defaultData.billingId;
            }
        }

        this.$root.$emit('shippingAddress-set-value', ('1'));

        this.$root.$on('prepare-payment', () => {
            this.initiatePayment();
        });

        this.$root.$on('complete-order', () => {
            this.completeOrder();
        });

        Object.keys(this.validity).forEach((key) => {
            if (key.includes('billing')) {
                this.formData[key] = this.defaultData[key];
                this.$root.$emit(`${key}-set-value`, (this.defaultData[key]));
            }
        });
    },

    methods: {
        getUsersAddresses() {
            this.savedAddresses = [];

            coeliac().request().get('/api/member/addresses')
                .then((response) => {
                    this.savedAddresses = response.data.filter(address => address.type === 'Billing');
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

        selectSavedAddress(address) {
            if (this.formData.billingId === address.id) {
                this.formData.billingId = null;

                this.formData.billingName = '';
                this.formData.billingAddress1 = '';
                this.formData.billingAddress2 = '';
                this.formData.billingAddress3 = '';
                this.formData.billingTown = '';
                this.formData.billingPostcode = '';
                this.formData.billingCountry = '';

                this.updateSessionStorage();
                return;
            }

            this.formData.billingId = address.id;
            this.formData.billingName = address.name;
            this.formData.billingAddress1 = address.line_1;
            this.formData.billingAddress2 = address.line_2;
            this.formData.billingAddress3 = address.line_3;
            this.formData.billingTown = address.town;
            this.formData.billingPostcode = address.postcode;
            this.formData.billingCountry = address.country;

            this.updateSessionStorage();
        },

        validateForm() {
            if (this.formData.billingId) {
                return true;
            }

            return CheckoutComponent.methods.validateForm.call(this);
        },

        updateSessionStorage() {
            let current = JSON.parse(sessionStorage.getItem('checkout-data'));

            current[2].data.id = this.formData.billingId;

            sessionStorage.setItem('checkout-data', JSON.stringify(current));
        },

        initiatePayment() {
            this.$root.$emit('full-page-load');

            if (!this.validateForm()) {
                return;
            }

            this.$root.$emit('initiate-payment', this.bundleData());
        },

        completeOrder() {
            sessionStorage.removeItem('checkout-data');
            sessionStorage.removeItem('checkout-country');
            window.location.href = '/shop/basket/done';
        },

        bundleData() {
            let sections = JSON.parse(sessionStorage.getItem('checkout-data'));

            return {
                user: {
                    name: sections[0].data.name,
                    email: sections[0].data.email,
                    emailConfirmation: sections[0].data.emailConfirmation,
                    phone: sections[0].data.phone,
                },
                shipping: {
                    id: sections[1].data.id,
                    address1: sections[1].data.address1,
                    address2: sections[1].data.address2,
                    address3: sections[1].data.address3,
                    town: sections[1].data.town,
                    postcode: sections[1].data.postcode,
                    country: sessionStorage.getItem('checkout-country'),
                },
                billing: {
                    name: this.formData.billingName,
                    id: this.formData.billingId,
                    address1: this.formData.billingAddress1,
                    address2: this.formData.billingAddress2,
                    address3: this.formData.billingAddress3,
                    town: this.formData.billingTown,
                    postcode: this.formData.billingPostcode,
                    country: this.formData.billingCountry,
                },
            };
        }
    },

    watch: {
        'formData.shippingAddress': function (value) {
            this.$root.$emit('shippingAddress-set-value', (value));

            if (value === '1') {
                Object.keys(this.validity).forEach((key) => {
                    if (key.includes('billing')) {
                        this.formData[key] = this.defaultData[key];
                        this.$root.$emit(`${key}-set-value`, (this.defaultData[key]));
                        this.$root.$emit(`${key}-valid`);
                        this.$root.$emit(`${key}-validate`);
                    }
                });
                return;
            }

            Object.keys(this.validity).forEach((key) => {
                if (key.includes('billing')) {
                    this.formData[key] = '';
                    this.$root.$emit(`${key}-set-value`, (''));

                    if (key !== 'billingAddress2' && key !== 'billingAddress3') {
                        this.$root.$emit(`${key}-error`);
                        this.$root.$emit(`${key}-validate`);
                    }
                }
            });
        }
    },

    computed: {
        isDisabled() {
            if(this.formData.billingId) {
                return false;
            }

            return Object.values(this.validity).includes(false);
        },
    },
}
</script>
