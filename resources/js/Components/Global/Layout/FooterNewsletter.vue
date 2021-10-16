<template>
  <div class="w-full flex flex-col justify-center sm:flex-row">
    <input
      v-model="email"
      class="flex-1 leading-none mb-2 rounded border border-grey-lightest p-1 sm:mr-2 sm:py-2"
      type="email"
      placeholder="Enter your email address..."
    >
    <div class="text-center">
      <button
        class="bg-yellow leading-none py-2 px-4 rounded-lg sm:border-t sm:border-yellow sm:leading-tight"
        @click="submit()"
      >
        Subscribe!
      </button>
    </div>
  </div>
</template>

<script>
import SubscribesToNewsletter from '@/Mixins/SubscribesToNewsletter';

export default {
  mixins: [SubscribesToNewsletter],
};
</script>
