<template>
    <ul v-if="variants !== []" class="flex flex-col">
        <li class="py-1" v-for="(variant, index) in variants" :class="index % 2 !== 0 ? 'rounded bg-blue-100' : ''">
            <div class="flex" v-if="variant.title !== ''">
                <div class="w-full flex justify-between px-1 border-b border-blue">
                    <strong>Title:</strong>
                    <span>{{ variant.title }}</span>
                </div>
            </div>
            <div class="flex">
                <div class="flex flex-col px-1 border-r border-blue">
                    <strong>Live</strong>
                    <span>{{ variant.live }}</span>
                </div>

                <div class="flex flex-col px-1">
                    <strong>Quantity</strong>
                    <span>{{ variant.quantity }}</span>
                </div>
            </div>
        </li>
    </ul>
</template>

<script>
    export default {
        props: ['id'],

        data: () => ({
            variants: [],
        }),

        created() {
            this.variants = [];
        },

        mounted() {
            this.variants = [];
            this.loadData();
        },

        methods: {
            loadData() {
                window.Architect.request().get('/external/coeliac-shop-product-variants/variants/' + this.id)
                    .then((response) => {
                        this.variants = response.data;
                    });
            }
        },

        watch: {
            id: function() {
              this.loadData();
            },
        }
    }
</script>
