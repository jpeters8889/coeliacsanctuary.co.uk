import WhereToEatRatings from "~/WhereToEat/UI/WhereToEatRatings";
import WhereToEatFeatures from "~/WhereToEat/UI/WhereToEatFeatures";
import WhereToEatReviewButton from "~/WhereToEat/UI/WhereToEatReviewButton";

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
