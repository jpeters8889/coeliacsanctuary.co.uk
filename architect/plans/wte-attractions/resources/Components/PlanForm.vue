<template>
    <div>
        <div class="mt-2 bg-blue-200 p-2 rounded-lg pb-1" v-for="(restaurant, index) in restaurants">
            <div class="flex">
                <input type="text" class="form-control form-control-input w-full flex-1" v-model="restaurant.name"
                       placeholder="Restaurant Title (Optional)"/>
                <a class="bg-blue-700 text-white font-semibold py-2 px-3 rounded ml-2 cursor-pointer" @click="deleteRest(index)">
                    Delete
                </a>
            </div>
            <textarea class="form-control form-control-input w-full mt-2" v-model="restaurant.info"
                      placeholder="Restaurant Info"></textarea>
        </div>
        <a class="bg-blue-700 text-white font-semibold py-2 px-3 rounded mt-2 inline-block cursor-pointer" @click="add()">
            Add Restaurant
        </a>
    </div>
</template>

<script>
import {IsAFormField} from 'architect-js-helpers';

export default {
    mixins: [IsAFormField],

    props: ['value'],

    data: () => ({
        restaurants: [{
            name: '',
            info: '',
        }],
    }),

    mounted() {
        if (this.value) {
            this.restaurants = this.value;
        }
    },

    methods: {
        getFormData() {
            return {
                name: this.name,
                value: JSON.stringify(this.restaurants),
            }
        },

        deleteRest(index) {
            this.restaurants = this.restaurants.filter((item, key) => key !== index);
        },

        add() {
            this.restaurants.push({
                name: '',
                info: '',
            })
        }
    }
}
</script>
