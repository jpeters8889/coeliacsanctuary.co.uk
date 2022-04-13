<template>
  <div>
    <div
      id="breadcrumb"
      class="my-2 border-grey-off border bg-grey-off-light p-2 leading-none z-10"
      :class="sticky ? 'fixed top-[45px] slide-down w-full mt-1' : ''"
    >
      <div
        class="leading-none inner-wrapper flex flex-col md:flex-row md:items-center"
        :style="sticky ? 'max-width: 1500px;' : ''"
      >
        <div
          class="flex-wrap flex-1 flex my-1 items-center justify-center space-x-1 leading-relaxed md:justify-start"
        >
          <div
            v-for="(crumb, index) in crumbs"
            :key="index"
            class="text-grey-dark font-semibold flex space-x-1 justify-start items-center"
          >
            <a
              :href="crumb.link"
              class="hover:underline flex-shrink-0"
            >
              {{ crumb.title }}
            </a>
            <font-awesome-icon
              :class="index === crumbs.length - 1 ? 'hidden xs:block' : ''"
              class="text-left"
              :icon="['fas', 'angle-double-right']"
            />
          </div>
          <div
            :class="'hidden xs:block'"
            class="font-medium"
          >
            {{ location }}
          </div>
        </div>

        <!-- Share Icons -->
        <div class="flex justify-center relative">
          <add-to-scrapbook
            v-if="scrapable"
            :id="scrapable.id"
            :area="scrapable.area"
          />

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
    </div>
    <div id="breadcrumb-check" />
  </div>
</template>

<script>
import GoogleEvents from '@/Mixins/GoogleEvents';
import Shareable from '@/Mixins/Shareable';

const AddScrapbook = () => import('~/Global/UI/AddScrapbook' /* webpackChunkName: "chunk-add-scrapbook" */);

export default {

  components: {
    'add-to-scrapbook': AddScrapbook,
  },
  mixins: [GoogleEvents, Shareable],

  props: {
    location: {
      required: true,
      type: String,
    },
    crumbs: {
      required: true,
      type: Array,
    },
    scrapable: {
      required: false,
      type: [Boolean, Object],
      default: false,
    },
  },

  data: () => ({
    sticky: false,
  }),

  mounted() {
    new IntersectionObserver((entries) => {
      this.sticky = entries[0].intersectionRatio === 0;
    }).observe(document.querySelector('#breadcrumb-check'));
  },
};
</script>
