<template>
  <table class="w-full text-lg">
    <tr class="border-b border-blue-light">
      <td class="py-2 font-semibold">
        Subtotal
      </td>
      <td
        class="text-right"
        v-html="formatPrice(subtotal)"
      />
    </tr>
    <tr
      v-if="discount && Object.keys(discount).length > 0"
      class="border-b border-blue-light"
    >
      <td class="py-2 font-semibold">
        {{ discount.name }}
      </td>
      <td
        class="text-right"
        v-html="'-'+formatPrice(discount.deduction)"
      />
    </tr>
    <tr>
      <td
        v-if="!disabledChange"
        class="pt-2 font-semibold"
      >
        Postage to
        <form-select
          v-if="!disabledChange"
          required
          name="country"
          :options="countries"
          :value="country.toString()"
          border-class="border-grey"
          padding="p-1"
        />
      </td>
      <td
        v-else
        class="py-2 font-semibold"
      >
        Postage
      </td>
      <td
        class="text-right"
        v-html="formatPrice(postage)"
      />
    </tr>
    <tr class="border-b border-blue-light">
      <td
        colspan="2"
        class="pb-2 text-sm"
      >
        Dispatched by Royal Mail First Class Post within in 1 - 2 working days.
      </td>
    </tr>
    <tr class="text-xl font-semibold">
      <td class="py-2">
        Grand Total
      </td>
      <td
        class="text-right"
        v-html="formatPrice(total)"
      />
    </tr>
  </table>
</template>

<script>
import FormatsPrices from '@/Mixins/FormatsPrices';

const FormSelect = () => import('~/Forms/Select' /* webpackChunkName: "chunk-form-select" */);

export default {

  components: { 'form-select': FormSelect },
  mixins: [FormatsPrices],

  props: {
    subtotal: {
      required: true,
      type: Number,
    },
    postage: {
      required: true,
      type: Number,
    },
    total: {
      required: true,
      type: Number,
    },
    country: {
      required: true,
      type: Number,
    },
    dispatch: {
      required: true,
      type: String,
    },
    discount: {
      required: true,
      type: [Object, Array, null],
    },
  },

  data: () => ({
    countries: [],
    selectedCountry: [],
    disabledChange: false,
  }),

  mounted() {
    this.selectedCountry = this.country;

    this.getCountries();

    if (!sessionStorage.getItem('checkout-country')) {
      sessionStorage.setItem('checkout-country', 'United Kingdom');
    }

    this.$root.$on('country-change', (country) => {
      if (country.toString() !== this.selectedCountry.toString()) {
        this.selectedCountry = country;
        this.selectCountry(country);
        sessionStorage.setItem('checkout-country', this.countries.find((thisCountry) => country === thisCountry.value).label);
      }
    });

    this.$root.$on('select-country', (select) => {
      const result = this.countries.find((country) => country.label === select);

      if (result) {
        this.$root.$emit('country-change', (result.value));
      }
    });

    this.$root.$on('disable-country-change', () => {
      this.disabledChange = true;
    });

    this.$root.$on('enable-country-change', () => {
      this.disabledChange = false;
    });
  },

  methods: {
    getCountries() {
      coeliac().request().get('/api/shop/countries')
        .then((response) => {
          if (response.status === 200) {
            this.$set(this, 'countries', response.data);
          }
        });
    },

    selectCountry(country) {
      coeliac().request().post('/api/shop/countries', { country })
        .then((response) => {
          if (response.status === 200) {
            this.$root.$emit('basket-updated');

            return;
          }

          coeliac().error('Sorry, there was an error selecting the country');
        })
        .catch(() => {
          coeliac().error('Sorry, there was an error selecting the country');
        });
    },
  },
};
</script>
