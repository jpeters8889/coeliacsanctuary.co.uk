<template>
    <div>
        <div class="flex">
            <div class="leading-none rounded bg-blue-500 p-2 cursor-pointer text-white font-semibold slider-bg" @click="viewItems()">
                {{ value }}
            </div>
        </div>

        <portal to="modal" v-if="showModal">
            <modal title="Items">
                <div class="w-full flex flex-col justify-center items-center leading-none">
                    <table class="w-full leading-none">
                        <tr class="bg-blue-900 text-white text-semibold text-left">
                            <th class="p-2 border-r border-blue-200">Item</th>
                            <th class="p-2 border-r border-blue-200">Quantity</th>
                            <th class="p-2">Subtotal</th>
                        </tr>
                        <tr v-for="item in items" class="border-b border-blue-300">
                            <td class="p-2 border-r border-blue-200">{{ item.product_title }}</td>
                            <td class="p-2 border-r border-blue-200">{{ item.quantity }}</td>
                            <td class="p-2" v-html="formatPrice(item.subtotal)"></td>
                        </tr>
                    </table>
                </div>
            </modal>
        </portal>
    </div>
</template>

<script>
    import FormatsPrices from "../../../../../resources/js/Mixins/FormatsPrices";

    export default {
        mixins: [FormatsPrices],

        props: ['id', 'value'],

        data: () => ({
            showModal: false,
            items: [],
        }),

        mounted() {
            Architect.$on('modal-close', () => {
                this.showModal = false;
            });
        },

        methods: {
            viewItems() {
                this.showModal = true;

                window.Architect.request().get('/external/coeliac-shop-order-items/items/' + this.id)
                    .then((request) => {
                        this.items = request.data;
                    });
            },

            closeModal() {
                this.items = [];
                this.showModal = false;
            }
        }
    }
</script>
