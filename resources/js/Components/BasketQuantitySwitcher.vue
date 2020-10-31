<template>
    <div class="flex">
        <div class="bg-yellow border border-black rounded-l-full px-2 text-sm flex items-center cursor-pointer"
             @click="decreaseQuantity(productId, variantId)">
            <font-awesome-icon :icon="['fas', 'minus']"></font-awesome-icon>
        </div>
        <div class="bg-yellow border border-black px-2 flex items-center">
            {{ quantity }}
        </div>
        <div class="bg-yellow border border-black rounded-r-full px-2 text-sm flex items-center cursor-pointer"
             @click="increaseQuantity(productId, variantId)">
            <font-awesome-icon :icon="['fas', 'plus']"></font-awesome-icon>
        </div>
    </div>
</template>

<script>
    import AltersBasketQuantity from "../Mixins/AltersBasketQuantity";

    export default {
        mixins: [AltersBasketQuantity],

        props: {
            quantity: {
              required: true,
                type: Number,
            },
            productId: {
                required: true,
                type: Number,
            },
            variantId: {
                required: true,
                type: Number,
            }
        }
    }
</script>
