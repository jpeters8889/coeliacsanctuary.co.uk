<template>
    <div class="leading-none">
        <a v-if="reviews.length === 1" :href="reviews[0].link"
           class="inline-block bg-blue text-white rounded px-2 py-1 font-semibold leading-none border-blue border-2 hover:bg-white hover:text-blue transition-bg transition-color"
           target="_blank">
            Our Review from {{ formatDate(reviews[0].created_at) }}
        </a>

        <ul v-else class="flex flex-wrap  border-blue border-2 rounded">
            <li class="rounded relative bg-blue text-white font-semibold leading-none"
                @mouseenter="showReviews = true" @mouseleave="showReviews = false">
                <a class="inline-block px-2 py-1 hover:bg-white hover:text-blue transition-bg transition-color">
                    Our Reviews
                    <font-awesome-icon :icon="['fas', 'caret-down']"></font-awesome-icon>
                </a>

                <ul class="bg-blue z-30 absolute w-full text-blue-light flex flex-col border-2 border-b-0 border-blue"
                    v-show="showReviews">
                    <li v-for="review in reviews"
                        class="text-white border-0 border-b-2 border-blue-light hover:bg-white">
                        <a :href="review.link"
                           class="bg-transparent b-0 rounded-none m-0 p-1 w-full block pr-4 transition-color hover:text-black"
                           target="_blank">
                            Our Review from {{ formatDate(review.created_at) }}
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</template>

<script>
    import FormatsDates from "../Mixins/FormatsDates";

    export default {
        mixins: [FormatsDates],

        data: () => ({
            showReviews: false,
        }),

        props: {
            reviews: {
                type: Array,
                required: true,
            }
        }
    }
</script>
