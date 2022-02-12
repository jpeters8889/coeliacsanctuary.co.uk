<template>
  <div>
    <ul class="mb-3">
      <li
        v-for="product in products"
        :key="product.id"
        class="flex justify-between"
      >
        <span>
          {{ product.title }}
        </span>
        <span
          class="text-red-700 cursor-pointer font-semibold hover:underline"
          @click="deleteProduct(product)"
        >
          Delete
        </span>
      </li>
    </ul>

    <div>
      <button
        class="bg-blue-500 rounded px-6 py-3 leading-none text-white font-semibold"
        @click.prevent="loadProductModal()"
      >
        Add Products
      </button>
    </div>

    <portal
      v-if="showAddProductsModal"
      to="modal"
    >
      <modal title="Order Information">
        <div class="w-full flex flex-col justify-center items-center leading-none">
          <ul class="w-full">
            <li
              v-for="product in availableProducts"
              :key="product.id"
              class="flex justify-between border-b border-blue-200 last:border-b-0 hover:bg-blue-100 transition py-2"
            >
              <span>{{ product.title }}</span>
              <span>
                <input
                  type="checkbox"
                  @change="toggleProduct($event, product)"
                >
              </span>
            </li>
          </ul>
        </div>
      </modal>
    </portal>
  </div>
</template>

<script>
import { IsAFormField } from 'architect-js-helpers';

export default {
  mixins: [IsAFormField],

  data: () => ({
    products: [],
    showAddProductsModal: false,
    availableProducts: [],
  }),

  computed: {
    currentProductsIds() {
      if (!this.products) {
        return [];
      }

      return this.products.map((product) => product.id);
    },
  },

  mounted() {
    if (this.value) {
      this.products = this.value;
    }

    Architect.$on('modal-close', () => {
      this.showAddProductsModal = false;
    });
  },

  methods: {
    getFormData() {
      return {
        name: this.name,
        value: JSON.stringify(this.products.map((product) => (product.id))),
      };
    },

    deleteProduct(product) {
      this.products = this.products.filter((prod) => prod.id !== product.id);
    },

    loadProductModal() {
      window.Architect.request().get(`/external/travel-card-products/?exclude=${this.currentProductsIds.join(',')}`)
        .then((request) => {
          this.availableProducts = request.data;
          this.showAddProductsModal = true;
        });
    },

    toggleProduct($event, product) {
      if ($event.target.checked) {
        this.products.push(product);
        return;
      }

      this.deleteProduct(product);
    },
  },
};
</script>
