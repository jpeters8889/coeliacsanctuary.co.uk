<template>
    <div class="flex-1 flex overflow-hidden max-h-full" ref="wrapper">
        <wheretoeat-ui-browse-sidebar
            :is-loading-place="isLoadingPlace"
            :place-details="placeDetails"
            :show-details="showDetails"
            :show-sidebar="showSidebar"
        ></wheretoeat-ui-browse-sidebar>

        <div
            class="absolute w-12 h-12 bg-white border-1 border-grey-off shadow z-max cursor-pointer text-xl leading-none flex justify-center items-center"
            @click="showSidebar = true"
            v-if="isGte('lg') && !showSidebar"
        >
            <font-awesome-icon :icon="['fas', 'chevron-right']"></font-awesome-icon>
        </div>

        <div class="relative flex-1 overflow-hidden">
            <div class="absolute w-5/6 p-2 z-20 overflow-hidden max-w-basket-sidebar"
                 :class="{'h-full': expandFilterBar,'lg:ml-14': !showSidebar}"
            >
                <div class="bg-white shadow overflow-hidden" :class="{'h-full': expandFilterBar}">
                    <div
                        class="p-2 border-b border-grey-off bg-white z-10"
                        @click="expandFilterBar = !expandFilterBar"
                    >
                        <div class="flex items-center text-xl">
                            <font-awesome-icon :icon="['fas', 'filter']" class="mr-4"></font-awesome-icon>
                            <span class="font-semibold flex-1">Filters</span>
                            <font-awesome-icon :icon="['fas', expandFilterBar ? 'chevron-up' : 'chevron-down']"/>
                        </div>
                        <div
                            class="border-t border-grey-off text-xs text-grey mt-2 pt-2"
                            v-if="!expandFilterBar"
                            v-html="currentFilterLabel"
                        ></div>
                    </div>

                    <div class="px-4 overflow-y-scroll h-full pb-12 mb-1" v-if="expandFilterBar">
                        <div class="border-b border-grey-off-dark pb-2">
                            <h3 class="text-lg font-semibold mb-2">Show Categories</h3>

                            <ul class="flex flex-col space-y-2">
                                <li
                                    v-for="category in filters.categories"
                                    class="flex-1 flex cursor-pointer group select-none"
                                    @click="category.checked = !category.checked"
                                >
                                    <div
                                        class="mr-2 w-5 h-5 border border-black rounded-sm text-xs leading-none flex justify-center items-center transition-alls flex-shrink-0"
                                        :class="category.checked ? 'text-white bg-black' : 'bg-white text-grey-off-light group-hover:text-grey-off-dark'"
                                    >
                                        <font-awesome-icon :icon="['fas', 'check']"></font-awesome-icon>
                                    </div>

                                    <div>{{ category.label }}</div>
                                </li>
                            </ul>
                        </div>

                        <div class="border-b border-grey-off-dark py-2">
                            <h3 class="text-lg font-semibold mb-2">Show Venue Types</h3>

                            <ul class="flex flex-col space-y-2">
                                <li
                                    v-for="venueType in filters.venueTypes"
                                    class="flex-1 flex cursor-pointer group select-none"
                                    @click="venueType.checked = !venueType.checked"
                                >
                                    <div
                                        class="mr-2 w-5 h-5 border border-black rounded-sm text-xs leading-none flex justify-center items-center transition-alls flex-shrink-0"
                                        :class="venueType.checked ? 'text-white bg-black' : 'bg-white text-grey-off-light group-hover:text-grey-off-dark'"
                                    >
                                        <font-awesome-icon :icon="['fas', 'check']"></font-awesome-icon>
                                    </div>

                                    <div>{{ venueType.label }}</div>
                                </li>
                            </ul>
                        </div>

                        <div class="py-2">
                            <h3 class="text-lg font-semibold mb-2">Special Features</h3>

                            <ul class="flex flex-col space-y-2">
                                <li
                                    v-for="feature in filters.features"
                                    class="flex-1 flex cursor-pointer group select-none"
                                    @click="feature.checked = !feature.checked"
                                >
                                    <div
                                        class="mr-2 w-5 h-5 border border-black rounded-sm text-xs leading-none flex justify-center items-center transition-alls flex-shrink-0"
                                        :class="feature.checked ? 'text-white bg-black' : 'bg-white text-grey-off-light group-hover:text-grey-off-dark'"
                                    >
                                        <font-awesome-icon :icon="['fas', 'check']"></font-awesome-icon>
                                    </div>

                                    <div>{{ feature.label }}</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div id="map" class="w-full h-full"></div>
        </div>
    </div>
</template>

