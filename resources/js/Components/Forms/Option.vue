<template>
    <div class="flex flex-col">
        <span class="font-semibold text-lg mb-2">{{ label }}</span>
        <div v-for="option in options" class="flex items-center cursor-pointer" @click="changeOption(option.value)">
            <div class="p-2 pl-0">
                <div class="border border-grey-off bg-grey-lightest p-1 text-xl"
                     :class="option.value === currentValue ? 'text-green' : 'text-grey-off-light'">
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
        label: {
            required: true,
            type: String,
        }
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
