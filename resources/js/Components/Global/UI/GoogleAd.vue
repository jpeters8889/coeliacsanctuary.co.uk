<template>
    <div class="w-full my-2 flex text-center" v-if="hasGoogle">
        <ins class="adsbygoogle"
             style="display: block; width: 100%;"
             data-ad-client="ca-pub-1063051842575021"
             :data-ad-slot="code"
             data-ad-format="auto"
             data-full-width-responsive="true">
        </ins>
    </div>
</template>

<script>
export default {
    props: {
        code: {
            type: String,
            required: true,
        }
    },

    mounted() {
        if (!this.hasGoogle) {
            return;
        }

        (adsbygoogle = window.adsbygoogle || []).push({});
    },

    computed: {
        hasGoogle() {
            return !!window.adsbygoogle;
        }
    }
}
</script>
