<template>
    <div class="p-2 page-box flex flex-col shadow">
        <h3 class="text-lg leading-tight mb-2" v-if="hasTitle()">
            <slot name="title"></slot>
        </h3>

        <slot name="body"></slot>
    </div>
</template>

<script>
    export default {
        methods: {
            hasTitle() {
                return !!this.$slots.title
            }
        }
    }
</script>
