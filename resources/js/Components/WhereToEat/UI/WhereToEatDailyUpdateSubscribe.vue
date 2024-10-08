<template>
  <div>
    <div class="mt-2 flex flex-col bg-yellow bg-opacity-50 border text-sm border-yellow p-2">
      <p>
        Visit <strong>{{ friendlyName }}</strong> often? Why not subscribe and get email notifications when new
        places are added to <strong>{{ friendlyName }}</strong>?
      </p>

      <button
        class="mt-2 flex items-center bg-blue-light hover:bg-opacity-80 rounded py-2 px-3 leading-none border-blue border transition-all"
        @click="toggleSubscription()"
      >
        <font-awesome-icon
          :icon="icon"
          class="text-xl"
        />
        <span
          class="text-left ml-2"
          v-html="label"
        />
      </button>
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
        <div class="flex flex-col space-y-3 p-3">
          <p>
            You must be signed in get notifications when places are added to
            <strong>{{ friendlyName }}</strong>!
          </p>
          <p>
            <a
              href="/member/register"
              class="font-semibold hover:text-blue-dark cursor-pointer"
            >
              Create an account
            </a>
          </p>
          <p>
            Already got one?
            <a
              href="/member/login"
              class="font-semibold hover:text-blue-dark cursor-pointer"
            >
              Log in now.
            </a>
          </p>
        </div>
      </modal>
    </portal>
  </div>
</template>

<script>
import SubscribesToDailyUpdates from '@/Mixins/SubscribesToDailyUpdates';

const Modal = () => import('~/Global/UI/Modal' /* webpackChunkName: "chunk-modal" */);

export default {
  components: {
    modal: Modal,
  },

  mixins: [SubscribesToDailyUpdates],

  props: {
    typeId: {
      required: true,
      type: Number,
    },
    updatableId: {
      required: true,
      type: Number,
    },
    friendlyName: {
      required: true,
      type: String,
    },
  },

  data: () => ({
    showUserCta: false,
    isSubscribed: false,
  }),

  computed: {
    label() {
      if (this.isSubscribed) {
        return `You're already subscribed to daily updates from <strong>${this.friendlyName}</strong>, unsubscribe?`;
      }

      return `Subscribe to <strong>${this.friendlyName}</strong>.`;
    },
  },

  created() {
    this.updatable = this.updatableId;
    this.type = this.typeId;
  },

  methods: {
    unsubscribeSuccess() {
      coeliac().success(`You're now unsubscribed from daily updates for places added in '${this.friendlyName}'`);
    },

    unsubscribeError() {
      coeliac().success(`Sorry, there was an error unsubscribing you from '${this.friendlyName}'.`);
    },

    subscribeSuccess() {
      coeliac().success(`You're now subscribed to getting daily updates when places are added in '${this.friendlyName}'`);
    },

    subscribeError() {
      coeliac().success(`Sorry, there was an error subscribing you from '${this.friendlyName}'.`);
    },
  },
};
</script>
