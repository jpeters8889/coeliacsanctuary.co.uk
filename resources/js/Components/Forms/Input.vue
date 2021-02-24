<template>
    <div class="flex overflow-hidden border border-blue rounded">
        <div class="bg-grey-lightest p-0 flex-1">
            <input v-model="currentValue"
                   :id="id"
                   :type="type"
                   :name="name"
                   :placeholder="placeholder"
                   @blur="validate()"
                   :min="min"
                   :max="max"
                   :disabled="disabled"
                   :autocomplete="autocomplete"
                   :class="classes()"
            />
        </div>

        <div class="bg-red flex justify-center items-center p-2 text-white" :class="small ? 'text-xs' : ''" v-if="hasError && showError"
             v-tooltip.left="{content: errorText, classes: ['bg-red', 'border-red', 'text-white'], boundariesElement: 'body'}">
            <font-awesome-icon :icon="['fas', 'exclamation-circle']"></font-awesome-icon>
        </div>
    </div>
</template>

<script>
    import IsFormField from "@/Mixins/IsFormField";

    export default {
        mixins: [IsFormField],

        methods: {
            classes() {
                let base = ['w-full','bg-transparent','border-0','m-0','text-grey-darkest']

                if(this.disabled) {
                    base.push('text-grey-light', 'cursor:not-allowed');
                }

                base.push(this.small ? 'p-1 text-sm' : 'p-3 text-base')

                return base;
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
