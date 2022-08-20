<template>
  <ul>
    <li
      v-for="product in products"
      :key="product.id"
    >
      {{ product.title }} ({{ product.rating }} Stars)
    </li>
  </ul>
</template>

<script>
export default {
  props: {
    id: {
      required: true,
    },
  },

  data: () => ({
    products: [],
  }),

  mounted() {
    window.Architect.request().get(`/external/shop-review-products/getProducts/${this.id}`)
      .then((response) => {
        this.products = response.data;
      });
  },
};
</script>
