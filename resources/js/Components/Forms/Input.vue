<template>
    <div class="flex overflow-hidden border border-blue rounded">
        <div class="bg-grey-lightest p-0 flex-1">
            <input v-model="currentValue"
                   :type="type"
                   :name="name"
                   :placeholder="placeholder"
                   @blur="validate()"
                   :min="min"
                   :max="max"
                   :disabled="disabled"
                   :autocomplete="autocomplete"
                   class="w-full bg-transparent border-0 p-3 m-0 text-grey-darkest"
                   :class="disabled ? 'text-grey-light cursor:not-allowed' : ''"
            />
        </div>

        <div class="bg-red flex justify-center items-center p-2 text-white" v-if="hasError && showError"
             v-tooltip.left="{content: errorText, classes: ['bg-red', 'border-red', 'text-white'], boundariesElement: 'body'}">
            <font-awesome-icon :icon="['fas', 'exclamation-circle']"></font-awesome-icon>
        </div>
    </div>
</template>

<script>
    import IsFormField from "@/Mixins/IsFormField";

    export default {
        mixins: [IsFormField],
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
