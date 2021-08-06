<template>
    <div>
        <p class="font-semibold mb-2" :class="large ? 'text-base' : 'text-sm'">Here's some features at {{ name }}</p>
        <ul class="flex flex-wrap space-x-2">
            <li
                v-for="feature in features"
                class="leading-none items-center flex"
            >
                <div class="mr-1 flex-shrink-0" :class="large ? 'w-6' : 'w-4'">
                    <img :src="feature.image" :alt="feature.feature" class="filter saturate-0"/>
                </div>

                <span class="block font-semibold leading-none" :class="large ? 'text-base' : 'text-sm'">{{ feature.feature }}</span>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        name: {
            required: true,
            type: String,
        },
        features: {
            required: true,
            type: Array,
        },
        large: {
            type: Boolean,
            default: false,
        }
    }
}
</script>
