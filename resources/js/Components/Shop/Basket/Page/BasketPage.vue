<template>
  <div
    v-if="!loading && data.items.length === 0"
    class="page-box"
  >
    <p>
      Sorry, you've got no items in your basket, why not
      <a
        href="/shop"
        class="font-semibold text-blue-dark hover:text-black transition-all"
      >add some</a>?
    </p>
  </div>

  <div
    v-else
    class="flex flex-col space-y-3"
  >
    <div class="page-box">
      <p class="mb-4">
        Below are the items in your shopping basket, you can alter quantities and delete items if needed.
      </p>

      <div class="flex flex-col mb-4">
        <div
          v-for="item in data.items"
          :key="item.id"
          class="flex py-2 leading-tight"
        >
          <div class="w-1/4 pr-2 sm:w-1/5">
            <img
              :src="item.product.first_image"
              alt=""
            >
          </div>
          <div class="w-3/4 flex flex-col sm:flex-row sm:w-4/5 sm:justify-between">
            <div class="sm:mr-2">
              <h3 class="text-lg font-semibold mb-1">
                {{ item.product.title }}
                <span v-if="item.variant.title !== ''">({{ item.variant.title }})</span>
              </h3>
            </div>
            <div class="flex mb-1 sm:flex-col sm:mr-2">
              <div class="font-semibold mr-1 sm:mr-0 sm:mb-2">
                Price
              </div>
              <div v-html="formatPrice(item.product_price)" />
            </div>
            <div class="flex mb-1 sm:flex-col sm:mr-2">
              <div class="font-semibold mr-1 sm:mr-0 sm:mb-2">
                Quantity
              </div>
              <div>
                <shop-basket-ui-quantity-switcher
                  :quantity="item.quantity"
                  :product-id="item.product.id"
                  :variant-id="item.variant.id"
                />
              </div>
            </div>
            <div class="flex mb-1 sm:flex-col sm:mr-2">
              <div class="font-semibold mr-1 sm:mr-0 sm:mb-2">
                Subtotal
              </div>
              <div v-html="formatPrice(item.subtotal)" />
            </div>
          </div>
        </div>
      </div>

      <button
        v-if="data.discount !== []"
        class="mb-4 -mt-2 py-2 px-4 bg-blue-light rounded-lg text-lg text-semibold w-full"
        @click="showDiscountModal = true"
      >
        Got a discount code?
      </button>
    </div>

    <div class="page-box">
      <basket-page-totals
        :country="data.country"
        :postage="data.postage"
        :subtotal="data.subtotal"
        :total="data.total"
        :dispatch="data.delivery"
        :discount="data.discount"
      />
    </div>

    <basket-checkout-wrapper :country-id="data.country" />

    <portal
      v-if="showDiscountModal"
      to="modal"
    >
      <basket-discount-modal />
    </portal>
  </div>
</template>

<script>
import FormatsPrices from '@/Mixins/FormatsPrices';
import LazyLoadsImages from '@/Mixins/LazyLoadsImages';
import BasketCheckoutWrapper from '~/Shop/Basket/Page/BasketCheckoutWrapper';
import BasketDiscountModal from '~/Shop/Basket/Page/BasketDiscountModal';
import BasketPageTotals from '~/Shop/Basket/Page/BasketPageTotals';
import GoogleEvents from '@/Mixins/GoogleEvents';

export default {

  components: {
    'basket-checkout-wrapper': BasketCheckoutWrapper,
    'basket-discount-modal': BasketDiscountModal,
    'basket-page-totals': BasketPageTotals,
  },

  mixins: [FormatsPrices, LazyLoadsImages, GoogleEvents],

  data: () => ({
    firstLoad: true,
    loading: true,
    showDiscountModal: false,
    data: {
      items: [],
      subtotal: 0,
      postage: 0,
      country: 1,
      delivery: '1 - 2',
      total: 0,
      discount: [],
    },
  }),

  mounted() {
    this.getData();

    this.$root.$on('product-updated', () => {
      this.getData();
    });

    this.$root.$on('basket-updated', () => {
      this.getData();
    });

    this.$root.$on('modal-closed', () => {
      document.querySelector('body').classList.remove('overflow-hidden');
      this.showDiscountModal = false;
    });

    this.$root.$on('basket-discount-code-validated', () => {
      document.querySelector('body').classList.remove('overflow-hidden');
      this.showDiscountModal = false;
      this.getData();
    });
  },

  methods: {
    getData() {
      this.loading = true;

      coeliac().request().get('/api/shop/basket/summary')
        .then((response) => {
          if (response.status === 200) {
            this.data = response.data;
            this.loading = false;

            if (this.firstLoad && this.data.items.length) {
              this.googleEvent('event', 'begin_checkout', {
                items: this.data.items.map((item) => ({
                  id: item.product.id,
                  name: item.product_title,
                  variant: item.variant.title ?? '',
                  quantity: item.quantity,
                  price: item.product_price / 100,
                })),
              });

              this.firstLoad = false;
            }

            if (this.data.items.length === 0) {
              sessionStorage.removeItem('checkout-data');
            }

            this.loadLazyImages();
          }
        });
    },
  },
};
</script>
