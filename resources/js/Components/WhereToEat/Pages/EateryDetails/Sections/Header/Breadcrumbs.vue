<template>
  <div class="flex justify-between items-center bg-grey-light p-3">
    <a
      v-if="eatery.county.id > 1"
      class="flex-1 text-xs font-semibold font-sans hover:text-blue-dark transition-all"
      :href="'/wheretoeat/'+eatery.county.slug+'/'+eatery.town.slug"
    >
      <font-awesome-icon
        :icon="['fas', 'arrow-left']"
        class="mr-2"
      />
      Back to all locations in {{ eatery.town.town }}
    </a>

    <a
      v-else-if="branch"
      class="flex-1 text-xs font-semibold font-sans hover:text-blue-dark transition-all"
      :href="'/wheretoeat/'+branch.county.slug+'/'+branch.town.slug"
    >
      <font-awesome-icon
        :icon="['fas', 'arrow-left']"
        class="mr-2"
      />
      Back to all locations in {{ branch.town.town }}
    </a>

    <a
      v-else
      class="flex-1 text-xs font-semibold font-sans hover:text-blue-dark transition-all"
      href="/wheretoeat/nationwide"
    >
      <font-awesome-icon
        :icon="['fas', 'arrow-left']"
        class="mr-2"
      />
      Back to all nationwide eateries
    </a>

    <div class="flex justify-center relative">
      <div
        class="mr-2 text-3xl text-grey cursor-pointer hover:text-social-facebook transition-all"
        @click.prevent="facebookShare()"
      >
        <font-awesome-icon :icon="['fab', 'facebook-square']" />
      </div>

      <div
        class="mr-2 text-3xl text-grey cursor-pointer hover:text-social-twitter transition-all"
        @click.prevent="twitterShare()"
      >
        <font-awesome-icon :icon="['fab', 'twitter-square']" />
      </div>

      <div
        class="mr-2 text-3xl text-grey cursor-pointer hover:text-social-pinterest transition-all"
        @click.prevent="pinterestShare()"
      >
        <font-awesome-icon :icon="['fab', 'pinterest-square']" />
      </div>

      <div
        class="text-3xl text-grey cursor-pointer hover:text-social-reddit transition-all"
        @click.prevent="redditShare()"
      >
        <font-awesome-icon :icon="['fab', 'reddit-square']" />
      </div>
    </div>
  </div>
</template>

<script>
import Shareable from '@/Mixins/Shareable';
import GoogleEvents from '@/Mixins/GoogleEvents';

export default {
  mixins: [Shareable, GoogleEvents],

  props: {
    eatery: {
      type: Object,
      required: true,
    },
    branch: {
      type: Object,
      required: false,
    },
  },
};
</script>
