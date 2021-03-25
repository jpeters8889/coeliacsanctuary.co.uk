<template>
    <div class="flex overflow-hidden border border-blue rounded">
        <div class="bg-grey-lightest flex-1">
            <textarea v-model="currentValue" :name="name" :placeholder="placeholder" :rows="rows" @blur="validate()"
                      :maxlength="max"
                      class="w-full bg-transparent border-0 p-3 m-0 text-grey-darkest"></textarea>
        </div>

        <div class="bg-red flex justify-center p-2 text-white pt-3" v-if="hasError && showError"
             v-tooltip="{content: errorText, classes: ['bg-red', 'border-red', 'text-white']}">
            <font-awesome-icon :icon="['fas', 'exclamation-circle']"></font-awesome-icon>
        </div>
    </div>
</template>

<script>
import IsFormField from "@/Mixins/IsFormField";

export default {
    mixins: [IsFormField],

    props: {
        rows: {
            type: Number,
            default: 3,
        },
    },
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
