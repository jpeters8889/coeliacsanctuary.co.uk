<template>
    <div class="h-full" style="min-width: 200px; min-height: 200px" ref='map'></div>
</template>

<script>
    import HasGoogleMap from "@/Mixins/HasGoogleMap";
    import {loadScript} from "@/Utilities/ScriptLoader";
    import GoogleEvents from "@/Mixins/GoogleEvents";

    export default {
        mixins: [HasGoogleMap, GoogleEvents],

        mounted() {
            this.googleEvent('event', 'dynamic-map', {
                event_category: 'toggled',
                event_label: `${this.lat},${this.lng}`
            });


            loadScript(`https://maps.google.com/maps/api/js?key=${window.config.googleMaps.dynamic}`).then(() => {
                const center = new google.maps.LatLng(this.lat, this.lng);

                const map = new google.maps.Map(this.$refs['map'], {
                    center: center,
                    zoom: this.zoom,
                    mapTypeControl: false,
                    streetViewControl: false,
                    rotateControl: false,
                    fullscreenControl: false
                });

                new google.maps.Marker({
                    position: center,
                    map: map,
                    icon: {
                        url: coeliac().getAsset('eatery.png', '/images/map-markers'),
                        size: new google.maps.Size(30, 40)
                    },
                });
            });
        }
    }
</script>
