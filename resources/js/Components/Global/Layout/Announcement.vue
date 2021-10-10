<template>
  <div>
    <div class="bg-red-dark p-1 text-center text-white">
      <div class="flex flex-col">
        <slot
          name="title"
          class="mb-2 font-semibold"
        />
        <a
          class="cursor-pointer text-white text-opacity-80 text-sm hover:text-opacity-100 hover:underline transition-all"
          @click="showModal = true"
        >
          Read more
        </a>
      </div>
    </div>

    <portal
      v-if="showModal"
      to="modal"
    >
      <modal modal-classes="text-center">
        <h2 class="text-lg mb-2 font-semibold">
          <slot
            name="title"
            class="mb-2 font-semibold"
          />
        </h2>

        <div>
          <slot />
        </div>
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
  }),

  watch: {
    showModal() {
      if (this.showModal) {
        this.googleEvent('event', 'viewed-announcement');
      }
    },
  },

  mounted() {
    this.$root.$on('modal-closed', () => {
      this.showModal = false;
    });
  },
};
</script>
