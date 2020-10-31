export default {
    props: {
        lat: {
            type: Number,
            required: true,
        },
        lng: {
            type: Number,
            required: true,
        },
        zoom: {
            type: Number,
            default: 16,
        }
    }
}
