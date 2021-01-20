<template>
    <div>
        <div @click="showSearch()" class="js-search-icon cursor-pointer">
            <font-awesome-icon :icon="['fas', 'search']"></font-awesome-icon>
        </div>
    </div>
</template>

<script>
    export default {
        methods: {
            showSearch() {
                this.$root.$emit('show-quick-search');
            }
        }
    }
</script>
