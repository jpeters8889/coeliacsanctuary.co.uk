<template>
  <div>
    <div class="relative w-full flex flex-col min-h-map-small">
      <loader :show="loading" />
      <div v-if="!loading">
        <img
          :src="currentImage"
          alt=""
          class="w-full mb-3 cursor-pointer"
          style="max-height: 300px"
          @click="viewImage()"
        >
      </div>
      <div
        v-if="!loading"
        class="flex flex-wrap"
      >
        <div
          v-for="(image, index) in images"
          :key="index"
          class="w-1/5 mr-1"
          style="cursor: zoom-in"
          @click="switchImage(image)"
        >
          <img
            :src="image"
            alt=""
          >
        </div>
      </div>
    </div>

    <portal
      v-if="showModal"
      to="modal"
    >
      <modal modal-classes="w-full">
        <img
          :src="currentImage"
          alt=""
          class="w-full mb-3"
        >
      </modal>
    </portal>
  </div>
</template>

<script>
const Loader = () => import('~/Global/UI/Loader' /* webpackChunkName: "chunk-loader" */);
const Modal = () => import('~/Global/UI/Modal' /* webpackChunkName: "chunk-modal" */);

export default {

  components: {
    loader: Loader,
    modal: Modal,
  },
  props: {
    productId: {
      required: true,
      type: Number,
    },
  },

  data: () => ({
    images: [],
    loading: true,
    currentImage: '',
    showModal: false,
  }),

  mounted() {
    this.getImages();

    this.$root.$on('modal-closed', () => {
      this.showModal = false;
    });
  },

  methods: {
    getImages() {
      this.loading = true;

      coeliac().request().get(`/api/shop/product/${this.productId}/images`)
        .then((response) => {
          if (response.status === 200) {
            this.images = response.data.images;
            this.currentImage = this.images[0];
            this.loading = false;
          }
        });
    },

    viewImage() {
      this.showModal = true;
    },

    switchImage(image) {
      this.currentImage = image;
    },
  },
};
</script>
