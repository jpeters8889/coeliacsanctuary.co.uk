<template>
    <div class="bg-yellow rounded-lg p-2">
        <table class="w-full text-lg">
            <tr>
                <td>Subtotal</td>
                <td class="text-right" v-html="formatPrice(subtotal)"></td>
            </tr>
            <tr v-if="discount && Object.keys(discount).length > 0">
                <td>
                    {{ discount.name }}
                </td>
                <td class="text-right" v-html="'-'+formatPrice(discount.deduction)"></td>
            </tr>
            <tr>
                <td>
                    Postage to
                    <form-select required name="country" :options="countries" :value="country.toString()"
                                 padding="p-1"></form-select>
                </td>
                <td class="text-right" v-html="formatPrice(postage)"></td>
            </tr>
            <tr>
                <td colspan="2">
                    Usually dispatched in {{ dispatch }} days
                </td>
            </tr>
            <tr class="text-xl font-semibold">
                <td>Grand Total</td>
                <td class="text-right" v-html="formatPrice(total)"></td>
            </tr>
        </table>
    </div>
</template>

<script>
    import FormatsPrices from "../Mixins/FormatsPrices";
        const FormSelect = () => import('./Forms/FormSelect' /* webpackChunkName: "chunk-form-select" */)

    export default {
        mixins: [FormatsPrices],

        components: {'form-select': FormSelect},

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
                type: Object | Array,
            }
        },

        data: () => ({
            countries: [],
            selectedCountry: [],
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
                coeliac().request().post('/api/shop/countries', {
                    country: country,
                }).then((response) => {
                    if (response.status === 200) {
                        this.$root.$emit('basket-updated');

                        return;
                    }

                    coeliac().error('Sorry, there was an error selecting the country');
                }).catch(() => {
                    coeliac().error('Sorry, there was an error selecting the country');
                });
            }
        }
    }
</script>
