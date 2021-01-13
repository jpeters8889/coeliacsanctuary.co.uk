<template>
    <div class="relative w-full min-h-map">
        <loader :show="loading"></loader>
        <div v-if="!loading && data.items.length === 0">
            <p>Sorry, you've got no items in your basket, why not take a look at some of these products instead?</p>
        </div>
        <div class="flex flex-col" v-if="!loading && data.items.length > 0">
            <div class="bg-blue-gradient shadow rounded-lg p-2 mx-auto max-w-11/12">
                <p class="mb-4">Below are the items in your shopping basket, you can alter quantities and delete items
                    if needed.</p>
                <div class="flex flex-col mb-4">
                    <div class="flex py-2 leading-tight" v-for="item in data.items">
                        <div class="w-1/4 pr-2 sm:w-1/5">
                            <img :data-src="item.product.first_image" :src="lazyLoadSrc" loading="lazy" class="lazy"
                                 alt="">
                        </div>
                        <div class="w-3/4 flex flex-col sm:flex-row sm:w-4/5 sm:justify-between">
                            <div class="sm:mr-2">
                                <h3 class="text-lg font-semibold mb-1">
                                    {{ item.product.title }}
                                    <span v-if="item.variant.title !== ''">({{ item.variant.title }})</span>
                                </h3>
                            </div>
                            <div class="flex mb-1 sm:flex-col sm:mr-2">
                                <div class="font-semibold mr-1 sm:mr-0 sm:mb-2">Price</div>
                                <div v-html="formatPrice(item.product_price)"></div>
                            </div>
                            <div class="flex mb-1 sm:flex-col sm:mr-2">
                                <div class="font-semibold mr-1 sm:mr-0 sm:mb-2">Quantity</div>
                                <div>
                                    <basket-quantity-swticher :quantity="item.quantity" :product-id="item.product.id"
                                                              :variant-id="item.variant.id"></basket-quantity-swticher>
                                </div>
                            </div>
                            <div class="flex mb-1 sm:flex-col sm:mr-2">
                                <div class="font-semibold mr-1 sm:mr-0 sm:mb-2">Subtotal</div>
                                <div v-html="formatPrice(item.subtotal)"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <button class="mb-4 -mt-2 py-2 px-4 bg-yellow rounded-lg text-lg text-semibold w-full"
                        v-if="data.discount !== []" @click="showDiscountModal = true">
                    Got a discount code?
                </button>

                <basket-page-totals :country="data.country" :postage="data.postage" :subtotal="data.subtotal"
                                    :total="data.total" :dispatch="data.delivery"
                                    :discount="data.discount"></basket-page-totals>
            </div>
        </div>
        <div class="flex justify-center mt-4" v-if="!loading && data.items.length > 0">
            <basket-checkout-wrapper :country-id="data.country"></basket-checkout-wrapper>
        </div>

        <portal to="modal" v-if="showDiscountModal">
            <basket-discount-modal></basket-discount-modal>
        </portal>
    </div>
</template>

<script>
import FormatsPrices from "../Mixins/FormatsPrices";
import LazyLoadsImages from "../Mixins/LazyLoadsImages";
import BasketCheckoutWrapper from "./BasketCheckoutWrapper";
import BasketDiscountModal from "./BasketDiscountModal";
import BasketPageTotals from "./BasketPageTotals";
import Loader from "./Loader";

export default {
    mixins: [FormatsPrices, LazyLoadsImages],

    components: {
        'basket-checkout-wrapper': BasketCheckoutWrapper,
        'basket-discount-modal': BasketDiscountModal,
        'basket-page-totals': BasketPageTotals,
        'loader': Loader,
    },

    data: () => ({
        loading: true,
        showDiscountModal: false,
        data: {
            items: [],
            subtotal: 0,
            postage: 0,
            country: 1,
            delivery: '1 - 2',
            total: 0,
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

                        if (this.data.items.length === 0) {
                            sessionStorage.removeItem('checkout-data');
                        }

                        this.loadLazyImages();
                    }
                });
        }
    }
}
</script>
