<template>
  <div class="flex">
    <div
      class="bg-blue-light border border-white rounded-l-full px-2 text-sm flex items-center cursor-pointer"
      @click="decreaseQuantity(productId, variantId)"
    >
      <font-awesome-icon :icon="['fas', 'minus']" />
    </div>
    <div class="bg-blue-light border border-white px-2 flex items-center">
      {{ quantity }}
    </div>
    <div
      class="bg-blue-light border border-white rounded-r-full px-2 text-sm flex items-center cursor-pointer"
      @click="increaseQuantity(productId, variantId)"
    >
      <font-awesome-icon :icon="['fas', 'plus']" />
    </div>
  </div>
</template>

<script>
import AltersBasketQuantity from '@/Mixins/AltersBasketQuantity';

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
    },
  },
};
</script>
