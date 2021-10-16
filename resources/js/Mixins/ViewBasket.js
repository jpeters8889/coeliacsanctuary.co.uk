export default {
  methods: {
    viewBasket() {
      this.$root.$emit('show-basket');
    },
  },
};
