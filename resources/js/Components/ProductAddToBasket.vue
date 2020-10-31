<template>
    <div class="relative w-full bg-blue-light-20 border border-blue p-3 flex flex-col min-h-map-small">
        <loader :show="loading"></loader>
        <template v-if="!loading">
            <div v-if="data.price.old_price" class="text-md text-center">
                was <span class="font-semibold text-red line-through" v-html="formatPrice(data.price.old_price)"></span>
                now
            </div>
            <div class="text-2xl font-semibold mb-4 text-center" v-html="formatPrice(data.price.current_price) + ' each'"></div>
            <div v-if="data.variants.length > 1" class="flex flex-col">
                <span class="font-semibold ml-1">Select Product Option</span>
                <form-select required name="variant" :value="formData.variant.toString()"
                             :options="variantOptions"></form-select>
            </div>
            <product-quantity :quantity="availableQuantity"></product-quantity>
            <form-input required name="quantity" :value="formData.quantity.toString()" type="number" :min="1"></form-input>
            <add-basket-trigger :product-id="productId" :variant-id="parseInt(formData.variant)" :quantity="parseInt(formData.quantity)">
                <button class="w-full p-2 bg-blue-light-80 border-blue text-center rounded mt-4 font-semibold">
                    Add to Basket
                </button>
            </add-basket-trigger>
        </template>
    </div>
</template>

<script>
    import FormatsPrices from "../Mixins/FormatsPrices";
    import Loader from "./Loader";
    import ProductQuantity from "./ProductQuantity";
    import FormInput from "./Forms/FormInput";
    import FormSelect from "./Forms/FormSelect";

    export default {
        mixins: [FormatsPrices],

        components: {
            'loader': Loader,
            'product-quantity': ProductQuantity,
            'form-input': FormInput,
            'form-select': FormSelect,
        },

        props: {
            productId: {
                required: true,
                type: Number,
            }
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

                        this.watchers = {...this.formData};

                        this.loading = false;
                    })
            }
        },

        computed: {
            variantOptions() {
                let rtr = [];

                this.data.variants.forEach((variant) => {
                    rtr.push({
                        value: variant.id,
                        label: variant.title,
                    });
                });

                return rtr;
            }
        },

        watch: {
            formData: {
                deep: true,
                handler: function (value) {
                    if (value.variant !== this.watchers.variant) {
                        const item = this.data.variants.filter((variant) => variant.id === value.variant)[0];

                        this.availableQuantity = item ? item.quantity : this.availableQuantity;
                    }

                    this.watchers = { ... value};
                }
            },
        }
    }
</script>
