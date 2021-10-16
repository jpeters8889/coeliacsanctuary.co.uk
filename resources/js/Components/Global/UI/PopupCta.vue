<template>
  <div>
    <portal
      v-if="showModal"
      to="modal"
    >
      <modal
        small
        :footer="modal.text"
      >
        <a
          :href="modal.link"
          class="flex flex-col"
          @click.prevent="clickedPopup($event)"
        >
          <img
            :src="modal.image"
            :alt="modal.text"
          >
        </a>
      </modal>
    </portal>
  </div>
</template>

<script>
import GoogleEvents from '@/Mixins/GoogleEvents';

const Modal = () => import('~/Global/UI/Modal' /* webpackChunkName: "chunk-modal" */);

export default {

  components: {
    modal: Modal,
  },
  mixins: [GoogleEvents],

  data: () => ({
    showModal: false,
    modal: {
      id: '',
      text: '',
      link: '',
      image: '',
    },
  }),

  mounted() {
    coeliac().request().get('/api/popup').then((response) => {
      if (response.status === 200 && Object.values(response.data).length > 0) {
        this.modal = response.data;

        setTimeout(() => {
          this.showModal = true;
          this.googleEvent('event', 'view-promotion', {
            event_label: 'loaded',
          });
        }, 6000);
      }
    });

    this.$root.$on('modal-closed', () => {
      this.showModal = false;

      if (this.modal.id) {
        coeliac().request().patch(`/api/popup/${this.modal.id}`);
      }
    });
  },

  methods: {
    clickedPopup() {
      this.googleEvent('event', 'view-promotion', {
        event_label: 'clicked',
      });

      window.location.href = this.modal.link;
    },
  },
};
</script>
