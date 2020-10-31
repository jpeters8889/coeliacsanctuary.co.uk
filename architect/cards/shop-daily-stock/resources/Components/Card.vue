<template>
    <div>
        <ul>
            <li v-for="(items, category) in products" class="mb-2">
                <h2 class="text-lg text-blue-900 mb-1">{{ category }}</h2>
                <ul class="text-sm">
                    <li v-for="(quantity, item) in items">
                        <strong>{{ item }}</strong> - {{ quantity }}
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: {
            data: Object | Array,
            labels: Object | Array,
        },

        data: () => ({
            products: {},
        }),

        mounted() {
            Architect.request().get('/external/shop-daily-stock').then((response) => {
                this.products = response.data;
            });
        }
    }
</script>
