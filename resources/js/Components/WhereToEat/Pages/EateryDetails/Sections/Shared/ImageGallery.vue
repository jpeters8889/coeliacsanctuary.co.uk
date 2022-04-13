<template>
  <div>
    <div class="flex flex-wrap -m-2">
      <div
        v-for="(image, index) in images"
        :key="image.id"
      >
        <img
          v-if="limit === 0 || viewAll === true || index < limit"
          class="cursor-pointer p-1 max-w-[125px] max-h-[125px] lg:max-w-[200px] lg:max-h-[200px] 2xl:max-w-[250px] 2xl:max-h-[250px]"
          :src="image.thumb"
          :alt="altText"
          @click="openImage(index)"
        >
      </div>
    </div>

    <template v-if="limit > 0 && images.length > limit && !viewAll">
      <p
        class="mt-2 font-semibold text-blue-dark cursor-pointer hover:underline"
        @click="viewAll = true"
      >
        Viewing <strong class="text-black">{{ limit }}</strong>
        photos out of <strong class="text-black">{{ images.length }}</strong>, view all user photos?
      </p>
    </template>

    <portal
      v-if="displayImage !== false"
      to="modal"
    >
      <modal :title="altText">
        <img
          :src="images[displayImage].path"
          alt=""
        >
      </modal>
    </portal>
  </div>
</template>

<script>
const Modal = () => import('~/Global/UI/Modal' /* webpackChunkName: "chunk-modal" */);

export default {
  components: { Modal },

  props: {
    images: {
      type: Array,
      required: true,
    },
    altText: {
      required: false,
      type: String,
      default: '',
    },
    limit: {
      required: false,
      type: Number,
      default: 0,
    },
  },

  data: () => ({
    displayImage: false,
    viewAll: false,
  }),

  mounted() {
    this.$root.$on('modal-closed', () => {
      this.closeModal();
    });
  },

  methods: {
    openImage(index) {
      this.displayImage = index;
      this.modalKeyEvents('addEventListener');
    },

    goToNextImage() {
      if (this.displayImage + 1 >= this.images.length) {
        return;
      }

      this.displayImage += 1;
    },

    goToPreviousImage() {
      if (this.displayImage === 0) {
        return;
      }

      this.displayImage -= 1;
    },

    closeModal() {
      this.displayImage = false;
      this.modalKeyEvents('removeEventListener');
    },

    handleKeyUpEvent(event) {
      switch (event.code) {
        case 'ArrowRight':
          this.goToNextImage();
          break;
        case 'ArrowLeft':
          this.goToPreviousImage();
          break;
        case 'Escape':
          this.closeModal();
          break;
        default:
          //
          break;
      }
    },

    modalKeyEvents(event) {
      console.log(event);
      window[event]('keyup', this.handleKeyUpEvent);
    },
  },
};

</script>
