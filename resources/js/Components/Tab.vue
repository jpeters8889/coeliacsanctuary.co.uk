<template>
    <div v-show="isActive">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        props: {
            title: {
                required: true,
                type: String,
            },
            url: {
                required: true,
                type: String,
            },
            active: {
                type: Boolean,
                default: false
            },
            mobileDefault: {
                type: Boolean,
                default: false,
            }
        },

        data: () => ({
                isActive: false
        }),

        watch: {
            isActive: function(value) {
                if(value) {
                    this.$root.$emit(`tab-${this.url}-active`);
                }
            }
        }
    };
</script>
