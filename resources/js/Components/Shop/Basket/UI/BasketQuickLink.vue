<template>
    <div
        class="fixed bottom-1 right-1 leading-none bg-blue-light p-3 text-3xl text-yellow shadow-lg rounded cursor-pointer"
        @click="showBasket()">
        <font-awesome-icon :icon="['fas', 'shopping-basket']"></font-awesome-icon>
    </div>
</template>

<script>
export default {
    methods: {
        showBasket() {
            this.$root.$emit('show-basket');
        }
    }
}
</script>
