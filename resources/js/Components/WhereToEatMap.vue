<template>
    <div class="relative h-auto" style="min-height: 100px;">
        <loader v-show="!loaded"></loader>
        <div v-show="loaded" id="map-container"></div>
    </div>
</template>

<script>
    import Loader from "./Loader";

    export default {
        data: () => ({
            loaded: false,
            map: null,
        }),

        components: {
            'loader': Loader
        },

        mounted() {
            coeliac().request().get('/api/wheretoeat/settings').then((response) => {
                this.map = new FlaMap(response.data);
                this.map.draw('map-container');

                this.loaded = true;

                setTimeout(() => {
                    window.dispatchEvent(new Event('resize'));
                }, 100);
            });

            this.$root.$on('tab-map-active', () => {
                setTimeout(() => {
                    window.dispatchEvent(new Event('resize'));
                }, 100);
            });
        },
    }
</script>
