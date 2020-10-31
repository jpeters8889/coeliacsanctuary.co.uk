<template>
    <div>
        <ul>
            <li v-for="(price, index) in prices" class="flex justify-between p-2 rounded my-2 leading-none"
                :class="index % 2 === 0 ? 'bg-gray-100' : ''">
                <div class="flex flex-col p-1 flex-1 justify-between">
                    <strong class="leading-none mb-1">Price</strong>
                    <input type="text" class="form-control form-control-input" style="width: 80px;"
                           v-model="price.price"/>
                </div>
                <div class="flex flex-col p-1 flex-1 justify-between">
                    <strong class="leading-none mb-1">Sale Price?</strong>
                    <div style="height: 31px;">
                        <input type="checkbox" class="form-control form-control-input" value="1"
                               v-model="price.sale_price"/>
                    </div>
                </div>
                <div class="flex flex-col p-1 flex-1 justify-between">
                    <strong class="leading-none mb-1">Start Date</strong>
                    <input type="text" class="form-control form-control-input" style="width: 200px;"
                           v-model="price.start_at"/>
                </div>
                <div class="flex flex-col p-1 flex-1 justify-between">
                    <strong class="leading-none mb-1">End Date (Leave blank for never end)</strong>
                    <input type="text" class="form-control form-control-input" style="width: 200px;"
                           v-model="price.end_at"/>
                </div>
                <div class="flex items-center">
                    <a class="button button-negative py-1 px-4 rounded cursor-pointer" @click="deletePrice(index)">Delete</a>
                </div>
            </li>
            <li v-if="pricesToAdd.length > 0" v-for="price in pricesToAdd" class="flex items-center my-1 text-sm">
                <div class="flex flex-col p-1 flex-1 justify-between">
                    <strong class="leading-none mb-1">Price</strong>
                    <input type="text" class="form-control form-control-input" style="width: 80px;"
                           v-model="price.price"/>
                </div>
                <div class="flex flex-col p-1 flex-1 justify-between">
                    <strong class="leading-none mb-1">Sale Price?</strong>
                    <div style="height: 31px;">
                        <input type="checkbox" class="form-control form-control-input" value="1"
                               v-model="price.sale_price"/>
                    </div>
                </div>
                <div class="flex flex-col p-1 flex-1 justify-between">
                    <strong class="leading-none mb-1">Start Date</strong>
                    <input type="text" class="form-control form-control-input" style="width: 200px;"
                           v-model="price.start_at"/>
                </div>
                <div class="flex flex-col p-1 flex-1 justify-between">
                    <strong class="leading-none mb-1">End Date (Leave blank for never end)</strong>
                    <input type="text" class="form-control form-control-input" style="width: 200px;"
                           v-model="price.end_at"/>
                </div>
            </li>
            <li>
                <div>
                    <a class="button button-primary py-1 px-4 rounded cursor-pointer" @click="addPrice()">Add Price</a>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
import {IsAFormField} from 'architect-js-helpers';

export default {
    mixins: [IsAFormField],

    data: () => ({
        prices: [],
        pricesToAdd: [],
    }),

    mounted() {
        if (this.$route.params.id) {
            window.Architect.request().get('external/coeliac-shop-product-prices/prices/' + this.$route.params.id)
                .then((response) => {
                    this.prices = response.data.map((price) => {
                        price.price = price.price / 100;
                        price.start_at = this.formatDate(price.start_at);

                        if(price.end_at) {
                            price.end_at = this.formatDate(price.end_at);
                        }

                        return price;
                    });
                });
        } else {
            this.addPrice();
        }
    },

    methods: {
        addPrice() {
            this.pricesToAdd.push({
                price: '',
                sale_price: false,
                start_at: moment().format('Y-MM-DD'),
                end_at: '',
            });
        },

        deletePrice(index) {
            this.prices = this.prices.slice(0, index).concat(this.prices.slice(index + 1, this.prices.length));
        },

        formatDate(date) {
            return moment(date).format('Y-MM-DD');
        },

        getFormData() {
            return {
                name: this.name,
                value: this.calculateFormData()
            };
        },

        calculateFormData() {
            let data = [];

            this.prices.forEach((price) => {
                data.push({
                    price: price.price * 100,
                    sale_price: price.sale_price,
                    start_at: price.start_at,
                    end_at: price.end_at !== '' ? price.end_at : null,
                });
            });

            this.pricesToAdd.forEach((price) => {
                data.push({
                    price: price.price * 100,
                    sale_price: price.sale_price || false,
                    start_at: price.start_at || '',
                    end_at: price.end_at !== '' ? price.end_at : null,
                })
            });

            return JSON.stringify(data);
        }
    }
}
</script>
