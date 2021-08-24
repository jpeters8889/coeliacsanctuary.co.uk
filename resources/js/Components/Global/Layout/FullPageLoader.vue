<template>
    <loader background="bg-black bg-opacity-80" background-position="fixed" :show="loading"></loader>
</template>

<script>
const Loader = () => import('~/Global/UI/Loader' /* webpackChunkName: "chunk-loader" */)

export default {
    data: () => ({
        loading: false,
    }),

    components: {
        'loader': Loader
    },

    mounted() {
        this.$root.$on('full-page-load', () => {
            this.loading = true;
        });

        this.$root.$on('hide-page-load', () => {
            this.loading = false;
        })
    },

    watch: {
        loading: function (value) {
            if (value) {
                document.querySelector('body').classList.add('overflow-hidden');
                return;
            }

            document.querySelector('body').classList.remove('overflow-hidden');
        }
    }
}
</script>
