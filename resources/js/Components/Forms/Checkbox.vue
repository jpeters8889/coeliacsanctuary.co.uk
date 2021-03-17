<template>
    <div class="flex flex-col">
        <div class="flex items-center cursor-pointer" @click="select()">
            <div class="p-2 pl-0">
                <div class="border border-grey-off bg-grey-lightest p-1"
                     :class="inputSize + ' ' + (value ? 'text-green' : 'text-grey-off-light')">
                    <font-awesome-icon :icon="['fas', 'check']"></font-awesome-icon>
                </div>
            </div>
            <div class="flex-1" :class="inputSize">
                {{ label }}
            </div>
        </div>
    </div>
</template>

<script>
    import IsFormField from "@/Mixins/IsFormField";

    export default {
        mixins: [IsFormField],

        props: {
            value: {
                required: true,
                type: Boolean,
            },
            label: {
                required: true,
                type: String,
            },
            inputSize: {
                default: 'text-xl',
                type: String,
            },
        },

        methods: {
            select() {
                this.currentValue = !this.currentValue;
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
