export default {
  methods: {
    googleEvent(key, event, attributes = {}) {
      if (!window.gtag) {
        return;
      }

      window.gtag(key, event, attributes);
    },
  },
};
