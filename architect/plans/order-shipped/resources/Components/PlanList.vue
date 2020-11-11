<template>
    <div>
        <div>
            <div>
                <template v-if="(info.state_id === states.shipped || info.state_id === states.complete)  && info.shipped_at !== null">
                    Yes, {{ formatDate(info.shipped_at) }}.
                </template>

                <template v-if="info.state_id === states.order">
                    No, order not printed yet.
                </template>

                <template v-if="info.state_id === states.processing">
                    <button @click="markAsShipped()"
                            class="rounded px-2 py-1 leading-none bg-green-500 slider-bg font-semibold">
                        Mark as Shipped
                    </button>
                </template>
            </div>

            <div class="mt-4" v-if="info.state_id !== states.shipped && info.shipped_at === null">
                <button v-if="info.state_id !== states.cancelled" @click="showCancelConfirmationModal = true"
                        class="rounded px-2 py-1 leading-none bg-red-500 text-white slider-bg font-semibold">
                    Cancel Order
                </button>

                <template v-else>
                    <span class="text-red-500 font-semibold">ORDER CANCELLED</span>
                </template>
            </div>
        </div>

        <portal to="modal" v-if="showCancelConfirmationModal">
            <modal title="Cancel Order">
                <div class="w-full flex flex-col justify-center items-center leading-none">
                    <p class="text-xl">Are you sure you want to cancel this order?</p>

                    <div class="flex justify-around mt-4">
                        <button class="button button-negative button-default mr-2"
                                @click="cancelOrder()">
                            Yes, cancel this order.
                        </button>

                        <button class="button button-primary button-default"
                                @click="showCancelConfirmationModal = false">
                            No, don't cancel.
                        </button>
                    </div>
                </div>
            </modal>
        </portal>
    </div>
</template>

<script>
    import moment from "moment";

    export default {
        props: ['value', 'id'],

        data: () => ({
            states: {
                basket: 1,
                order: 2,
                processing: 3,
                shipped: 4,
                complete: 5,
                refund: 6,
                cancelled: 7,
                expired: 8,
            },
            info: {
                state: null,
                shipped_at: null,
            },

            showCancelConfirmationModal: false,
        }),

        mounted() {
            this.info = JSON.parse(this.value);

            Architect.$on('modal-close', () => {
                this.showCancelConfirmationModal = false;
            })
        },

        methods: {
            formatDate(date, format = 'Do MMMM YYYY') {
                return moment(date).format(format);
            },

            markAsShipped() {
                window.Architect.request().post('/external/order/ship', {
                    id: this.id,
                }).then((request) => {
                    if (request.status === 200) {
                        window.Architect.success('Order Shipped!');
                        window.Architect.$emit('reload-page');

                        return;
                    }

                    window.Architect.error('An error has occurred');
                });
            },

            cancelOrder() {
                window.Architect.request().post('/external/order/cancel', {
                    id: this.id,
                }).then((request) => {
                    if (request.status === 200) {
                        window.Architect.success('Order Cancelled');
                        window.Architect.$emit('reload-page');

                        return;
                    }

                    window.Architect.error('An error has occurred');
                });
            }
        },

        watch: {
            value: function() {
                this.info = JSON.parse(this.value);
            }
        }
    }
</script>
