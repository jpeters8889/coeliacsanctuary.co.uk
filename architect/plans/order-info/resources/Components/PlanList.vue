<template>
    <div>
        <button class="rounded px-2 py-1 leading-none bg-blue-200 text-blue-900 slider-bg font-semibold"
                @click="viewInfo()">
            More Info
        </button>

        <portal to="modal" v-if="showModal">
            <modal title="Order Information">
                <div class="w-full flex flex-col justify-center items-center leading-none">
                    <table class="w-full">
                        <tr>
                            <th class="text-left border-b-4 border-gray-200 p-2 bg-blue-900 text-white font-semibold">
                                ID
                            </th>
                            <td class="text-left p-2 border-b-4 border-blue-900">{{ info.id }}</td>
                        </tr>
                        <tr>
                            <th class="text-left border-b-4 border-gray-200 p-2 bg-blue-900 text-white font-semibold">
                                Order ID
                            </th>
                            <td class="text-left p-2 border-b-4 border-blue-900">{{ info.order_key }}</td>
                        </tr>
                        <tr>
                            <th class="text-left border-b-4 border-gray-200 p-2 bg-blue-900 text-white font-semibold">
                                Payment Date
                            </th>
                            <td class="text-left p-2 border-b-4 border-blue-900">
                                {{ formatDate(info.payment.created_at) }}
                            </td>
                        </tr>
                        <tr>
                            <th colspan="2"
                                class="text-center border-b-4 border-gray-200 p-2 bg-blue-900 text-white font-semibold">
                                Items
                            </th>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-left p-2">
                                <table class="w-full">
                                    <tr>
                                        <th class="text-left border-b-2 border-r-2 border-gray-200 p-2 bg-blue-900 text-white font-semibold">
                                            Item
                                        </th>
                                        <th class="text-left border-b-2 border-r-2 border-gray-200 p-2 bg-blue-900 text-white font-semibold">
                                            Quantity
                                        </th>
                                        <th class="text-left border-b-2 border-gray-200 p-2 bg-blue-900 text-white font-semibold">
                                            Price
                                        </th>
                                    </tr>
                                    <tr v-for="item in info.items">
                                        <td class="text-left p-2 border-b-2 border-r-2 border-blue-900">
                                            {{ item.product_title }}
                                        </td>
                                        <td class="text-left p-2 border-b-2 border-r-2 border-blue-900">
                                            {{ item.quantity }}
                                        </td>
                                        <td class="text-left p-2 border-blue-900 border-b-2"
                                            v-html="formatPrice(item.subtotal)">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left p-2 border-b-2 border-r-2 border-blue-900" colspan="2">
                                            Subtotal
                                        </td>
                                        <td class="text-left p-2 border-blue-900 border-b-2"
                                            v-html="formatPrice(info.payment.subtotal)">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left p-2 border-b-2 border-r-2 border-blue-900" colspan="2">
                                            Postage
                                        </td>
                                        <td class="text-left p-2 border-blue-900 border-b-2"
                                            v-html="formatPrice(info.payment.postage)">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left p-2 border-b-2 border-r-2 border-blue-900" colspan="2">
                                            Deduction
                                        </td>
                                        <td class="text-left p-2 border-blue-900 border-b-2"
                                            v-html="'-'+formatPrice(info.payment.discount || 0)">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-left p-2 border-b-2 border-r-2 border-blue-900" colspan="2">
                                            Total
                                        </td>
                                        <td class="text-left p-2 border-blue-900 border-b-2"
                                            v-html="formatPrice(info.payment.total)">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left border-b-4 border-gray-200 p-2 bg-blue-900 text-white font-semibold">
                                Customer Name
                            </th>
                            <td class="text-left p-2 border-b-4 border-blue-900">{{ info.address.name }}</td>
                        </tr>
                        <tr>
                            <th class="text-left border-b-4 border-gray-200 p-2 bg-blue-900 text-white font-semibold">
                                Shipping Address
                            </th>
                            <td class="text-left p-2 border-b-4 border-blue-900">
                                {{ info.address.line_1 }}<br/>
                                <template
                                    v-html="info.address.line_2 !== null ? info.address.line_2 + '<br/>' : ''"></template>
                                <template
                                    v-html="info.address.line_3 !== null ? info.address.line_3 + '<br/>' : ''"></template>
                                {{ info.address.town }}<br/>
                                {{ info.address.postcode }}<br/>
                                {{ info.address.country }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left border-b-4 border-gray-200 p-2 bg-blue-900 text-white font-semibold">
                                Customer Email
                            </th>
                            <td class="text-left p-2 border-b-4 border-blue-900">{{ info.user.email }}</td>
                        </tr>
                        <tr>
                            <th class="text-left border-b-4 border-gray-200 p-2 bg-blue-900 text-white font-semibold">
                                Customer Phone
                            </th>
                            <td class="text-left p-2 border-b-4 border-blue-900">{{ info.user.phone }}</td>
                        </tr>
                        <tr>
                            <th class="text-left p-2 bg-blue-900 text-white font-semibold">
                                Payment Method
                            </th>
                            <td class="text-left p-2">{{ info.payment.type.type }}</td>
                        </tr>
                    </table>
                </div>
            </modal>
        </portal>
    </div>
</template>

<script>
    import FormatsDates from "../../../../../resources/js/Mixins/FormatsDates";
    import FormatsPrices from "../../../../../resources/js/Mixins/FormatsPrices";

    export default {
        mixins: [FormatsDates, FormatsPrices],

        props: ['id'],

        data: () => ({
            showModal: false,
            info: {},
        }),

        mounted() {
            Architect.$on('modal-close', () => {
                this.closeModal();
            });
        },

        methods: {
            viewInfo() {
                window.Architect.request().get('/external/order-info/get/' + this.id)
                    .then((request) => {
                        this.info = request.data;
                        this.showModal = true;
                    });
            },

            closeModal() {
                this.showModal = false;
                this.info = {};
            }
        }
    }
</script>
