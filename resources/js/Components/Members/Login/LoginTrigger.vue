<template>
  <div>
    <a
      :class="classes"
      @click.prevent="showModal = true"
    >
      <slot />
    </a>

    <portal
      v-if="showModal"
      to="modal"
    >
      <modal
        closable
        title="Login"
      >
        <member-login-form />
      </modal>
    </portal>
  </div>
</template>

<script>
const Modal = () => import('~/Global/UI/Modal' /* webpackChunkName: "chunk-modal" */);

export default {
  components: {
    modal: Modal,
  },

  props: {
    classes: {
      type: Array,
      default: () => [],
    },
  },

  data: () => ({
    showModal: false,
  }),

  mounted() {
    this.$root.$on('modal-closed', () => {
      this.showModal = false;
    });
  },
};
</script>
