<template>
    <div class="flex flex-col">
        <span class="font-semibold text-lg mb-2" v-if="label">{{ label }}</span>
        <div v-for="option in options" class="flex items-center cursor-pointer" @click="changeOption(option.value)">
            <div class="p-2 pl-0">
                <div
                    class="border p-1 text-xl rounded"
                    :class="option.value === currentValue ?
                        'text-white bg-blue-light border-blue-light' :
                        'border-grey-off text-grey-off-light bg-grey-lightest'
                ">
                    <font-awesome-icon :icon="['fas', 'check']"></font-awesome-icon>
                </div>
            </div>
            <div class="flex-1">
                {{ option.label }}
            </div>
        </div>
    </div>
</template>

<script>
import IsFormField from "@/Mixins/IsFormField";

export default {
    mixins: [IsFormField],

    props: {
        options: {
            required: true,
            type: Array,
        },
    },

    methods: {
        changeOption(value) {
            this.currentValue = value;
            this.validate()
        }
    }
}
</script>

<style>
input:focus {
    outline: none;
}

input:-webkit-autofill {
    background: none;
}
</style>
