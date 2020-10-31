<template>
    <div @click="click()">
        <slot></slot>
    </div>
</template>

<script>
    import GoogleEvents from "../Mixins/GoogleEvents";

    export default {
        mixins: [GoogleEvents],

        props: {
            productId: {
                required: true,
                type: Number,
            },
            variantId: {
                required: true,
                type: Number,
            },
            quantity: {
                type: Number,
                default: 1,
            },
        },

        methods: {
            click() {
                coeliac().request().post('/api/shop/basket', {
                    product_id: this.productId,
                    variant_id: this.variantId,
                    quantity: this.quantity,
                }).then((response) => {
                    if(response.status === 200) {
                        this.googleEvent('event', 'add-to-cart', {
                            items: [
                                {
                                    id: this.productId,
                                    variant: this.variantId,
                                    quantity: this.quantity,
                                }
                            ]
                        });

                        coeliac().success('Product added to basket!');

                        this.$root.$emit('basket-updated');
                        this.$root.$emit('show-basket');

                        return;
                    }

                    coeliac().error('There was an error adding this product to your basket, please try again');
                }).catch(() => {
                    coeliac().error('There was an error adding this product to your basket, please try again');
                })
            }
        }
    }
</script>
