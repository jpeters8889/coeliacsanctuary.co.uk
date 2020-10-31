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

    export default {
        mixins: [CheckoutComponent],

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

            formData: {
                provider: '',
                shippingAddress: '1',
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
                        address1: sections[1].data.address1,
                        address2: sections[1].data.address2,
                        address3: sections[1].data.address3,
                        town: sections[1].data.town,
                        postcode: sections[1].data.postcode,
                        country: sessionStorage.getItem('checkout-country'),
                    },
                    billing: {
                        name: this.formData.billingName,
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
        }
    }
</script>
