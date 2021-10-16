export default {
  methods: {
    formatPrice(price) {
      price = (price / 100).toFixed(2);

      return `&pound;${price}`;
    },
  },
};
