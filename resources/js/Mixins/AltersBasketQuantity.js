export default {
    methods: {
        increaseQuantity(product, variant) {
            this.alterQuantity(product, variant);
        },

        decreaseQuantity(product, variant) {
            this.alterQuantity(product, variant, 'decrease');
        },

        alterQuantity(product, variant, action = 'increase') {
            coeliac().request().put('/api/shop/basket', {
                product, variant, action
            }).then((response) => {
                if (response.status === 200) {
                    coeliac().success('Product Updated');
                    this.$root.$emit('product-updated');
                    return;
                }

                if (response.status === 400) {
                    coeliac().error(response.status.error);
                    return;
                }

                coeliac().error('There was an error altering the item');
            }).catch(() => {
                coeliac().error('There was an error altering the item');
            });
        }
    }
}
