<template>
    <div class="flex flex-col md:flex-row items-stretch">
        <div class="flex flex-col w-full">
            <textarea class="form-control form-control-input w-full" v-model="address" name="address"
                      rows="5"></textarea>
            <button class="button button-primary button-big my-2 w-auto rounded" @click.prevent="lookup()">Lookup Address</button>
            <div class="flex my-2">
                <input type="text" class="form-control form-control-input w-1/2 max-w-225 m-1" name="lat" v-model="lat">
                <input type="text" class="form-control form-control-input w-1/2 max-w-225 m-1" name="lng" v-model="lng">
            </div>
        </div>
        <div class="px-1 w-full min-h-250">
            <div ref="map" class="w-full h-full min-h-250">Map</div>
        </div>
    </div>
</template>

<script>
    import {IsAFormField} from 'architect-js-helpers';

    export default {
        mixins: [IsAFormField],

        props: ['value'],

        data: () => ({
            address: '',
            lat: 55.309322,
            lng: -4.174804,
            zoom: 4,
            mapOptions: {},
            map: null,
            marker: null,
        }),

        mounted() {
            if(this.value) {
                this.address = this.value.address;
                this.lat = this.value.lat;
                this.lng = this.value.lng;
                this.zoom = 16;
            }

            this.initMap();

            google.maps.event.addListener(this.map, 'bounds_changed', () => {
                let center = this.map.getBounds().getCenter();

                this.lat = center.lat();
                this.lng = center.lng();

                this.marker.setPosition(new google.maps.LatLng(this.lat, this.lng));
            });
        },

        methods: {
            getFormData() {
                return {
                    name: this.name,
                    value: JSON.stringify({
                        address: this.address,
                        lat: this.lat,
                        lng: this.lng,
                    }),
                }
            },

            initMap() {
                this.mapOptions = {
                    center: new google.maps.LatLng(this.lat, this.lng),
                    zoom: this.zoom,
                    mapTypeId: google.maps.MapTypeId.ROADMAP,
                    gestureHandling: 'greedy',
                    mapTypeControl: false,
                    streetViewControl: false,
                    rotateControl: false,
                    fullscreenControl: false
                };

                this.map = new google.maps.Map(this.$refs.map, this.mapOptions);

                this.marker = new google.maps.Marker({
                    position: new google.maps.LatLng(this.lat, this.lng),
                    map: this.map,
                });
            },

            lookup() {
                window.Architect.request().post('/external/coeliac-address-lookup/lookup', {address: this.address})
                    .then((response) => {
                        this.address = response.data.formatted_address.replace(/, /g, '\n');
                        this.lat = response.data.lat;
                        this.lng = response.data.lng;

                        let latLng = new google.maps.LatLng(this.lat, this.lng);

                        this.marker.setPosition(latLng);
                        this.map.setCenter(latLng);
                        this.map.setZoom(16);
                    });
            }
        }
    }
</script>
