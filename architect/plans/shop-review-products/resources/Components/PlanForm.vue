<template>
  <div class="flex flex-col space-y-3">
    <div
      v-for="product in products"
      :key="product.id"
      class="bg-blue-100 rounded p-2 shadow flex flex-col space-y-2"
    >
      <div class="flex">
        <div class="w-1/6 font-semibold">
          Product
        </div>
        <div class="w-5/6">
          <select
            v-model="product.product_id"
            class="form-control form-control-input"
          >
            <option disabled>
              Please select...
            </option>
            <option
              v-for="prod in allProducts"
              :key="prod.id"
              :value="prod.id"
            >
              {{ prod.title }}
            </option>
          </select>
        </div>
      </div>

      <div class="flex">
        <div class="w-1/6 font-semibold">
          Rating
        </div>
        <div class="w-5/6">
          <select
            v-model="product.rating"
            class="form-control form-control-input"
          >
            <option disabled>
              Please select...
            </option>
            <option value="1">
              1
            </option>
            <option value="2">
              2
            </option>
            <option value="3">
              3
            </option>
            <option value="4">
              4
            </option>
            <option value="5">
              5
            </option>
          </select>
        </div>
      </div>

      <div class="flex">
        <div class="w-1/6 font-semibold">
          Review
        </div>
        <div class="w-5/6">
          <textarea
            v-model="product.review"
            class="form-control form-control-input w-full"
            rows="5"
          />
        </div>
      </div>
    </div>

    <div class="bg-blue-100 rounded p-2 shadow flex flex-col space-y-2">
      <button
        class="rounded px-2 py-1 leading-none bg-blue-200 text-blue-900 slider-bg font-semibold"
        @click.prevent="addItem"
      >
        Add Item
      </button>
    </div>
  </div>

<!--  <input-->
<!--    v-model="actualValue"-->
<!--    type="text"-->
<!--    class="form-control form-control-input w-full"-->
<!--    :name="name"-->
<!--  >-->
</template>

<script>
import { IsAFormField } from 'architect-js-helpers';

export default {
  mixins: [IsAFormField],

  data: () => ({
    products: [],
    allProducts: [],
  }),

  computed: {
    id() {
      return this.value[0].review_id;
    },
  },

  mounted() {
    window.Architect.request()
      .get('/external/shop-review-products/productList')
      .then((response) => {
        this.allProducts = response.data.map((product) => ({
          id: product.id,
          title: product.title,
        }));
      });

    window.Architect.request()
      .get(`/external/shop-review-products/getProducts/${this.id}`)
      .then((response) => {
        this.products = response.data.map((review) => ({
          id: review.id,
          product_id: review.product_id,
          rating: review.rating,
          review: review.review,
        }));
      });
  },

  methods: {
    addItem() {
      this.products.push({
        id: null,
        product_id: null,
        rating: null,
        review: '',
      });
    },

    getFormData() {
      return {
        name: this.name,
        value: JSON.stringify(this.products),
      };
    },
  },
};
</script>
