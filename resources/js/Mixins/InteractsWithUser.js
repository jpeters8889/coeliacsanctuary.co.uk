export default {
  methods: {
    isLoggedIn() {
      return window.config.user !== null;
    },

    userHasVerifiedEmail() {
      return window.config.user?.email_verified_at !== null;
    },

    isAdmin() {
      return window.config.user?.user_level_id === 3;
    },
  },
};
