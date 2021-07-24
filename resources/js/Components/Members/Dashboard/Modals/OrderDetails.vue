<template>
    <div v-if="loading" class="w-full h-32">
        <loader :show="true"></loader>
    </div>

    <div v-else>
        <table>
            <tr>
                <th>Order Reference</th>
                <td>{{ order.reference }}</td>
            </tr>
            <tr>
                <th>Order Date</th>
                <td>{{ formatDate(order.order_date, 'D MMMM YYYY HH:mm') }}</td>
            </tr>
            <tr>
                <th>Order State</th>
                <td>{{ order.state }}</td>
            </tr>
            <tr v-if="order.shipped_at">
                <th>Order Dispatched On</th>
                <td>{{ formatDate(order.shipped_at) }}</td>
            </tr>
            <tr>
                <th>Shipping Address</th>
                <td v-html="Object.values(order.address).filter(value => value).join('<br/>')"></td>
            </tr>
            <tr>
                <th>Items</th>
                <td>
                    <div class="flex text-sm my-2 border-b border-blue last:border-0" v-for="item in order.items">
                        <div class="hidden xs:block w-1/5 mr-2">
                            <img :src="item.image" alt=""/>
                        </div>
                        <div class="flex flex-col flex-1">
                            <strong>{{ item.product_title }}</strong>
                            <p>
                                <strong>Price</strong>
                                <span v-html="formatPrice(item.product_price)"></span>
                            </p>
                            <p>
                                <strong>Quantity</strong>
                                {{ item.quantity }}
                            </p>
                            <p>
                                <strong>Subtotal</strong>
                                <span v-html="formatPrice(item.subtotal)"></span>
                            </p>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th>Subtotal</th>
                <td v-html="formatPrice(order.payment.subtotal)"></td>
            </tr>
            <tr v-if="order.payment.discount > 0">
                <th>Discount</th>
                <td v-html="formatPrice(order.payment.discount)"></td>
            </tr>
            <tr>
                <th>Postage</th>
                <td v-html="formatPrice(order.payment.postage)"></td>
            </tr>
            <tr>
                <th>Total</th>
                <td v-html="formatPrice(order.payment.total)"></td>
            </tr>
            <tr>
                <th>Payment Type</th>
                <td>{{ order.payment.payment_type }}</td>
            </tr>
        </table>
    </div>
</template>

<script>
import FormatsDates from "@/Mixins/FormatsDates";
import FormatsPrices from "@/Mixins/FormatsPrices";

const Loader = () => import('~/Global/UI/Loader' /* webpackChunkName: "chunk-loader" */)

export default {
    components: {
        loader: Loader,
    },

    mixins: [FormatsDates, FormatsPrices],

    props: {
        id: {
            required: true,
            type: Number,
        }
    },

    data: () => ({
        loading: true,
        order: {},
    }),

    mounted() {
        coeliac().request().get(`/api/member/dashboard/orders/${this.id}`)
            .then((response) => {
                this.order = response.data;
                this.loading = false;
            })
            .catch(() => {
                coeliac().$emit('modal-closed');
                coeliac().error('There was an error finding your order');
            })
    }
}
</script>

<style lang="scss" scoped>
table {
    border: 2px solid #80CCFC;
    border-radius: 5px;

    tr {
        th {
            background-color: #80CCFC;
            color: white;
            padding: 4px;
            text-align: left;
            vertical-align: top;
            border-bottom: 1px solid white;
        }

        td {
            padding: 4px;
            border-bottom: 1px solid #80CCFC;
            vertical-align: top;
        }

        &:last-of-type {
            th, tr {
                border-bottom: 0;
            }
        }
    }
}
</style>
