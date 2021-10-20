<template>
  <div
    ref="map"
    class="h-80vh"
  />
</template>

<script>
import HasGoogleMap from '@/Mixins/HasGoogleMap';
import { loadScript } from '@/Utilities/ScriptLoader';
import GoogleEvents from '@/Mixins/GoogleEvents';

export default {
  mixins: [HasGoogleMap, GoogleEvents],

  mounted() {
    this.googleEvent('event', 'dynamic-map', {
      event_category: 'dynamic-map',
      event_label: `dynamic-map-viewed-${this.lat},${this.lng}`,
    });

    loadScript(`https://maps.google.com/maps/api/js?key=${window.config.googleMaps.dynamic}`).then(() => {
      const center = new google.maps.LatLng(this.lat, this.lng);

      const map = new google.maps.Map(this.$refs.map, {
        center,
        zoom: this.zoom,
        mapTypeControl: false,
        streetViewControl: false,
        rotateControl: false,
        fullscreenControl: false,
      });

      // eslint-disable-next-line no-new
      new google.maps.Marker({
        position: center,
        map,
        icon: {
          url: coeliac().getAsset('eatery.png', '/images/map-markers'),
          size: new google.maps.Size(30, 40),
        },
      });
    });
  },
};
</script>
