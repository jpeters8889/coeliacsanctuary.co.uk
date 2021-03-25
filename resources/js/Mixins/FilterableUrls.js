export default {
    methods: {
        buildUrl(url, page = 1, search = null, filters = null, encrypt = false) {
            let queryString = `page=${page}`;

            if (search) {
                queryString += `&search=${search}`
            }

            if (filters) {
                let filterStrings = [];

                Object.keys(filters).forEach((filter) => {
                    if (filters[filter] !== null) {
                        if (typeof filters[filter] === 'object') {
                            filterStrings.push('filter[' + filter + ']=' + filters[filter].join(','));
                        } else {
                            filterStrings.push('filter[' + filter + ']=' + filters[filter]);
                        }
                    }
                });

                queryString += '&' + filterStrings.join('&');
            }

            if (encrypt) {
                queryString = 'o=' + btoa(queryString);
            }

            return url + '?' + queryString;
        }
    }
}
