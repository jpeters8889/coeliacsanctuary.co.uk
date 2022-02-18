<template>
  <div v-if="links.length > 0">
    <div
      class="cursor-pointer js-mobile-nav-trigger"
      @click="showNav = true"
    >
      <font-awesome-icon :icon="['fas', 'bars']" />
    </div>

    <div
      v-show="showNav"
      class="h-screen bg-blue fixed overflow-scroll top-0 left-0 w-full h-full flex flex-col z-max js-mobile-nav"
    >
      <div
        class="p-1 flex justify-end text-3xl p-2 js-mobile-nav-close-trigger"
        @click="showNav = false"
      >
        <font-awesome-icon :icon="['fas', 'times']" />
      </div>

      <nav class="flex-1 flex items-center">
        <ul class="flex flex-col w-full">
          <li
            v-for="(link, index) in links"
            :key="index"
            class="text-center p-1"
          >
            <a
              v-if="link.link"
              :href="link.link"
              v-text="link.label"
            />

            <a
              v-if="link.callback"
              class="cursor-pointer"
              @click="link.callback()"
              v-text="link.label"
            />
          </li>
        </ul>
      </nav>
    </div>

    <portal
      v-if="showContact"
      to="modal"
    >
      <modal title="Contact Us">
        <contact-form />
      </modal>
    </portal>
  </div>
</template>

<script>
import GoogleEvents from '@/Mixins/GoogleEvents';

const ContactForm = () => import('~/Contact/Form' /* webpackChunkName: "chunk-contact-form" */);
const Modal = () => import('~/Global/UI/Modal' /* webpackChunkName: "chunk-modal" */);

export default {
  components: {
    'contact-form': ContactForm,
    modal: Modal,
  },

  mixins: [GoogleEvents],

  data() {
    return {
      showNav: false,
      showContact: false,
      links: [],
    };
  },

  watch: {
    showNav(value) {
      if (value) {
        this.googleEvent('event', 'mobile-nav', {
          event_category: 'opened-mobile-nav',
        });

        document.querySelector('body').classList.add('overflow-hidden');
        return;
      }

      document.querySelector('body').classList.remove('overflow-hidden');
    },
  },

  mounted() {
    this.$root.$on('modal-closed', () => {
      this.showContact = false;
    });

    this.links = [
      {
        label: 'Home',
        link: '/',
      },
      {
        label: 'Shop',
        link: '/shop',
      },
      {
        label: 'Gluten Free Travel Cards',
        link: '/gluten-free-travel-translation-cards',
      },
      {
        label: 'Blogs',
        link: '/blog',
      },
      {
        label: 'Eating Out',
        link: '/eating-out',
      },
      {
        label: 'Recipes',
        link: '/recipe',
      },
      {
        label: 'Collections',
        link: '/collection',
      },
      {
        label: 'Info',
        link: '/info',
      },
      {
        label: 'About Us',
        link: '/about',
      },
      {
        label: 'FAQ',
        link: '/faq',
      },
      {
        label: 'Contact',
        // eslint-disable-next-line func-names
        callback: function () {
          this.showContact = true;
          this.showNav = false;
        }.bind(this),
      },
    ];
  },
};
</script>
