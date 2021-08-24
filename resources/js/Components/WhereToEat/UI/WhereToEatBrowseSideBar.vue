<template>
    <!-- Transition for black background / side bar -->
    <transition
        enter-active-class="duration-300 ease-out"
        :enter-class="isLt('lg') ? 'opacity-0' : '-translate-x-full'"
        :enter-to-class="isLt('lg') ? 'opacity-100' : 'translate-x-0'"
        leave-active-class="duration-200 ease-in"
        :leave-class="isLt('lg') ? 'opacity-100' : 'translate-x-0'"
        :leave-to-class="isLt('lg') ? 'opacity-0' : '-translate-x-full'"
        @enter="$root.$emit('sidebar-entered')"
    >
        <!-- Black Background -->
        <div
            :class="[
                    'transition', 'transform', 'absolute', 'top-0', 'h-screen', 'bg-black', 'bg-opacity-50', 'pt-12', 'flex',
                    'w-full', 'z-max', 'overflow-hidden', 'lg:bg-transparent', 'lg:p-0', 'lg:relative',
                    'lg:flex-shrink-0', 'lg:w-1/3', 'lg:h-full', 'lg:shadow-lg', 'lg:border-r',
                    'lg:border-grey-off', 'lg:max-h-full', 'lg:z-auto', 'lg:max-w-basket-sidebar'
                ]" v-if="showSidebar">

            <!-- Transition for white box -->
            <transition
                enter-active-class="duration-400 ease-out"
                :enter-class="isLt('lg') ? 'translate-y-full scale-75 opacity-0' : '-translate-x-full'"
                :enter-to-class="isLt('lg') ? 'translate-y-0 opacity-100 scale-100' : 'translate-x-0'"
                leave-active-class="duration-200 ease-in"
                :leave-class="isLt('lg') ? 'translate-y-0 opacity-100' : 'translate-x-0'"
                :leave-to-class="isLt('lg') ? 'translate-y-full opacity-0' : '-translate-x-full'"
            >
                <!-- Main White Box -->
                <div class="transition transform bg-white flex-1 rounded-t-xl overflow-y-scroll lg:rounded-none"
                     v-if="showSidebar && showDetails">

                    <!-- Header -->
                    <div class="w-full border-b border-grey-off flex justify-between p-3 items-center">
                        <h2 class="text-xl font-semibold">Place Details</h2>
                        <div class="text-xl leading-none flex justify-center items-center cursor-pointer">
                            <font-awesome-icon
                                :icon="['fas', isLt('lg') ? 'times' : 'chevron-left']"
                                @click="$root.$emit('close-sidebar')"
                            ></font-awesome-icon>
                        </div>
                    </div>

                    <div v-if="isLoadingPlace" class="p-4">
                        <div class="w-full flex animate-pulse">
                            <div class="w-full flex flex-col sm:w-3/5 lg:w-2/3">
                                <div class="flex justify-between">
                                    <div class="flex-1 mb-4 flex flex-col space-y-1 pr-2">
                                        <h2 class="h-5 bg-black bg-opacity-30"></h2>
                                        <h3 class="bg-grey-darker h-4 w-3/4 bg-opacity-30"></h3>
                                        <span class="bg-grey h-3 w-1/5 bg-opacity-30"></span>
                                    </div>

                                    <div class="w-6 h-6 bg-blue bg-opacity-30 xs:w-7 xs:h-7"></div>
                                </div>

                                <div class="w-full flex flex-col sm:flex-row">
                                    <div class="w-full flex flex-col space-y-3">
                                        <div class="flex flex-col space-y-1">
                                            <p class="bg-grey w-11/12 h-3 bg-opacity-30"></p>
                                            <p class="bg-grey w-1/2 h-3 bg-opacity-30"></p>
                                            <p class="bg-grey w-56 h-3 bg-opacity-30"></p>
                                        </div>

                                        <div class="flex flex-col mt-2 font-semibold space-y-1">
                                            <span class="block bg-grey-dark w-9/12 h-3 bg-opacity-30"></span>
                                            <span class="block bg-grey-dark w-1/3 h-3 bg-opacity-30"></span>
                                            <span class="block bg-grey-dark w-1/5 h-3 bg-opacity-30"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="!isLoadingPlace && Object.keys(placeDetails).length === 0" class="p-4 text-sm">
                        <p>Click on a marker on the map to see the details of that location.</p>
                    </div>

                    <!-- Place Details -->
                    <div
                        v-if="!isLoadingPlace && Object.keys(placeDetails).length > 0"
                        class="p-3 flex flex-col space-y-3"
                    >
                        <div class="flex justify-between">
                            <div class="flex-1 mb-4">
                                <h2 class="text-2xl font-semibold">{{ placeDetails.name }}</h2>
                                <h3 class="text-sm font-semibold text-grey-darker">
                                    <span class="text-base">{{ placeDetails.full_location }}</span><br/>
                                    <span>{{ placeDetails.venue_type.venue_type }}</span>
                                    <span
                                        v-if="placeDetails.cuisine.cuisine && placeDetails.cuisine.cuisine !== 'English'">
                                            - {{ placeDetails.cuisine.cuisine }}
                                        </span>
                                </h3>

                                <a
                                    v-if="placeDetails.website"
                                    class="text-xs font-semibold text-grey hover:text-black transition-all ease-in-out"
                                    :href="placeDetails.website" target="_blank"
                                >
                                    <font-awesome-icon :icon="['fas', 'external-link-alt']"
                                                       class="mr-px"></font-awesome-icon>
                                    Visit Website
                                </a>
                            </div>

                            <div class="w-6 pt-2 xs:w-7" v-if="placeDetails.county.county !== 'Nationwide'">
                                <img :src="placeDetails.icon" alt=""/>
                            </div>
                        </div>

                        <div v-if="placeDetails.restaurants.length" v-for="restaurant in placeDetails.restaurants">
                            <h4 class="font-semibold" v-if="restaurant.restaurant_name">
                                {{ restaurant.restaurant_name }}
                            </h4>

                            <p class="text-sm">{{ restaurant.info }}</p>
                        </div>

                        <p v-if="placeDetails.restaurants.length === 0">
                            {{ placeDetails.info }}
                        </p>

                        <wheretoeat-list-features
                            large
                            v-if="placeDetails.features.length > 0"
                            :name="placeDetails.name"
                            :features="placeDetails.features"
                        />

                        <div class="flex flex-col mt-2 font-semibold text-grey-darkest">
                            <span class="block" v-html="placeDetails.address.replaceAll('<br />', ', ')"></span>
                            <span>{{ placeDetails.phone }}</span>
                        </div>

                        <wheretoeat-ratings
                            v-if="placeDetails.county.county !== 'Nationwide'"
                            :ratings="placeDetails.ratings"
                            :average="placeDetails.average_rating"
                            :name="placeDetails.name"
                            :id="placeDetails.id"
                            :has-rated="placeDetails.has_been_rated"/>

                        <wheretoeat-list-reviews
                            v-if="placeDetails.reviews.length > 0"
                            :reviews="placeDetails.reviews"
                            :name="placeDetails.name"
                            class="m-px"/>
                    </div>
                </div>
            </transition>
        </div>
    </transition>
</template>

<script>
import ResponsiveOptions from "@/Mixins/ResponsiveOptions";
import WhereToEatRatings from "~/WhereToEat/UI/WhereToEatRatings";
import WhereToEatFeatures from "~/WhereToEat/UI/WhereToEatFeatures";
import WhereToEatReviewButton from "~/WhereToEat/UI/WhereToEatReviewButton";

export default {
    mixins: [ResponsiveOptions],

    components: {
        'wheretoeat-ratings': WhereToEatRatings,
        'wheretoeat-list-features': WhereToEatFeatures,
        'wheretoeat-list-reviews': WhereToEatReviewButton,
    },

    props: {
        showSidebar: {
            required: true,
            type: Boolean
        },
        showDetails: {
            required: true,
            type: Boolean
        },
        isLoadingPlace: {
            required: true,
            type: Boolean
        },
        placeDetails: {
            required: true,
            type: Object,
        },
    }
}
</script>
