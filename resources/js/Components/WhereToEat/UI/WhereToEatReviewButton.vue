<template>
    <div class="bg-blue-light-20 p-2">
        <h3 class="mb-2 font-semibold">Our reviews of {{ name }}</h3>
        <ul>
            <li v-for="review in reviews">
                <a :href="reviews[0].link"
                   class="hover:underline"
                   target="_blank">
                    {{ formatDate(review.created_at, 'MMMM YYYY') }}
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
import FormatsDates from "@/Mixins/FormatsDates";

export default {
    mixins: [FormatsDates],

    props: {
        name: {
            type: String,
            required: true,
        },
        reviews: {
            type: Array,
            required: true,
        }
    }
}
</script>
