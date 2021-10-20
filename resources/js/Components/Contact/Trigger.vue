<template>
  <div :class="inline ? 'inline-block' : ''">
    <div
      :class="inline ? 'inline-block' : ''"
      n
      @click="showContact = true"
    >
      <slot />
    </div>

    <portal
      v-if="showContact"
      to="modal"
    >
      <modal title="Contact Us">
        <contact-form />
      </modal>
    </portal>
  </div>
</template>

<script>
import GoogleEvents from '@/Mixins/GoogleEvents';

const ContactForm = () => import('~/Contact/Form' /* webpackChunkName: "chunk-contact-form" */);
const Modal = () => import('~/Global/UI/Modal' /* webpackChunkName: "chunk-modal" */);

export default {

  components: {
    'contact-form': ContactForm,
    modal: Modal,
  },
  mixins: [GoogleEvents],

  props: {
    open: {
      type: Boolean,
      default: false,
    },
    redirect: {
      type: String,
      default: null,
    },
    inline: {
      type: Boolean,
      default: false,
    },
  },

  data: () => ({
    showContact: false,
  }),

  watch: {
    showContact() {
      if (this.showContact) {
        this.googleEvent('event', 'contact-form', {
          event_category: 'opened-contact-form',
        });
      }
    },
  },

  mounted() {
    if (this.open) {
      this.showContact = true;
    }

    this.$root.$on('hide-contact-form', () => {
      this.closeModal();
    });

    this.$root.$on('modal-closed', () => {
      this.closeModal();
    });
  },

  methods: {
    closeModal() {
      this.showContact = false;

      if (this.redirect) {
        window.location.href = this.redirect;
      }
    },
  },
};
</script>
