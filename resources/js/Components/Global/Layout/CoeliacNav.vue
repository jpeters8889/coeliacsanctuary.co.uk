<template>
  <nav class="text-lg text-black h-full leading-loose w-full js-primary-nav z-50">
    <ul class="flex relative z-50">
      <li
        v-for="(item, index) in navigation"
        :key="index"
        class="border-b-4 border-transparent hover:border-white hover:border-opacity-80 cursor:pointer z-max"
        @mouseenter="hover(item.label)"
        @mouseleave="leave()"
      >
        <a
          class="py-2 px-4"
          :href="item.link"
        >
          {{ item.label }}
        </a>
        <transition
          enter-active-class="duration-300 ease-out"
          enter-class="opacity-0"
          enter-to-class="opacity-1"
          leave-active-class="duration-100 ease-in"
          leave-class="opacity-1"
          leave-to-class="opacity-0"
          @enter="() => $root.$emit('has-entered')"
        >
          <template v-if="item.children">
            <div
              v-show="hoveringOn === item.label"
              class="transition-all transform absolute z-max bg-grey-lightest p-2 w-full left-0 shadow-2xl mt-4px"
            >
              <transition
                enter-active-class="duration-300 ease-out"
                enter-class="scale-75 opacity-0"
                enter-to-class="scale-1 opacity-1"
                leave-active-class="duration-100 ease-in"
                leave-class="scale-1 opacity-1"
                leave-to-class="scale-75 opacity-0"
                @enter="loadLazyImages"
              >
                <template v-if="hasEntered">
                  <div
                    class="transition-all transform"
                  >
                    <template v-if="item.children.layout === '3x5' || item.children.layout === '3'">
                      <div class="flex">
                        <ul class="w-3/5">
                          <template v-for="(child, x) in item.children.items">
                            <template v-if="x < 3">
                              <li
                                :key="x"
                                class="py-2 mr-4 transition-all hover:bg-yellow hover:bg-opacity-40"
                                :class="x < 2 ? 'border-b border-yellow ' : ''"
                              >
                                <a
                                  v-if="x < 3"
                                  :href="child.link"
                                  class="flex"
                                >
                                  <div class="w-1/4 mr-1 lg:w-1/6">
                                    <img
                                      :data-src="child.main_image"
                                      :src="lazyLoadSrc"
                                      loading="lazy"
                                      class="lazy"
                                      :alt="child.title"
                                    >
                                  </div>
                                  <div class="leading-none flex-1">
                                    <h3 class="mb-1 font-medium">{{ child.title }}</h3>
                                    <p class="text-sm">{{ child.meta_description }}</p>
                                  </div>
                                </a>
                              </li>
                            </template>
                          </template>
                        </ul>

                        <template v-if="item.children.layout === '3x5'">
                          <ul class="w-2/5 text-base leading-none flex flex-col py-2">
                            <li
                              v-for="(child, x) in item.children.items"
                              :key="x"
                              class="mb-3"
                              :class="x === (item.children.items.length - 1) ? 'flex-1' : ''"
                            >
                              <template v-if="x >= 3">
                                <a :href="item.link + '/' + child.slug">
                                  {{ child.title }}
                                </a>
                              </template>
                            </li>
                            <li>
                              <global-ui-link-button
                                :href="item.link"
                                rounded
                              >
                                See All {{
                                  item.label
                                }}
                              </global-ui-link-button>
                            </li>
                          </ul>
                        </template>
                      </div>
                    </template>

                    <template v-if="item.children.layout === '4'">
                      <div class="flex">
                        <ul class="w-3/5">
                          <li
                            v-for="(child, x) in item.children.items"
                            :key="x"
                            class="py-2 mr-4 hover:bg-yellow hover:bg-opacity-40 transition-all"
                            :class="x < 3 ? 'border-b border-yellow' : ''"
                          >
                            <a
                              :href="child.link"
                              class="flex"
                            >
                              <div class="w-1/4 mr-1 lg:w-1/6">
                                <img
                                  :data-src="child.main_image"
                                  :src="lazyLoadSrc"
                                  loading="lazy"
                                  class="lazy"
                                  :alt="child.title"
                                >
                              </div>
                              <div class="leading-none flex-1">
                                <h3 class="mb-1 font-medium">{{ child.title }}</h3>
                                <p class="text-sm">{{ child.meta_description }}</p>
                              </div>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </template>

                    <template v-if="item.children.layout === 'list'">
                      <ul class="flex flex-wrap text-base leading-none py-2">
                        <li
                          v-for="(child, x) in item.children.items"
                          :key="x"
                          class="w-1/2 mb-2 hover:underline"
                        >
                          <template v-if="child.label && child.link">
                            <a
                              :href="child.link"
                              class="block w-full"
                            >
                              {{ child.label }}
                            </a>
                          </template>
                          <template v-if="child.component">
                            <component
                              :is="child.component"
                              class="block w-full cursor-pointer"
                            >
                              {{ child.label }}
                            </component>
                          </template>
                        </li>
                      </ul>
                    </template>
                  </div>
                </template>
              </transition>
            </div>
          </template>
        </transition>
      </li>
    </ul>
  </nav>
</template>

<script>
import LazyLoadsImages from '@/Mixins/LazyLoadsImages';

export default {
  mixins: [LazyLoadsImages],

  data: () => ({
    hoveringOn: '',
    hasEntered: false,
    navigation: {
      home: {
        label: 'Home',
        link: '/',
        children: null,
      },
      shop: {
        label: 'Shop',
        link: '/shop',
        children: null,
      },
      blogs: {
        label: 'Blogs',
        link: '/blog',
        children: null,
      },
      eatingOut: {
        label: 'Eating Out',
        link: '/eating-out',
        children: null,
      },
      recipes: {
        label: 'Recipes',
        link: '/recipe',
        children: null,
      },
      collections: {
        label: 'Collections',
        link: '/collection',
        children: null,
      },
      info: {
        label: 'Info',
        link: '/info',
        children: null,
      },
    },

    timeoutEnter: undefined,
    timeoutLeave: undefined,
  }),

  mounted() {
    coeliac().request().get('/api/navigation').then((response) => {
      Object.keys(response.data).forEach((key) => {
        if (this.navigation[key]) {
          this.navigation[key].children = response.data[key];
        }
      });

      if (this.navigation.collections.children === null || this.navigation.collections.children.items.length === 0) {
        this.$root.$delete(this.navigation, 'collections');
      }

      this.loadLazyImages();
    });

    this.$root.$on('has-entered', () => {
      this.hasEntered = true;
    });
  },

  methods: {
    hover(on) {
      clearTimeout(this.timeoutEnter);
      clearTimeout(this.timeoutLeave);

      // this.timeoutEnter = setTimeout(() => {
      this.hoveringOn = on;
      // }, 200)
    },

    leave() {
      clearTimeout(this.timeoutEnter);
      clearTimeout(this.timeoutLeave);

      this.timeoutLeave = setTimeout(() => {
        this.hoveringOn = null;
        this.hasEntered = false;
      }, 200);
    },
  },
};
</script>