<script>
import Map from 'ol/Map';
import OSM from 'ol/source/OSM';
import {getDistance} from 'ol/sphere';
import TileLayer from 'ol/layer/Tile';
import View from 'ol/View';
import ResponsiveOptions from "@/Mixins/ResponsiveOptions";
import {fromLonLat, toLonLat, transformExtent} from 'ol/proj';
import {Feature} from "ol";
import {Point} from "ol/geom";
import {Fill, Icon, Stroke, Style} from "ol/style";
import VectorLayer from "ol/layer/Vector";
import VectorSource from "ol/source/Vector";
import {Cluster} from "ol/source";
import CircleStyle from "ol/style/Circle";
import Text from "ol/style/Text";
import WhereToEatBrowseSideBar from "~/WhereToEat/UI/WhereToEatBrowseSideBar";
import FilterableUrls from "@/Mixins/FilterableUrls";
import {boundingExtent} from "ol/extent";

export default {
    mixins: [ResponsiveOptions, FilterableUrls],

    components: {
        'wheretoeat-ui-browse-sidebar': WhereToEatBrowseSideBar,
    },

    data: () => ({
        processedUrl: {
            latLng: null,
            zoom: null,
        },
        map: null,

        showSidebar: false,
        showDetails: false,
        isLoadingPlace: false,
        placeDetails: {},

        expandFilterBar: false,

        filters: {
            categories: [
                {
                    label: 'Eateries',
                    count: 0,
                    id: 1,
                    checked: true,
                },
                {
                    label: 'Attractions',
                    count: 0,
                    id: 2,
                    checked: true,
                },
                {
                    label: 'Hotels',
                    count: 0,
                    id: 3,
                    checked: true,
                }
            ],
            venueTypes: [],
            features: [],
        },

        filterTimeout: null,
    }),

    async mounted() {
        this.$refs.wrapper.style.maxHeight = `${this.$refs.wrapper.offsetHeight}px`;

        if (this.isGte('lg')) {
            this.showSidebar = true;
            this.showDetails = true;
        }

        this.$root.$on('close-sidebar', () => {
            this.showSidebar = false;
            this.showDetails = false

            this.$nextTick(() => {
                setTimeout(() => {
                    this.map.updateSize();
                }, 500);
            });
        });

        this.$root.$on('sidebar-entered', () => {
            this.showDetails = true;
        })

        await this.loadFilters();

        this.parseUrl();

        this.createMap();

        this.populateMap();
    },

    methods: {
        addMarkersToMap(markers) {
            let zoomLimit = 13;

            if (this.isGte('lg')) {
                zoomLimit = 11;
            }

            if (this.getZoom() < zoomLimit) {
                return new VectorLayer({
                    name: 'markers',
                    source: new Cluster({
                        distance: 60,
                        minDistance: 30,
                        source: new VectorSource({
                            features: markers
                        }),
                    }),
                    style: (feature) => this.clusterStyle(feature),
                })
            }

            return new VectorLayer({
                name: 'markers',
                source: new VectorSource({
                    features: markers
                }),
            })
        },

        clearMarkers() {
            this.map.removeLayer(this.getMarkersLayer());
            this.map.removeLayer(this.getMarkersLayer());
        },

        clusterStyle(feature) {
            const size = feature.get('features').length;

            return new Style({
                image: new CircleStyle({
                    radius: 20,
                    stroke: new Stroke({
                        color: '#000',
                    }),
                    fill: new Fill({
                        color: '#ecd14a',
                    }),
                }),
                text: new Text({
                    text: size.toString(),
                    fill: new Fill({
                        color: '#000',
                    }),
                    scale: 2,
                }),
            });
        },

        createMap() {
            this.map = new Map({
                layers: [
                    new TileLayer({
                        source: new OSM(),
                    }),
                ],
                target: 'map',
                view: new View({
                    center: this.initialLatLng,
                    zoom: this.initialZoom,
                }),
            });

            this.map.on('moveend', this.handleMapMove);

            this.map.on('click', this.handleMapClick)

            this.map.on('pointermove', (event) => {
                if (event.dragging ) {
                    return
                }

                this.map.getTargetElement().style.cursor = this.map.hasFeatureAtPixel(this.map.getEventPixel(event.originalEvent)) ? 'pointer' : '';
            });
        },

        getApiUrl() {
            const [lat, lng] = this.getLatLng();

            const url = new URL(`${window.config.baseUrl}/api/wheretoeat/browse`);

            url.searchParams.append('lat', lat.toString());
            url.searchParams.append('lng', lng.toString());
            url.searchParams.append('range', this.getViewableRadius().toString())

            this.buildFilterQueryString().forEach((filter) => {
                url.searchParams.append(filter.key, filter.value);
            })

            return url.toString();
        },

        buildFilterQueryString() {
            let filterStrings = [];

            Object.keys(this.currentFilters).forEach((filter) => {
                if (this.currentFilters[filter] !== null) {
                    if (typeof this.currentFilters[filter] === 'object') {
                        filterStrings.push({
                            key: 'filter[' + filter + ']',
                            value: this.currentFilters[filter].join(',')
                        });
                    } else {
                        filterStrings.push({key: 'filter[' + filter + ']', value: this.currentFilters[filter]});
                    }
                }
            });

            return filterStrings;
        },

        async getFeatures() {
            const response = await coeliac().request()
                .get(this.buildUrl('/api/wheretoeat/features', 1, this.searchText, this.currentFilters))

            return new Promise((resolve) => {
                this.filters.features = response.data.map((data) => {
                    data['checked'] = false;

                    return data;
                });

                resolve(true);
            });
        },

        getLatLng() {
            return toLonLat(this.map.getView().getCenter()).reverse();
        },

        getMarkersLayer() {
            let rtr;

            this.map.getLayers().forEach(layer => {
                if (layer.get('name') !== undefined && layer.get('name') === 'markers') {
                    rtr = layer;
                }
            });

            return rtr;
        },

        getPlaceDetails(id) {
            this.isLoadingPlace = true;

            coeliac().request().get(`/api/wheretoeat/${id}`).then((response) => {
                if (response.status !== 200) {
                    coeliac().error('There was an error loading this place details...')

                    return;
                }

                this.placeDetails = response.data;
            }).catch(() => {
                coeliac().error('There was an error loading this place details...')
            }).finally(() => {
                this.isLoadingPlace = false;
            })
        },

        async getSummary() {
            const response = await coeliac().request()
                .get(this.buildUrl('/api/wheretoeat/summary', 1, this.searchText, this.currentFilters))

            return new Promise(resolve => {
                this.filters.categories[0].count = response.data.eateries;
                this.filters.categories[1].count = response.data.attractions;
                this.filters.categories[2].count = response.data.hotels;

                resolve(true);
            });
        },

        async getVenueTypes() {
            const response = await coeliac().request()
                .get(this.buildUrl('/api/wheretoeat/venueTypes', 1, this.searchText, this.currentFilters))

            return new Promise((resolve) => {
                this.filters.venueTypes = response.data.map((data) => {
                    data['checked'] = false;

                    return data;
                });

                resolve(true);
            });
        },

        getViewableRadius() {
            const latLng = transformExtent(this.map.getView().calculateExtent(this.map.getSize()), 'EPSG:3857', 'EPSG:4326');

            return (getDistance([latLng[0], latLng[1]], [latLng[2], latLng[3]]) / 1609);
        },

        getZoom() {
            return this.map.getView().getZoom();
        },

        handleMapClick(event) {
            try {
                this.getMarkersLayer().getFeatures(event.pixel).then((feature) => {
                    if (!feature.length) {
                        return;
                    }

                    let zoomLimit = 13;

                    if (this.isGte('lg')) {
                        zoomLimit = 11;
                    }

                    if(this.getZoom() < zoomLimit) {
                        //cluster view
                        console.log('cluster');

                        this.getMarkersLayer().getFeatures(event.pixel).then((clickedFeatures) => {
                            console.log(clickedFeatures);
                            if (clickedFeatures.length > 0) {
                                // Get clustered Coordinates
                                const features = clickedFeatures[0].get('features');
                                if (features.length > 0) {
                                    const extent = boundingExtent(
                                        features.map((r) => r.getGeometry().getCoordinates())
                                    );

                                    this.map.getView().fit(extent, {duration: 500, padding: [50, 50, 50, 50]});

                                    setTimeout(() => {
                                        if (this.getZoom() >= 18) {
                                            this.map.getView().setZoom(18);
                                        }
                                    }, 600);
                                }
                            }
                        });

                        return;
                    }

                    feature = feature[0];

                    this.placeDetails = {};
                    this.getPlaceDetails(feature.get('id'));

                    if (this.placeDetails === {}) {
                        return;
                    }

                    this.showSidebar = true;
                })
            } catch (e) {
                //
            }
        },

        handleMapMove() {
            this.updateUrl();
            this.populateMap();
        },

        async loadFilters() {
            await this.getSummary();
            await this.getVenueTypes();
            await this.getFeatures();
        },

        parseUrl() {
            const url = new URL(window.location.href);
            let paths = url.pathname.replace('/wheretoeat/browse', '');
            if (paths.charAt(0) === '/') {
                paths = paths.replace('/', '');
            }

            const [latLng, zoom, type, venueType, features] = paths.split('/');

            this.processedUrl.latLng = latLng;
            this.processedUrl.zoom = zoom;

            if (type) {
                this.presetFilters(type, venueType, features);
            }
        },

        presetFilters(types, venueTypes, features) {
            types = atob(types).split(',').map(id => parseInt(id));
            venueTypes = atob(venueTypes).split(',').map(id => parseInt(id));
            features = atob(features).split(',').map(id => parseInt(id));

            this.filters.categories.forEach((type) => {
                type.checked = types.includes(type.id);
            });

            this.filters.venueTypes.forEach((venueType) => {
                venueType.checked = venueTypes.includes(venueType.id);
            });

            this.filters.features.forEach((feature) => {
                feature.checked = features.includes(feature.id);
            })
        },

        populateMap() {
            this.clearMarkers();

            coeliac().request().get(this.getApiUrl()).then((response) => {
                if (response.status !== 200) {
                    coeliac().error('There was an error loading our eating out guide...');

                    return;
                }

                const markers = response.data.data.map((item) => {
                    return new Feature({
                        id: item.id,
                        geometry: new Point(fromLonLat([item.lng, item.lat])),
                    })
                }).map((marker) => {
                    marker.setStyle(this.markerStyle);

                    return marker;
                });

                this.map.addLayer(this.addMarkersToMap(markers));
            }).catch(() => {
                coeliac().error('There was an error loading our eating out guide...');
            })
        },

        updateUrl(latLng = null, zoom = null) {
            if (!latLng) {
                latLng = this.getLatLng();
            }

            if (!zoom) {
                zoom = this.getZoom();
            }

            const paths = [
                latLng.join(','),
                Math.round(zoom),
                btoa(this.currentFilters['type']),
                btoa(this.currentFilters['venueType'] || ''),
                btoa(this.currentFilters['feature'] || ''),
            ];

            let url = `${window.config.baseUrl}/wheretoeat/browse/${paths.join('/')}`;

            history.pushState(null, null, url);

        }
    },

    computed: {
        currentFilters() {
            const filters = {
                type: this.filters.categories.filter((category) => category.checked).map((category) => category.id),
            }

            if (this.filters.features.filter(feature => feature.checked).length > 0) {
                filters['feature'] = this.filters.features.filter((feature) => feature.checked).map((feature) => feature.id);
            }

            if (this.filters.venueTypes.filter(venueType => venueType.checked).length > 0) {
                filters['venueType'] = this.filters.venueTypes.filter((venueType) => venueType.checked).map((venueType) => venueType.id);
            }

            return filters
        },

        initialLatLng() {
            return fromLonLat((this.processedUrl.latLng ? this.processedUrl.latLng.split(',') : [54.093409, -2.89479]).reverse())
        },

        initialZoom() {
            if (this.processedUrl.zoom) {
                return this.processedUrl.zoom;
            }

            switch (this.currentSize()) {
                case 'sm':
                case 'md':
                case 'lg':
                case 'xl':
                case '2xl':
                    return 6;
                case 'xs':
                case 'xxs':
                default:
                    return 5;
            }
        },

        markerStyle() {
            return new Style({
                image: new Icon({
                    // crossOrigin: 'anonymous',
                    imgSize: [50, 50],
                    src: `${window.config.baseUrl}/assets/svg/marker.svg`,
                }),
            })
        },

        currentFilterLabel() {
            let rtr = ['Currently showing'];

            const selectedCategories = this.filters.categories.filter((category) => category.checked);
            const selectedVenueTypes = this.filters.venueTypes.filter((venueType) => venueType.checked);
            const selectedFeatures = this.filters.features.filter((feature) => feature.checked);

            if (selectedCategories.length === 3 && selectedVenueTypes.length === 0 && selectedFeatures.length === 0) {
                return 'Currently showing all locations';
            }

            if (selectedCategories.length === 3) {
                rtr.push('all locations');
            }

            if (selectedCategories.length < 3) {
                rtr.push(selectedCategories.map(category => `<strong>${category.label}</strong>`).join(' and '));
            }

            if (selectedVenueTypes.length > 0) {
                rtr.push(`with a venue type of ${selectedVenueTypes.map(venueType => `<strong>${venueType.label}</strong>`).join(', ')}`)
            }

            if (selectedFeatures.length > 0) {
                rtr.push(`that have ${selectedFeatures.map(feature => `<strong>${feature.label}</strong>`).join(', ')} listed as a feature.`)
            }

            return rtr.join(' ');
        }
    },

    watch: {
        expandFilterBar: function () {
            this.handleMapMove()
        },

        filters: {
            deep: true,
            handler: function () {
                if (!this.expandFilterBar) {
                    return;
                }

                this.filterTimeout = setTimeout(() => {
                    this.handleMapMove()
                }, 500)
            }
        },
    }
}
</script>

<style>
@import url(https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.6.1/css/ol.css);

.ol-zoom {
    left: auto;
    right: 0.5em;
    z-index: 50;
}
</style>
