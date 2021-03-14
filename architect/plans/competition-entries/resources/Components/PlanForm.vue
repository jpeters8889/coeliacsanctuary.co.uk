<template>
    <input type="text" class="form-control form-control-input w-full" v-model="actualValue" :name="name"/>
</template>

<script>
    import {IsAFormField} from 'architect-js-helpers';

    export default {
        mixins: [IsAFormField],
    }
</script>