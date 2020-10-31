<template>
    <a class="rounded px-2 py-1 leading-none bg-blue-200 text-blue-900 slider-bg font-semibold inline-block text-center"
       :href="'/cs-adm/page/dispatch-slips/'+id" target="_blank">
        View Dispatch Slip
    </a>
</template>

<script>
    export default {
        props: ['id'],
    }
</script>
