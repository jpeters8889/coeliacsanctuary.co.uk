export default {
  methods: {
    facebookShare() {
      this.googleEvent('event', 'share', {
        event_label: 'share-facebook',
      });

      this.openPopup(
        `https://www.facebook.com/sharer.php?u=${window.location.href}`,
        'Share On Facebook',
      );
    },

    twitterShare() {
      this.googleEvent('event', 'share', {
        event_label: 'share-twitter',
      });

      this.openPopup(
        `https://twitter.com/intent/tweet?text=${document.querySelector('meta[name=description]').getAttribute('content')}&via=CoeliacSanc&url=${window.location.href}`,
        'Share on Twitter',
      );
    },

    pinterestShare() {
      this.googleEvent('event', 'share', {
        event_label: 'share-pinterest',
      });

      this.openPopup(
        `https://www.pinterest.com/pin/create/button/?url=${window.location.href}&media=${document.querySelector('meta[property="og:image"]').getAttribute('content')}&description=${document.querySelector('meta[name=description]').getAttribute('content')}`,
        'Share on Pinterest',
      );
    },

    redditShare() {
      this.googleEvent('event', 'share', {
        event_label: 'share-reddit',
      });

      this.openPopup(
        `http://www.reddit.com/submit?url=${window.location.href}&title=${document.querySelector('title').innerText}`,
        'Share on Reddit',
      );
    },

    openPopup(link, title) {
      window.open(link, title, 'height=480,width=640,toolbar=no,menubar=no,scrollbars=no,resizable=no,location=no,directories=no,status=no');
    },
  },
};
