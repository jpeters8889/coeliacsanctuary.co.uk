<template>
    <div class="w-full flex flex-col p-1 border-b border-blue-light-50">
        <div class="w-full flex-flex-col">
            <h3 class="text-2xl font-semibold mb-2 font-coeliac">{{ place.name }}</h3>
            <div class="w-full flex flex-col sm:flex-row">
                <div class="w-full flex flex-col sm:w-1/2">
                    <div>
                        <p class="mb-3">
                            <img :data-src="place.icon" alt="" loading="lazy" :src="lazyLoadSrc"
                                 class="lazy float-left mr-1 mb-1" style="width: 40px"/>
                            {{ place.info }}
                        </p>
                        <p>
                            <strong>Venue Type:</strong> {{ place.venue_type.venue_type }}
                        </p>
                        <p v-if="place.cuisine.cuisine !== 'English'">
                            <strong>Cuisine:</strong> {{ place.cuisine.cuisine }}
                        </p>
                    </div>
                    <div class="flex flex-col mt-2">
                        <p>
                            <span v-html="place.address"></span><br/>
                            {{ place.phone }}
                        </p>
                        <wheretoeat-list-features v-if="place.features.length > 0"
                                                  :features="place.features">
                        </wheretoeat-list-features>
                    </div>
                </div>
                <div class="mt-2 sm:w-1/2">
                    <static-map :lat="place.lat" :lng="place.lng"></static-map>
                </div>
            </div>
            <div class="w-full flex flex-col sm:flex-row">
                <div class="sm:w-1/2">
                    <wheretoeat-ratings
                        :ratings="place.ratings"
                        :average="place.average_rating"
                        :name="place.name"
                        :id="place.id"
                        :has-rated="place.has_been_rated"
                    ></wheretoeat-ratings>
                </div>
                <div class="flex flex-wrap -m-px items-start text-xl sm:w-1/2 sm:justify-end">
                    <wheretoeat-list-reviews v-if="place.reviews.length > 0" :reviews="place.reviews"
                                             class="m-px"></wheretoeat-list-reviews>

                    <a v-if="place.website"
                       class="m-px inline-block bg-blue text-white rounded px-2 py-1 font-semibold leading-none border-blue border-2 hover:bg-white hover:text-blue transition-bg transition-color"
                       :href="place.website" target="_blank">
                        Visit Website
                    </a>
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
