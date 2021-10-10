<template>
  <div class="flex flex-col">
    <p class="text-sm leading-tight mb-2">
      Enter your email address below to get our newsletter sent straight to your inbox!
    </p>

    <div class="w-full flex flex-row justify-center text-sm leading-none">
      <input
        v-model="email"
        class="bg-grey-lightest border border-grey-off flex-1 rounded p-1 mr-1"
        type="email"
        placeholder="Enter your email address..."
      >
      <div class="text-center">
        <button
          class="bg-blue text-grey-lightest leading-none px-1 py-2 border border-blue rounded"
          @click="submit()"
        >
          Subscribe!
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import SubscribesToNewsletter from '@/Mixins/SubscribesToNewsletter';

export default {
  mixins: [SubscribesToNewsletter],

  props: {
    showAd: {
      type: Boolean,
      default: true,
    },
  },
};
</script>
