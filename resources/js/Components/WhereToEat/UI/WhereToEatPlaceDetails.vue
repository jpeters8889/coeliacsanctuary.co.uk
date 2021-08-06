<template>
    <div class="relative">
        <div class="w-full flex">
            <div class="w-full flex flex-col sm:w-3/5 lg:w-2/3">
                <div class="flex justify-between">
                    <div class="flex-1 mb-4">
                        <h2 class="text-2xl font-semibold">{{ place.name }}</h2>
                        <h3 class="text-sm font-semibold text-grey-darker" v-if="place.county.county !== 'Nationwide'">
                            <span>{{ place.venue_type.venue_type }}</span>
                            <span v-if="place.cuisine.cuisine && place.cuisine.cuisine !== 'English'">
                                            - {{ place.cuisine.cuisine }}
                                        </span>
                        </h3>

                        <a
                            v-if="place.website"
                            class="text-xs font-semibold text-grey hover:text-black transition-all ease-in-out"
                            :href="place.website" target="_blank"
                        >
                            <font-awesome-icon :icon="['fas', 'external-link-alt']"
                                               class="mr-px"></font-awesome-icon>
                            Visit Website
                        </a>
                    </div>

                    <div class="w-6 pt-2 xs:w-7" v-if="place.county.county !== 'Nationwide'">
                        <img :src="place.icon" alt=""/>
                    </div>
                </div>

                <div class="w-full flex">
                    <div class="w-full flex flex-col space-y-2 md:space-y-4">
                        <div v-if="place.restaurants.length" v-for="restaurant in place.restaurants">
                            <h4 class="font-semibold" v-if="restaurant.restaurant_name">
                                {{ restaurant.restaurant_name }}
                            </h4>

                            <p class="text-sm">{{ restaurant.info }}</p>
                        </div>

                        <p v-if="place.restaurants.length === 0">
                            {{ place.info }}
                        </p>

                        <wheretoeat-list-features
                            v-if="place.features.length > 0"
                            :name="place.name"
                            :features="place.features"
                        />

                        <div
                            class="flex flex-col mt-2 font-semibold text-grey-darkest"
                            v-if="place.county.county !== 'Nationwide'"
                        >
                            <span v-if="place.distance">Around {{ place.distance }} miles away...<br/>&nbsp;</span>

                            <span class="block" v-html="place.address.replaceAll('<br />', ', ')"></span>
                            <span>{{ place.phone }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden sm:block pl-4 sm:w-2/5 lg:w-1/3" v-if="place.county.county !== 'Nationwide'">
                <map-static :lat="place.lat" :lng="place.lng"></map-static>
            </div>
        </div>

        <div class="w-full flex flex-col mt-2">
            <wheretoeat-ratings
                v-if="place.county.county !== 'Nationwide'"
                :ratings="place.ratings"
                :average="place.average_rating"
                :name="place.name"
                :id="place.id"
                :has-rated="place.has_been_rated"/>

            <wheretoeat-list-reviews
                v-if="place.reviews.length > 0"
                :reviews="place.reviews"
                :name="place.name"
                class="m-px"/>
        </div>

        <div
            class="absolute -bottom-3 -right-3 flex flex-col justify-end items-end group"
            @mouseenter="showReportLinks = true"
            @mouseleave="showReportLinks = false"
            @click.once="showReportLinks = true"
            v-click-outside="() => this.showReportLinks = false"
        >
            <div
                class="text-grey-off text-xl w-8 h-8 rounded-t-full leading-none flex justify-center items-center transition-all cursor-pointer group-hover:text-grey group-hover:bg-grey-off-light">
                <font-awesome-icon :icon="['fas', 'ellipsis-v']"></font-awesome-icon>
            </div>

            <div class="relative w-full z-max" v-if="showReportLinks">
                <ul class="absolute bg-grey-off-light p-2 rounded-b-xl rounded-tl-xl min-w-72 right-0 shadow-lg">
                    <li class="cursor-pointer font-semibold hover:underline" @click="showModal = true">
                        Report a problem with this place...
                    </li>
                    <li class="text-sm mt-2 text-grey">
                        This place was added to our guide on {{ formatDate(place.created_at, 'D/MM/YYYY') }}
                    </li>
                </ul>
            </div>
        </div>

        <portal to="modal" v-if="showModal">
            <modal name="report-place">
                <wheretoeat-modal-report-place :place="place" />
            </modal>
        </portal>
    </div>
</template>

<script>
import WhereToEatRatings from "~/WhereToEat/UI/WhereToEatRatings";
import WhereToEatFeatures from "~/WhereToEat/UI/WhereToEatFeatures";
import WhereToEatReviewButton from "~/WhereToEat/UI/WhereToEatReviewButton";
import ClickOutside from 'vue-click-outside';
import WhereToEatReportPlace from "~/WhereToEat/Modals/WhereToEatReportPlace";
import FormatsDates from "@/Mixins/FormatsDates";
const Modal = () => import('~/Global/UI/Modal' /* webpackChunkName: "chunk-modal" */)

export default {
    components: {
        'wheretoeat-ratings': WhereToEatRatings,
        'wheretoeat-list-features': WhereToEatFeatures,
        'wheretoeat-list-reviews': WhereToEatReviewButton,
        'wheretoeat-modal-report-place': WhereToEatReportPlace,
        'modal': Modal,
    },

    mixins: [FormatsDates],

    directives: {ClickOutside},

    props: {
        place: {
            type: Object,
            required: true,
        },
    },

    data: () => ({
        showReportLinks: false,
        showModal: false,
    }),

    mounted() {
        this.$root.$on('modal-closed', () => this.showModal = false);
    }
}
</script>
