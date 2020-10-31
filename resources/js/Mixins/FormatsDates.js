import moment from "moment";

export default {
    methods: {
        formatDate(date, format = 'Do MMMM YYYY') {
            return moment(date).format(format);
        },
    },
}
