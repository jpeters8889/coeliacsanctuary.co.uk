<template>
  <div>
    <div
      v-tooltip.top="{content: tooltip, classes: ['bg-yellow', 'text-black', 'rounded-lg', 'text-sm']}"
      class="mr-2 text-3xl text-grey cursor-pointer hover:text-yellow transition-color"
      @click="toggleScrapbook()"
    >
      <font-awesome-icon :icon="icon" />
    </div>

    <div v-if="showSelectScrapbook">
      <div
        class="fixed top-0 left-0 bg-black bg-opacity-20 w-screen h-screen z-max"
        @click="showSelectScrapbook = false"
        @keypress.escape="showSelectScrapbook = false"
      />

      <div class="absolute w-full bg-white left-0 right-0 shadow-xl rounded z-max mt-2">
        <ul>
          <li
            v-for="scrapbook in scrapbooks"
            :key="scrapbook.id"
            class="py-3 text-center text-lg border-b border-grey-off last:border-0 hover:bg-grey-off-light cursor-pointer transition-all"
            @click="addToScrapbook(scrapbook.id)"
          >
            {{ scrapbook.name }}
          </li>
        </ul>
      </div>
    </div>

    <portal
      v-if="showUserCta"
      to="modal"
    >
      <modal
        small
        name="userCta"
        modal-classes="text-center text-lg"
        title="Ooops!"
      >
        <div class="p-3 flex flex-col space-y-3 leading-tight">
          <p>You must be signed in to add this {{ area }} to your scrapbook.</p>
          <p>
            <a
              href="/member/register"
              class="font-semibold hover:text-blue-dark cursor-pointer"
            >Create an
              account</a>
          </p>
          <p>
            Already got one? <a
              href="/member/login"
              class="font-semibold hover:text-blue-dark cursor-pointer"
            >Log
              in now.</a>
          </p>
        </div>
      </modal>
    </portal>
  </div>
</template>

<script>
import Vue from 'vue';
import { VTooltip } from 'v-tooltip';
import InteractsWithUser from '@/Mixins/InteractsWithUser';

const Modal = () => import('~/Global/UI/Modal' /* webpackChunkName: "chunk-modal" */);

Vue.directive('tooltip', VTooltip);

export default {

  components: {
    modal: Modal,
  },
  mixins: [InteractsWithUser],

  props: {
    area: {
      type: String,
      required: true,
    },
    id: {
      type: Number,
      required: true,
    },
  },

  data: () => ({
    showUserCta: false,
    showSelectScrapbook: false,

    isInScrapbook: false,

    scrapbooks: [],
  }),

  computed: {
    icon() {
      if (this.isInScrapbook) {
        return ['fas', 'bookmark'];
      }

      return ['far', 'bookmark'];
    },

    tooltip() {
      if (this.isInScrapbook) {
        return 'Remove from Scrapbook';
      }

      return 'Add to Scrapbook';
    },
  },

  mounted() {
    this.getScrapbooks();
    this.seeIfInScrapbook();

    this.$root.$on('modal-closed', (name) => {
      if (name === 'userCta') {
        this.showUserCta = false;
      }
    });
  },

  methods: {
    getScrapbooks() {
      this.scrapbooks = [];

      if (!this.isLoggedIn()) {
        return;
      }

      coeliac().request().get('/api/member/dashboard/scrapbooks')
        .then((response) => {
          this.scrapbooks = response.data;
        })
        .catch(() => {
          //
        });
    },

    seeIfInScrapbook() {
      if (!this.isLoggedIn()) {
        return;
      }

      coeliac().request().post('/api/member/dashboard/scrapbooks/search', {
        area: this.area,
        id: this.id,
      })
        .then((response) => {
          if (response.status === 200) {
            this.isInScrapbook = response.data;
            return;
          }

          this.isInScrapbook = false;
        })
        .catch(() => {
          //
        });
    },

    toggleScrapbook() {
      if (!this.isLoggedIn()) {
        this.showUserCta = true;
        return;
      }

      if (this.isInScrapbook) {
        this.deleteFromScrapbook();

        return;
      }

      if (this.scrapbooks.length === 1) {
        this.addToScrapbook();
        return;
      }

      this.showSelectScrapbook = true;
    },

    deleteFromScrapbook() {
      coeliac().request().delete(`/api/member/dashboard/scrapbooks/${this.isInScrapbook.scrapbook_id}/${this.isInScrapbook.id}`)
        .then(() => {
          coeliac().success(`This ${this.area} has been removed to your scrapbook!`);
          this.isInScrapbook = false;
        })
        .catch(() => {
          coeliac().error(`There was an error removing this ${this.area} from your scrapbook`);
        });
    },

    addToScrapbook(id = null) {
      if (!id) {
        // eslint-disable-next-line prefer-destructuring
        id = this.scrapbooks[0].id;
      }

      coeliac().request().post(`/api/member/dashboard/scrapbooks/${id}`, {
        type: this.area,
        id: this.id,
      })
        .then(() => {
          coeliac().success(`This ${this.area} has been added to your scrapbook!`);
          this.seeIfInScrapbook();
        })
        .catch(() => {
          coeliac().error(`There was an error adding this ${this.area} to your scrapbook`);
        })
        .finally(() => {
          this.showSelectScrapbook = false;
        });
    },
  },
};
</script>
