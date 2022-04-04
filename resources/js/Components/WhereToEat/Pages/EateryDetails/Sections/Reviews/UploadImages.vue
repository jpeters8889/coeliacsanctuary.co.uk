<template>
  <div class="flex-1">
    <span class="block text-lg text-blue-dark font-semibold">
      Do you want to attach up to six (6) images with your review?
    </span>

    <div class="rounded-lg border-grey-off border p-2 mt-2">
      <input
        ref="fileTrigger"
        type="file"
        class="hidden"
        accept="image/*"
        multiple
        @change="processImages()"
      >

      <ul class="grid grid-cols-2">
        <li
          v-for="(image, index) in images"
          :key="index"
          :class="[...imageClasses, images.length > 0 ? 'initial' : 'hidden']"
        >
          <div
            v-if="image.processing"
            class="h-[100px] w-[100px]"
          >
            <loader
              background-position="relative"
              max-height="100px"
              max-width="100px"
              :show="true"
            />
          </div>

          <div v-else>
            <img
              :src="image.path"
              alt=""
            >
          </div>
        </li>

        <li
          :class="imageClasses"
          class="text-6xl text-blue-dark cursor-pointer"
          @click="uploadImage()"
        >
          <font-awesome-icon :icon="['fas', 'plus']" />
        </li>
      </ul>

      <small class="text-xs leading-none text-grey-off-dark">Maximum file size: 2mb</small>
    </div>
  </div>
</template>

<script>
const Loader = () => import('~/Global/UI/Loader' /* webpackChunkName: "chunk-loader" */);

export default {
  components: { Loader },

  data: () => ({
    images: [],
  }),

  computed: {
    imageClasses() {
      return [
        'border',
        'border-blue-dark',
        'flex',
        'h-[97.75px]',
        'items-center',
        'justify-center',
        'rounded',
        'w-[130px]',
        'xxs:h-[112.5px]',
        'xxs-w-[150px]',
      ];
    },
  },

  methods: {
    processImages() {
      const { files } = this.$refs.fileTrigger;
      const data = new FormData();
      const mapping = [];

      for (let x = 0; x < files.length; x += 1) {
        if (!this.validateImage(files[x])) {
          coeliac().error('There was an error uploading one of your images...');

          break;
        }
        data.append(`files[${x}]`, files[x]);
        mapping.push(this.pushImage());
      }

      coeliac().request().post('/api/wheretoeat/review/image-upload', data, { 'Content-Type': 'multipart/form-data' })
        .then((response) => {
          response.data.forEach((image, index) => {
            this.displayImage(image, mapping[index]);
          });
        });
    },

    validateImage(image) {
      const validMimes = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif'];

      if (!validMimes.includes(image.type.toLowerCase())) {
        return false;
      }

      if (image.size >= 2048000) {
        return false;
      }

      return true;
    },

    pushImage() {
      const location = this.images.length;
      this.$set(this.images, location, { processing: true });

      return location;
    },

    displayImage(image, index) {
      this.$set(this.images, index, {
        processing: false,
        ...image,
      });
    },

    uploadImage() {
      this.$refs.fileTrigger.click();
    },
  },
};
</script>
