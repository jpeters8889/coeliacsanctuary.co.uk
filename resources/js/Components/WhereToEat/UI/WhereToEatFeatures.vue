<template>
    <ul class="flex flex-wrap -mx-2">
        <li v-for="feature in features" style="min-width: 40px; max-width: 60px;"
            class="w-1/6 m-2 text-xs leading-none text-center flex flex-col sm:w-1/5">
            <img :src="feature.image" alt="feature.feature"/>
            <span class="block font-semibold mt-1">{{ feature.feature }}</span>
        </li>
    </ul>
</template>

<script>
export default {
    props: {
        features: {
            required: true,
            type: Array,
        }
    }
}
</script>
