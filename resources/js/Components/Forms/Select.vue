<template>
    <div>
        <span v-if="label" class="block font-semibold text-lg mb-2">{{ label }}</span>

        <div class="flex overflow-hidden border border-blue rounded">
            <div class="bg-grey-lightest p-0 flex-1">
                <select :name="name" v-model="currentValue" @blur="validate()"
                        class="w-full bg-transparent border-0 m-0 text-grey-darkest" :class="padding">
                    <option v-for="option in options" :value="option.value" v-text="option.label"></option>
                </select>
            </div>

            <div class="bg-red flex justify-center items-center p-2 text-white" v-if="hasError && showError"
                 v-tooltip.bottom="{content: errorText, classes: ['bg-red', 'border-red', 'text-white']}">
                <font-awesome-icon :icon="['fas', 'exclamation-circle']"></font-awesome-icon>
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
            padding: {
                default: 'p-3',
            },
            label: {
                type: String,
                default: null,
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
