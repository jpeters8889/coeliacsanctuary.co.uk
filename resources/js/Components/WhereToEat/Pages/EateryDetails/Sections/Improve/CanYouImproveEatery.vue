<template>
  <div>
    <div
      class="border border-blue bg-blue-lightest p-2 rounded mx-3 cursor-pointer hover:bg-blue-light transition lg:mx-0"
      @click="showModal = true"
    >
      Can you improve the information we hold for {{ name }}?
    </div>

    <portal
      v-if="showModal"
      to="modal"
    >
      <modal
        title="Suggest an edit"
        modal-classes="w-full"
      >
        <improve-eatery-modal :id="id" />
      </modal>
    </portal>
  </div>
</template>

<script>
import ImproveEateryModal from '~/WhereToEat/Pages/EateryDetails/Sections/Improve/ImproveEateryModal';

const Modal = () => import('~/Global/UI/Modal' /* webpackChunkName: "chunk-modal" */);

export default {
  components: {
    Modal,
    'improve-eatery-modal': ImproveEateryModal,
  },

  props: {
    id: {
      type: Number,
      required: true,
    },
    name: {
      type: String,
      required: true,
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
