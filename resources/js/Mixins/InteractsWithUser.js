export default {
    methods: {
        isLoggedIn() {
            return window.config.user !== null;
        }
    }
}
