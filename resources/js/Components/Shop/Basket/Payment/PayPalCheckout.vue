<template>
  <div class="py-1 mt-4">
    <div id="paypal-button" />
  </div>
</template>

<script>
import { loadScript } from '@/Utilities/ScriptLoader';
import GoogleEvents from '@/Mixins/GoogleEvents';

export default {
  mixins: [GoogleEvents],

  data: () => ({
    paypalResolver: null,
  }),

  mounted() {
    this.$root.$on('initiate-payment', (data) => {
      if (data.provider !== 'paypal') {
        return;
      }

      this.checkoutData = data;
      this.executePayment();
    });

    loadScript('https://www.paypalobjects.com/api/checkout.js').then(() => {
      paypal.Button.render({
        env: window.config.shop.paypal,
        style: { size: 'medium' },
        commit: true,
        payment: (resolve) => {
          this.$root.$emit('prepare-payment');
          this.paypalResolver = resolve;
        },
        onAuthorize: (data) => {
          this.processPayment(data);
        },
        onCancel: () => {
          this.paypalError();
        },
        onError: () => {
          this.paypalError();
        },
      }, '#paypal-button');
    });
  },

  methods: {
    paypalError() {
      this.$root.$emit('hide-page-load');
      coeliac().error('There was an completing your order, you have not been charged, please check all fields and try again...');
    },

    executePayment() {
      this.checkoutData.payment = {
        provider: 'paypal',
      };

      this.googleEvent('event', 'set_checkout_option', {
        event_label: 'paypal',
      });

      coeliac().request().post('/api/shop/order', this.checkoutData)
        .then((response) => {
          if (response.status === 200) {
            this.paypalResolver(response.data.id);
            return;
          }

          this.paypalError();
        })
        .catch(() => {
          this.paypalError();
        });
    },

    processPayment(data) {
      coeliac().request().patch('/api/shop/order', {
        payment: {
          provider: 'paypal',
          id: data.paymentID,
          payer: data.payerID,
        },
      }).then((response) => {
        if (response.status === 200) {
          if (response.data.state === 'approved') {
            this.$root.$emit('complete-order');
            return;
          }
        }

        this.paypalError();
      })
        .catch(() => {
          this.paypalError();
        });
    },
  },
};
</script>
