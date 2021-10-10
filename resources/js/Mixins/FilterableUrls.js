export default {
  methods: {
    buildUrl(url, page = 1, search = null, filters = null, encrypt = false, pageLimit = null) {
      let queryString = `page=${page}`;

      if (search) {
        queryString += `&search=${search}`;
      }

      if (filters) {
        const filterStrings = [];

        Object.keys(filters).forEach((filter) => {
          if (filters[filter] !== null) {
            if (typeof filters[filter] === 'object') {
              filterStrings.push(`filter[${filter}]=${filters[filter].join(',')}`);
            } else {
              filterStrings.push(`filter[${filter}]=${filters[filter]}`);
            }
          }
        });

        queryString += `&${filterStrings.join('&')}`;
      }

      if (pageLimit) {
        queryString += `&limit=${pageLimit}`;
      }

      if (encrypt) {
        queryString = `o=${btoa(queryString)}`;
      }

      return `${url}?${queryString}`;
    },
  },
};
