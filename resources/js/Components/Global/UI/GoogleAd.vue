<template>
  <div
    v-if="hasGoogle"
    class="w-full my-2 flex text-center"
  >
    <ins
      class="adsbygoogle"
      style="display: block; width: 100%;"
      :style="additionalStyles"
      data-ad-client="ca-pub-1063051842575021"
      :data-ad-slot="code"
      :data-ad-format="adFormat"
      data-full-width-responsive="true"
    />
  </div>
</template>

<script>
export default {
  props: {
    code: {
      type: String,
      required: true,
    },
    adFormat: {
      type: String,
      default: 'auto',
    },
    additionalStyles: {
      type: String,
      default: '',
    }
  },

  computed: {
    hasGoogle() {
      return !!window.adsbygoogle;
    },
  },

  mounted() {
    if (!this.hasGoogle) {
      return;
    }

    (adsbygoogle = window.adsbygoogle || []).push({});
  },
};
</script>
