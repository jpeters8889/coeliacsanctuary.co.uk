<template>
  <div>
    <div
      class="flex flex-wrap"
      :class="withMargin ? '' : '-m-2'"
    >
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
        <div class="relative">
          <img
            :src="images[displayImage].path"
            style="max-height: 90vh;"
            alt=""
          >
          <div
            class="absolute w-full h-full top-0 left-0 flex justify-between"
            @touchstart="handleTouchStart($event)"
            @touchend="handleTouchEnd($event)"
          >
            <div
              class="w-1/2 md:max-w-[150px] group cursor-pointer"
              @click="goToPreviousImage()"
            >
              <div
                v-if="displayImage > 0"
                class="absolute h-full px-4 bg-black bg-opacity-25 text-white top-0 left-0 flex items-center justify-center transition group-hover:bg-opacity-50"
              >
                <font-awesome-icon :icon="['fas', 'chevron-left']" />
              </div>
            </div>
            <div
              class="w-1/2 md:max-w-[150px] group cursor-pointer"
              @click="goToNextImage()"
            >
              <div
                v-if="displayImage < images.length - 1"
                class="absolute h-full px-4 bg-black bg-opacity-25 text-white top-0 right-0 flex items-center justify-center transition group-hover:bg-opacity-50"
              >
                <font-awesome-icon :icon="['fas', 'chevron-right']" />
              </div>
            </div>
          </div>
        </div>
      </modal>
    </portal>
  </div>
</template>

<script>
const Modal = () => import('~/Global/UI/Modal' /* webpackChunkName: "chunk-modal" */);

export default {
  components: { Modal },

  props: {
    withMargin: {
      type: Boolean,
      required: false,
      default: false,
    },
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
    touchStart: 0,
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

    handleTouchStart(event) {
      this.touchStart = event.changedTouches[0].clientX;
    },

    handleTouchEnd(event) {
      const endPosition = event.changedTouches[0].clientX;

      if (this.touchStart < endPosition) {
        this.goToPreviousImage();
      }

      if (this.touchStart > endPosition) {
        this.goToNextImage();
      }
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
          this.$root.$emit('close-modal');
          break;
        default:
          //
          break;
      }
    },

    modalKeyEvents(event) {
      window[event]('keyup', this.handleKeyUpEvent);
    },
  },
};

</script>
