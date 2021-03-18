<template>
    <div class="w-full flex flex-col p-1 border-b border-blue-light-50">
        <div class="w-full flex-flex-col">
            <h3 class="text-2xl font-semibold mb-2 font-coeliac">{{ place.name }}</h3>
            <div class="w-full flex flex-col xs:flex-row">
                <div class="xs:w-2/3 md:w-4/5">
                    <div>
                        <p class="mb-3">
                            <img :data-src="place.icon" alt="" loading="lazy" :src="lazyLoadSrc" class="lazy float-left mr-1 mb-1" style="width: 40px" />
                            <template v-if="place.type.type === 'wte'">
                                {{ place.info }}
                            </template>
                            <template v-else>
                                <template v-for="restaurant in place.restaurants">
                                    <strong v-if="restaurant.restaurant_name">
                                        {{ restaurant.restaurant_name}}<br />
                                    </strong>

                                    {{ restaurant.info }}
                                </template>
                            </template>
                        </p>
                        <p>
                            <strong>Venue Type:</strong> {{ place.venue_type.venue_type }}
                        </p>
                    </div>

                    <div class="text-xs mt-2 text-xl">
                        <wheretoeat-list-reviews v-if="place.reviews.length > 0" :reviews="place.reviews"></wheretoeat-list-reviews>

                        <a v-if="place.website"
                           class="inline-block bg-blue text-white rounded px-2 py-1 font-semibold leading-none border-blue border-2 mt-0 mb-2 mr-1 hover:bg-white hover:text-blue transition-bg transition-color"
                           :href="place.website" target="_blank">
                            Visit Website
                        </a>
                    </div>
                </div>
                <div class="xs:w-1/3 md:w-1/5">
                    <wheretoeat-list-features v-if="place.features.length > 0" :features="place.features" class="xs:justify-end"></wheretoeat-list-features>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import WhereToEatDetails from "@/Mixins/WhereToEatDetails";
    import LazyLoadsImages from "@/Mixins/LazyLoadsImages";

    export default {
        mixins: [WhereToEatDetails, LazyLoadsImages],

        mounted() {
            this.loadLazyImages();
        }
    }
</script>
