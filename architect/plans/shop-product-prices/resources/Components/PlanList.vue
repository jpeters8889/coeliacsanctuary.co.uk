<template>
    <ul class="flex flex-col">
        <li v-for="(price, label) in value" class="flex p-1">
            <strong class="mr-1">{{ formatLabel(label) }}</strong>
            <span v-html="formatPrice(price)"></span>
        </li>
    </ul>
</template>

<script>
    export default {
        props: {
            value: {
                type: Object,
            }
        },

        methods: {
            formatPrice(price) {
                price = (price / 100).toFixed(2);

                return `&pound;${price}`;
            },

            formatLabel(label) {
                return label.replace('_', ' ').replace(/^(.)|\s+(.)/g, function ($1) {
                    return $1.toUpperCase()
                });
            }
        }
    }
</script>
