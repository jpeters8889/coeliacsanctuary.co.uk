<template>
  <div
    v-if="eatery.userImages.length > 0"
    class="page-box flex flex-col space-y-3"
  >
    <p>
      Here are some photos taken at <strong>{{ eatery.name }}</strong> that other visitors have submitted!
    </p>

    <image-gallery
      :images="eatery.userImages"
      :alt-text="`Photo of ${eatery.name}`"
    />
  </div>
</template>

<script>
import ImageGallery from '~/WhereToEat/Pages/EateryDetails/Sections/Shared/ImageGallery';

export default {
  components: { ImageGallery },
  props: {
    eatery: {
      type: Object,
      required: true,
    },
  },
};
</script>
