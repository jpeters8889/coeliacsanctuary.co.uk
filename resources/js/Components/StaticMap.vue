<template>
    <div class="h-full mb-1">
        <div class="w-full" :data-bg="backgroundUrl()" :class="fullClasses" :style="styles()"
             @click.stop="showDetails = true"></div>

        <portal to="modal" v-if="showDetails">
            <modal modal-classes="w-full h-full">
                <dynamic-map :lat="lat" :lng="lng"></dynamic-map>
            </modal>
        </portal>
    </div>
</template>

<script>
import HasGoogleMap from "../Mixins/HasGoogleMap";
import LazyLoadsImages from "../Mixins/LazyLoadsImages";
import DynamicMap from "./DynamicMap";
import Modal from "./Modal";

export default {
    mixins: [HasGoogleMap, LazyLoadsImages],

    components: {
        'dynamic-map': DynamicMap,
        'modal': Modal,
    },

    props: {
        mapClasses: {
            type: Array,
            default: () => {
                return ['min-h-map']
            },
        },
    },

    data: () => ({
        showDetails: false,
    }),

    mounted() {
        this.$root.$on('modal-closed', () => {
            this.showDetails = false;
        });

        this.loadLazyImages();
    },

    methods: {
        styles() {
            return {
                // background: `url(${this.backgroundUrl()}) no-repeat 50% 50%`,
                background: `no-repeat 50% 50%`,
                lineHeight: 0,
                cursor: 'pointer',
            }
        },

        backgroundUrl() {
            return `https://maps.googleapis.com/maps/api/staticmap?center${this.lat},${this.lng}&size=600x1500&maptype=roadmap&markers=color:green%7Clabel:%7C${this.lat},${this.lng}&key=${window.config.googleMaps.static}`
        },
    },

    computed: {
        fullClasses() {
            let classes = this.mapClasses;

            classes.push('lazy');

            return classes;
        }
    }
}
</script>
