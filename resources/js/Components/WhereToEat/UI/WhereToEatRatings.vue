<template>
    <div class="my-2 text-center sm:text-left">
        <h2 class="text-2xl font-semibold">Average Rating</h2>

        <div v-if="ratings.length > 0">
            <stars :stars="average"></stars>
            Average rating of <strong>{{ average }}</strong> from {{ ratings.length }} Reviews<br />
            <a class="font-semibold text-blue transition-color hover:text-grey" @click="showDetails = true">
                View Comments and Ratings
            </a>
        </div>

        <em v-else>This place hasn't been rated yet...</em>

        <div class="mt-2">
            <h3>Have you visited {{ name }}? How would you rate it?</h3>

            <em v-if="hasBeenRated">Sorry, you've already rated this location...</em>
            <div v-else class="text-3xl flex justify-center sm:justify-start">
                <span class="wteRater cursor-pointer" :class="n <= hoveringOn ? 'text-yellow' : 'text-grey-off'"
                      v-for="n in 5"
                      :key="n+1" @mouseover="hoveringOn = n" @mouseleave="hoveringOn = null"
                      @click.prevent="rate(n)">
                    <font-awesome-icon :icon="['fas', 'star']"></font-awesome-icon>
                </span>
            </div>
        </div>

        <portal to="modal" v-if="showDetails">
            <modal name="showDetails">
                <h2 class="text-lg font-semibold mb-2">
                    Ratings for {{ name }}
                </h2>

                <div class="flex flex-col">
                    <p class="pb-2 mb-2 border-b border-blue-50">
                        All the reviews and ratings below have been submitted by visitors to our website and App,
                        ratings are applied straight away but text reviews must be validated by an admin before
                        they are visible.
                    </p>

                    <div v-for="rating in ratings">
                        <template v-if="!rating.body">
                            <div class="font-semibold mb-2 text-center">
                                {{ formatDate(rating.created_at) }}
                                <stars :stars="rating.rating.toString()"></stars>
                            </div>
                            <div class="mt-1">
                                <em>Reviewer didn't leave a comment...</em>
                            </div>
                        </template>
                        <template v-else>
                            <div class="font-semibold mb-2 text-center">
                                {{ rating.name }}, {{ formatDate(rating.created_at) }}
                                <stars :stars="rating.rating.toString()"></stars>
                            </div>
                            <div class="mt-1">
                                {{ rating.body }}
                            </div>
                        </template>
                    </div>
                </div>
            </modal>
        </portal>

        <portal to="modal" v-if="showCreateRating">
            <modal name="showCreate">
                <wheretoeat-create-rating :id="this.id" :rating="ratingToSubmit"></wheretoeat-create-rating>
            </modal>
        </portal>
    </div>
</template>

<script>
    import FormatsDates from "@/Mixins/FormatsDates";
    import GoogleEvents from "@/Mixins/GoogleEvents";
    const Modal = () => import('~/Global/UI/Modal' /* webpackChunkName: "chunk-modal" */)
    import WhereToEatCreateRating from "~/WhereToEat/Modals/WhereToEatCreateRating";

    export default {
        mixins: [FormatsDates, GoogleEvents],

        components: {
            'modal': Modal,
            'wheretoeat-create-rating': WhereToEatCreateRating,
        },

        props: {
            id: {
                type: Number,
                required: true,
            },
            name: {
                type: String,
                required: true,
            },
            ratings: {
                type: Array,
                required: true,
            },
            average: {
                type: String | null,
                required: true,
            },
            hasRated: {
                type: Boolean,
                required: true,
                default: false,
            }
        },

        data: () => ({
            hoveringOn: null,
            showDetails: false,
            showCreateRating: false,
            ratingToSubmit: 0,

            hasBeenRated: false,
        }),

        mounted() {
            this.hasBeenRated = this.hasRated;

            this.$root.$on('modal-closed', (modal) => {
                if (modal === 'showDetails') {
                    this.showDetails = false;
                }

                if (modal === 'showCreate') {
                    this.showCreateRating = false;
                }
            });

            this.$root.$on('rated-place', (id) => {
                if(id === this.id) {
                    this.hasBeenRated = true;
                }
            })
        },

        methods: {
            rate(rating) {
                this.ratingToSubmit = rating;
                this.showCreateRating = true;
            }
        },

        watch: {
            showDetails: function() {
                if(this.showDetails) {
                    this.googleEvent('event', 'wheretoeat', {
                        event_category: 'showed-rating-details',
                        event_label: this.id,
                    });

                }
            },

            showCreateRating: function() {
                if(this.showCreateRating) {
                    this.googleEvent('event', 'wheretoeat', {
                        event_category: 'created-rating',
                        event_label: this.id,
                    })
                }
            }
        }
    }
</script>
