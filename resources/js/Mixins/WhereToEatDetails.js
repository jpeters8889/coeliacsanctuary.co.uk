import WhereToEatRatings from "../Components/WhereToEatRatings";
import WhereToEatFeatures from "../Components/WhereToEatFeatures";
import WhereToEatReviewButton from "../Components/WhereToEatReviewButton";

export default {
    components: {
        'wheretoeat-ratings': WhereToEatRatings,
        'wheretoeat-list-features': WhereToEatFeatures,
        'wheretoeat-list-reviews': WhereToEatReviewButton,
    },

    props: {
        place: {
            type: Object,
            required: true,
        },
        index: {
            type: Number,
            required: true,
        },
    },

    methods: {
        //
    }
}
