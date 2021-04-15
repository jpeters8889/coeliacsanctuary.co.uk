import LazyLoad from "vanilla-lazyload";

export default {
    methods: {
        loadLazyImages() {
            coeliac().updateLazyloader();
        }
    },

    computed: {
        lazyLoadSrc: function () {
            return `data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 2'%3E%3C/svg%3E`;
        }
    }
}
