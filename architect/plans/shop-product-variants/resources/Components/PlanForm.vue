<template>
  <div class="flex flex-col">
    <ul>
      <li
        v-for="(variant, index) in variants"
        :key="index"
        class="flex justify-between p-2 rounded my-2 leading-none"
        :class="index % 2 === 0 ? 'bg-gray-100' : ''"
      >
        <div class="w-2/3 flex flex-col pr-1">
          <strong class="mr-1 mb-1">Title</strong>
          <input
            v-model="variant.title"
            class="form-control form-control-input"
            type="text"
          >
        </div>
        <div class="w-1/6 flex flex-col pr-1">
          <strong class="mr-1 mb-1">Weight</strong>
          <input
            v-model="variant.weight"
            class="form-control form-control-input"
            type="text"
          >
        </div>
        <div class="w-1/6 flex flex-col pr-1">
          <strong class="mr-1 mb-1">Quantity</strong>
          <input
            v-model="variant.quantity"
            class="form-control form-control-input"
            type="text"
          >
        </div>
        <div class="flex flex-col pr-1">
          <strong class="mr-1 mb-2">Live</strong>
          <input
            v-model="variant.live"
            class="form-control form-control-input"
            type="checkbox"
          >
        </div>
      </li>
    </ul>
    <div class="w-full my-2 bg-blue-500" />
    <ul>
      <template v-if="variantsToAdd.length > 0">
        <li
          v-for="(variant, index) in variantsToAdd"
          :key="index"
          class="flex justify-between p-2 rounded my-2 leading-none"
          :class="index % 2 === 0 ? 'bg-gray-100' : ''"
        >
          <div class="w-2/3 flex flex-col pr-1">
            <strong class="mr-1 mb-1">Title</strong>
            <input
              v-model="variant.title"
              class="form-control form-control-input"
              type="text"
            >
          </div>
          <div class="w-1/6 flex flex-col pr-1">
            <strong class="mr-1 mb-1">Weight</strong>
            <input
              v-model="variant.weight"
              class="form-control form-control-input"
              type="text"
            >
          </div>
          <div class="w-1/6 flex flex-col pr-1">
            <strong class="mr-1 mb-1">Quantity</strong>
            <input
              v-model="variant.quantity"
              class="form-control form-control-input"
              type="text"
            >
          </div>
          <div class="flex flex-col pr-1">
            <strong class="mr-1 mb-2">Live</strong>
            <input
              v-model="variant.live"
              class="form-control form-control-input"
              type="checkbox"
            >
          </div>
        </li>
      </template>
      <li>
        <div>
          <a
            class="button button-primary py-1 px-4 rounded cursor-pointer"
            @click="addVariant()"
          >
            Add Variant
          </a>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import { IsAFormField } from 'architect-js-helpers';

export default {
  mixins: [IsAFormField],

  data: () => ({
    variants: [],
    variantsToAdd: [],
  }),

  mounted() {
    if (this.$route.params.id) {
      window.Architect.request().get(`external/coeliac-shop-product-variants/variants/${this.$route.params.id}`)
        .then((response) => {
          this.variants = response.data;
        });
    } else {
      this.addVariant();
    }
  },

  methods: {
    addVariant() {
      this.variantsToAdd.push({
        title: '',
        weight: '',
        quantity: '',
        live: false,
      });
    },

    updateVariant(index, field, $event) {
      this.variants[index][field] = $event.target.value;
    },

    setVariant(index, field, $event) {
      this.variantsToAdd[index][field] = $event.target.value;
    },

    getFormData() {
      return {
        name: this.name,
        value: JSON.stringify({
          update: this.variants,
          add: this.variantsToAdd,
        }),
      };
    },
  },
};
</script>
