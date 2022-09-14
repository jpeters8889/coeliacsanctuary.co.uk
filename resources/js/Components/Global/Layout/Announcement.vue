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
      <modal
        modal-classes="text-center w-11/12"
        :title="title"
        small
      >
        <div class="p-4 space-y-4">
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

  props: {
    title: {
      required: true,
      type: String,
    },
  },

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
