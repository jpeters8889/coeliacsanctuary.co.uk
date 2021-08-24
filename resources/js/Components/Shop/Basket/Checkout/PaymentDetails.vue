<template>
    <div class="flex flex-col space-y-3">
        <h3 class="text-xl font-semibold">Payment Details</h3>

        <p>
            Thanks for letting us know where you went your order shipped, next we need to know how you'd like to pay.
        </p>

        <form-option
            required
            name="provider"
            :value="formData.provider"
            :options="paymentProviders"
        ></form-option>

        <template v-if="formData.provider === 'stripe'">
            <form-select
                required
                label="Billing Address"
                name="shippingAddress"
                :value="formData.shippingAddress"
                :options="billingOptions"
                border-class="border-grey-off"
            ></form-select>

            <template v-if="formData.shippingAddress === '0'">
                <div v-if="savedAddresses.length > 0">
                    <p class="text-lg mb-3 font-semibold">Choose Saved Address</p>

                    <div class="flex flex-col space-y-3">
                        <div v-for="address in savedAddresses"
                             @click="selectSavedAddress(address)"
                             class="p-2 flex flex-col cursor-pointer transition-all bg-blue-light"
                             :class="address.id === formData.billingId ?
                                'bg-opacity-20 border-yellow border-4 text-black' :
                                'border text-black text-opacity-50 bg-opacity-50 border-white border-opacity-80 hover:bg-opacity-80 hover:border-white'"
                        >
                            <span class="font-semibold">{{ address.name }}</span>
                            <span>{{ formatAddress(address) }}</span>
                        </div>
                    </div>
                </div>

                <template v-if="formData.billingId === null">
                    <p v-if="savedAddresses.length > 0" class="text-lg my-3 font-semibold">Or Add New Address</p>

                    <form-input
                        required
                        label="Payee Name"
                        name="billingName"
                        :value="formData.billingName"
                        border-class="border-grey-off"
                    />

                    <form-input
                        required
                        label="Address (Line 1)"
                        name="billingAddress1"
                        :value="formData.billingAddress1"
                        border-class="border-grey-off"
                    />

                    <form-input
                        label="Address (Line 2)"
                        name="billingAddress2"
                        :value="formData.billingAddress2"
                        border-class="border-grey-off"
                    />

                    <form-input
                        label="Address (Line 3)"
                        name="billingAddress3"
                        :value="formData.billingAddress3"
                        border-class="border-grey-off"
                    />

                    <form-input
                        required
                        label="Town/City"
                        name="billingTown"
                        :value="formData.billingTown"
                        border-class="border-grey-off"
                    />

                    <form-input
                        required
                        label="Postcode"
                        name="billingPostcode"
                        :value="formData.billingPostcode"
                        border-class="border-grey-off"
                    />

                    <form-input
                        required
                        label="Country"
                        name="billingCountry"
                        :value="formData.billingCountry"
                        border-class="border-grey-off"
                    />
                </template>
            </template>

            <stripe-checkout></stripe-checkout>
        </template>

        <template v-if="formData.provider === 'paypal'">
            <paypal-checkout></paypal-checkout>
        </template>
    </div>
</template>

<script>
import CheckoutComponent from "@/Mixins/CheckoutComponent";
import StripeCheckout from "~/Shop/Basket/Payment/StripeCheckout";
import PayPalCheckout from "~/Shop/Basket/Payment/PayPalCheckout";
import InteractsWithUser from "@/Mixins/InteractsWithUser";

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
            billingId: null,
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
        if (this.isLoggedIn() && this.userHasVerifiedEmail()) {
            this.getUsersAddresses();

            if (this.defaultData.billingId) {
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

            current[2].data.billingId = this.formData.billingId;

            sessionStorage.setItem('checkout-data', JSON.stringify(current));

            this.$root.$emit('payment-button-disabled', this.isDisabled)
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
                provider: this.formData.provider,
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
                if (key.includes('billing') && key !== 'billingId') {
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
            if (this.formData.billingId) {
                return false;
            }

            return Object.values(this.validity).includes(false);
        },
    },
}
</script>
