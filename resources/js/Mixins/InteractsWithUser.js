export default {
  methods: {
    isLoggedIn() {
      return window.config.user !== null;
    },

    userHasVerifiedEmail() {
      return window.config.user.email_verified_at !== null;
    },
  },
};
