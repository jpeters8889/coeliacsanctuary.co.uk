<template>
    <div class="flex text-yellow text-lg justify-center sm:justify-start">
        <font-awesome-icon v-for="n in wholeNumber" :key="n" :icon="['fas', 'star']"></font-awesome-icon>
        <font-awesome-icon v-if="hasHalf" :icon="['fas', 'star-half']"></font-awesome-icon>
    </div>
</template>

<script>
export default {
    props: {
        stars: {
            required: true,
            type: String,
        }
    },

    data: () => ({
        wholeNumber: 0,
        hasHalf: false,
    }),

    mounted() {
        const parts = this.stars.split('.');

        this.wholeNumber = parseInt(parts[0]);
        this.hasHalf = parts[1] === '5';
    }
}
</script>
