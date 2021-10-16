<template>
  <div class="flex justify-start font-semibold text-lg mt-2">
    <div>
      Quantity:&nbsp;
    </div>
    <div
      v-if="quantity === 0"
      class="italic"
    >
      Sorry, this product is out of stock.
    </div>
    <div
      v-else-if="quantity <= 5"
      class="text-red"
    >
      Only {{ quantity }} available
    </div>
    <div v-else-if="quantity <= 10">
      {{ quantity }} available
    </div>
    <div v-else>
      More than 10 available
    </div>
  </div>
</template>

<script>
export default {
  props: {
    quantity: {
      type: Number,
      required: true,
    },
  },
};
</script>
