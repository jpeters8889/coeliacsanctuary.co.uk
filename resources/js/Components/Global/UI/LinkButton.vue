<template>
    <a :class="classList" :href="href">
        <slot></slot>
    </a>
</template>

<script>
export default {
    props: {
        href: {
            type: String,
            required: true,
        },
        theme: {
            type: String,
            default: 'yellow',
            validator: (value) => {
                return ['blue', 'light', 'yellow', 'positive', 'negative'].indexOf(value) !== -1;
            }
        },
        rounded: {
            type: Boolean,
            default: false,
        },
    },

    computed: {
        classList() {
            return {
                'inline-block': true,
                'leading-none': true,
                'p-2': true,
                'bg-blue': this.theme === 'blue',
                'bg-blue-light': this.theme === 'light',
                'bg-yellow': this.theme === 'yellow',
                'rounded': this.rounded,
            }
        }
    }
}
</script>
