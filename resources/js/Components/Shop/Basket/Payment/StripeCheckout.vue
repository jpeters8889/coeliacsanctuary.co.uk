<template>
  <div>
    <div class="mb-3">
      <span class="block text-lg text-blue-dark font-semibold">
        Card Details
        <span class="text-red">*</span>
      </span>

      <div id="stripe" />
    </div>

    <button
      class="py-3 px-6 rounded-lg font-semibold w-full bg-blue-light"
      :class="isDisabled ? 'bg-opacity-50 cursor-not-allowed' : ''"
      :disabled="isDisabled"
      @click="initiatePayment()"
    >
      Pay Now
    </button>
  </div>
</template>

<script>
import { getAlpha2Code } from 'i18n-iso-countries';
import { loadScript } from '@/Utilities/ScriptLoader';
import GoogleEvents from '@/Mixins/GoogleEvents';

export default {
  mixins: [GoogleEvents],

  data: () => ({
    stripe: null,
    stripeElements: null,
    cardElement: null,

    checkoutData: null,

    isDisabled: true,

    hasStartedPayment: false,
  }),

  mounted() {
    this.$root.$on('payment-button-disabled', (disabled) => {
      this.isDisabled = disabled;
    });

    loadScript('https://js.stripe.com/v3/').then(() => {
      this.stripe = new Stripe(window.config.shop.stripe);
      this.stripeElements = this.stripe.elements();

      this.cardElement = this.stripeElements.create('card', {
        classes: {
          base: 'text-base border border-grey-off rounded bg-grey-lightest w-full p-3 m-0 text-grey-darkest text-grey-light',
        },
        hidePostalCode: true,
      });

      this.cardElement.mount('#stripe');

      this.cardElement.on('change', (element) => {
        this.$root.$emit(element.complete ? 'card-valid' : 'card-error');
      });
    });

    this.$root.$on('initiate-payment', (data) => {
      if (data.provider !== 'stripe') {
        return;
      }

      this.checkoutData = data;
      this.executePayment();
    });
  },

  methods: {
    initiatePayment() {
      this.$root.$emit('prepare-payment');
    },

    executePayment() {
      if (this.hasStartedPayment) {
        this.stripeError();
        return;
      }

      this.hasStartedPayment = true;
      this.isDisabled = true;

      this.googleEvent('event', 'set-checkout-option', {
        event_label: 'stripe',
      });

      this.stripe.createPaymentMethod('card', this.cardElement, {
        billing_details: {
          name: this.checkoutData.user.name,
          address: {
            line1: this.checkoutData.billing.address1,
            line2: this.checkoutData.billing.address2,
            city: this.checkoutData.billing.town,
            postal_code: this.checkoutData.billing.postcode,
            country: getAlpha2Code(sessionStorage.getItem('checkout-country'), 'en'),
          },
        },
      }).then((result) => {
        if (result.error) {
          this.hasStartedPayment = false;
          return this.stripeError();
        }

        this.checkoutData.payment = {
          provider: 'stripe',
          token: result.paymentMethod.id,
        };

        coeliac().request().post('/api/shop/order', this.checkoutData)
          .then((response) => {
            if (response.status === 200) {
              return this.confirmResponse(response);
            }

            this.stripeError();
            this.hasStartedPayment = false;
          })
          .catch(() => {
            this.stripeError();
            this.hasStartedPayment = false;
          });
      });
    },

    confirmResponse(response) {
      if (response.data.success) {
        this.$root.$emit('complete-order');
        return;
      }

      if (response.data.requires_action) {
        this.validatePayment(response.data.client_secret, response.data.payment_id);
      }
    },

    stripeError() {
      this.isDisabled = false;

      this.$root.$emit('hide-page-load');
      coeliac().error('There was an completing your order, you have not been charged, please check all fields and try again...');
    },

    validatePayment(token, id) {
      this.stripe.handleCardAction(token).then((result) => {
        if (result.error) {
          this.hasStartedPayment = false;
          return this.stripeError();
        }

        coeliac().request().patch('/api/shop/order', {
          payment: {
            provider: 'stripe',
            token: id,
          },
        }).then((response) => {
          if (response.status === 200) {
            return this.confirmResponse(response);
          }

          this.stripeError();
          this.hasStartedPayment = false;
        })
          .catch(() => {
            this.stripeError();
            this.hasStartedPayment = false;
          });
      });
    },
  },
};
</script>
