<template>
    <div id="header-basket-detail"
        class="mx-2 p-3 border-blue border rounded bg-blue-light bg-opacity-50 my-2 flex flex-col text-center sm:flex-row sm:text-left sm:justify-between">
        <span>You have <strong>{{ items }}</strong> {{ itemText }} in your basket.</span>
        <a class="font-semibold hover:underline cursor-pointer" @click="viewBasket()">
            View Basket
        </a>
    </div>
</template>

<script>
import ViewBasket from "@/Mixins/ViewBasket";

export default {
    mixins: [ViewBasket],

    data: () => ({
        items: 0,
    }),

    mounted() {
        this.getSummary();

        this.$root.$on('basket-updated', () => {
            this.getSummary();
        })
    },

    methods: {
        getSummary() {
            coeliac().request().get('/api/shop/basket').then((response) => {
                if (response.status === 200) {
                    this.items = response.data.quantity;
                }
            })
        },
    },

    computed: {
        itemText() {
            return this.items === 1 ? 'item' : 'items';
        }
    },
}
</script>
