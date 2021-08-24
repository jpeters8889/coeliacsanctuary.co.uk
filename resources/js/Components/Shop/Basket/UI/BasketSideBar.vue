<template>
    <transition
        enter-active-class="duration-300 ease-out"
        enter-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="duration-200 ease-in"
        leave-class="opacity-100"
        leave-to-class="opacity-0"
        @enter="$root.$emit('background-entered')"
    >
        <!-- black bg -->
        <div class="transition-all transform fixed inset-0 h-full bg-black bg-opacity-50 w-full z-max overflow-hidden" v-if="showBasket">
            <transition
                enter-active-class="duration-400 ease-out"
                enter-class="translate-x-full"
                enter-to-class="translate-x-0"
                leave-active-class="duration-200 ease-in"
                leave-class="translate-x-0"
                leave-to-class="translate-x-full"
            >
                <!-- sidebar -->
                <div v-if="showBasket && hasBackground"
                     class="transition-all transform w-11/12 h-full right-0 top-0 bg-white p-3 shadow-basket-sidebar fixed z-max max-w-basket-sidebar">
                    <div class="relative flex flex-col h-full">
                        <div class="absolute right-0 top-0 text-xl cursor-pointer" @click="showBasket = false; hasBackground = false;">
                            <font-awesome-icon :icon="['fas', 'times']"></font-awesome-icon>
                        </div>

                        <template v-if="data.items.length > 0">
                            <div class="flex flex-col h-full">
                                <div class="flex-1 scrollable">
                                    <table class="font-semibold">
                                        <template v-for="item in data.items">
                                            <tr>
                                                <td colspan="2" class="py-1">
                                                    {{ item.product.title }} <span
                                                    v-if="item.variant.title !== ''">({{ item.variant.title }})</span>
                                                </td>
                                            </tr>
                                            <tr class="text-xl">
                                                <td>
                                                    <shop-basket-ui-quantity-switcher :quantity="item.quantity"
                                                                                      :product-id="item.product.id"
                                                                                      :variant-id="item.variant.id"></shop-basket-ui-quantity-switcher>
                                                </td>
                                                <td class="text-right" v-html="formatPrice(item.subtotal)"></td>
                                            </tr>
                                        </template>
                                    </table>
                                </div>
                                <div>
                                    <table class="font-semibold">
                                        <tr class="text-xl">
                                            <td>Subtotal</td>
                                            <td class="text-right" v-html="formatPrice(data.subtotal)"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="text-xs font-normal text-center leading-tight">
                                                Postage and Discount codes are calculated at checkout.
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <a href="/shop/basket"
                                                   class="block bg-blue-light hover:bg-opacity-75 rounded-lg p-2 w-full text-center transition-all">
                                                    Checkout
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <p>We couldn't find any items in your basket...</p>
                        </template>
                    </div>
                </div>
            </transition>
        </div>
    </transition>
</template>

<script>
import FormatsPrices from "@/Mixins/FormatsPrices";
import GoogleEvents from "@/Mixins/GoogleEvents";
import ResponsiveOptions from "@/Mixins/ResponsiveOptions";

export default {
    mixins: [FormatsPrices, GoogleEvents, ResponsiveOptions],

    data: () => ({
        showBasket: false,
        hasBackground: false,
        data: {
            items: [],
            subtotal: 0,
        }
    }),

    mounted() {
        this.getData();

        this.$root.$on('background-entered', () => {
            this.hasBackground = true;
        });

        this.$root.$on('show-basket', () => {
            this.showBasket = true;
        });

        this.$root.$on('product-updated', () => {
            this.getData();
        });
    },

    methods: {
        getData() {
            coeliac().request().get('/api/shop/basket/summary').then((response) => {
                this.googleEvent('event', 'checkout-progress', {
                    event_category: 'opened-basket-sidebar',
                });


                if (response.status === 200) {
                    this.$set(this, 'data', response.data);
                    return;
                }

                this.data = {
                    items: [],
                    subtotal: 0,
                }
            }).catch(() => {
                this.data = {
                    items: [],
                    subtotal: 0,
                }
            });
        }
    },

    watch: {
        showBasket: function (value) {
            if (value) {
                document.querySelector('body').classList.add('overflow-hidden');
                this.getData();
                return;
            }

            document.querySelector('body').classList.remove('overflow-hidden');
        }
    }
}
</script>
