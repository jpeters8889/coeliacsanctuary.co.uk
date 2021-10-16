import dayjs from 'dayjs';

export default {
  methods: {
    formatDate(date, format = 'D MMMM YYYY') {
      return dayjs(date).format(format);
    },
  },
};
