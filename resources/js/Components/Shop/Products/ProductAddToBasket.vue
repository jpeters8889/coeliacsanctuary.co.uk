<template>
  <div v-if="loading">
    <slot />
  </div>

  <div
    v-else
    class="flex flex-col space-y-2"
  >
    <div class="text-lg">
      <strong class="block text-blue-dark font-semibold">Price:</strong>
      <template v-if="data.price.old_price">
        <span>was</span>
        <span
          class="font-semibold text-red line-through"
          v-html="formatPrice(data.price.old_price)"
        />
        <span>now</span>
      </template>
      <span v-html="formatPrice(data.price.current_price)" />
      <span>each</span>
    </div>

    <div
      v-if="data.variants.length > 1"
      class="flex flex-col"
    >
      <form-select
        required
        name="variant"
        :value="formData.variant.toString()"
        :options="variantOptions"
        border-class="border-grey-off"
        label="Product Option"
      />
    </div>

    <div
      v-if="availableQuantity === 0"
      class="italic"
    >
      Sorry, this product is out of stock.
    </div>

    <template v-else>
      <form-input
        required
        name="quantity"
        :value="formData.quantity.toString()"
        type="number"
        :min="1"
        border-class="border-grey-off"
        label="Quantity"
      />

      <p
        v-if="availableQuantity <= 5"
        class="text-red"
      >
        Order soon, only {{ availableQuantity }} available!
      </p>

      <shop-basket-ui-add-product
        :product-id="productId"
        :variant-id="parseInt(formData.variant)"
        :quantity="parseInt(formData.quantity)"
      >
        <button class="w-full p-2 bg-blue-light bg-opacity-80 border-blue text-center rounded mt-4 font-semibold">
          Add to Basket
        </button>
      </shop-basket-ui-add-product>
    </template>
  </div>
</template>

<script>
import FormatsPrices from '@/Mixins/FormatsPrices';

import FormInput from '~/Forms/Input';
import FormSelect from '~/Forms/Select';

export default {

  components: {
    'form-input': FormInput,
    'form-select': FormSelect,
  },
  mixins: [FormatsPrices],

  props: {
    productId: {
      required: true,
      type: Number,
    },
  },

  data: () => ({
    loading: true,
    data: {},
    availableQuantity: 0,

    watchers: {
      variant: null,
      quantity: 1,
    },

    formData: {
      variant: null,
      quantity: 1,
    },

    validity: {
      variant: true,
      quantity: true,
    },
  }),

  computed: {
    variantOptions() {
      const rtr = [];

      this.data.variants.forEach((variant) => {
        rtr.push({
          value: variant.id,
          label: variant.title,
        });
      });

      return rtr;
    },
  },

  watch: {
    formData: {
      deep: true,
      handler(value) {
        if (value.variant !== this.watchers.variant) {
          const item = this.data.variants.filter((variant) => variant.id === value.variant)[0];

          this.availableQuantity = item ? item.quantity : this.availableQuantity;
        }

        this.watchers = { ...value };
      },
    },
  },

  mounted() {
    this.getData();

    this.$root.$on('basket-updated', () => {
      this.getData();
    });

    Object.keys(this.validity).forEach((key) => {
      this.$root.$on(`${key}-error`, () => {
        this.validity[key] = false;
      });

      this.$root.$on(`${key}-valid`, () => {
        this.validity[key] = true;
      });

      this.$root.$on(`${key}-value`, (value) => {
        this.formData[key] = value;
      });

      this.$root.$on(`${key}-change`, (value) => {
        this.formData[key] = value;
      });
    });
  },

  methods: {
    getData() {
      this.loading = true;
      coeliac().request().get(`/api/shop/product/${this.productId}`)
        .then((response) => {
          this.data = response.data.data;
          this.formData.variant = this.data.variants[0].id;
          this.availableQuantity = this.data.variants[0].quantity;

          this.watchers = { ...this.formData };
        })
        .finally(() => {
          this.loading = false;
        });
    },
  },
};
</script>
