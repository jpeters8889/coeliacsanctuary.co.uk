<template>
    <div>
        <div class="pl-2 text-yellow cursor-pointer hover:text-grey-dark text-lg transition-color"
             v-tooltip.right="{content: tooltip, classes: ['bg-yellow', 'text-black', 'rounded-lg', 'text-sm', 'ml-2', 'p-2', 'max-w-250']}"
             @click="toggleSubscription()">
            <font-awesome-icon :icon="icon"></font-awesome-icon>
        </div>

        <portal to="modal" v-if="showUserCta">
            <modal small name="userCta" modal-classes="text-center text-lg">
                <p>You must be signed in to receive updates about blogs tagged with {{ tag }}!</p>
                <p>
                    <a href="/member/register" class="font-semibold hover:text-blue-dark cursor-pointer">
                        Create an account
                    </a>
                </p>
                <p>
                    Already got one?
                    <a href="/member/login" class="font-semibold hover:text-blue-dark cursor-pointer">
                        Log in now.
                    </a>
                </p>
            </modal>
        </portal>
    </div>
</template>

<script>
import InteractsWithUser from "@/Mixins/InteractsWithUser";
import Vue from "vue";
import VTooltip from "v-tooltip";
import SubscribesToDailyUpdates from "@/Mixins/SubscribesToDailyUpdates";

const Modal = () => import('~/Global/UI/Modal' /* webpackChunkName: "chunk-modal" */)

Vue.use(VTooltip);

export default {
    components: {
        modal: Modal
    },

    mixins: [InteractsWithUser, SubscribesToDailyUpdates],

    props: {
        tag: {
            required: true,
            type: String,
        },
    },

    created() {
        this.updatable = this.tag;
        this.type = 1;
    },

    methods: {
        unsubscribeSuccess() {
            coeliac().success(`You're now unsubscribed from getting notifications from blogs tagged with '${this.tag}'`);
        },

        unsubscribeError() {
            coeliac().success('Sorry, there was an error unsubscribing you from this blog tag.');
        },

        subscribeSuccess() {
            coeliac().success(`You're now subscribed to notifications new blogs tagged with '${this.tag}'`);
        },

        subscribeError() {
            coeliac().success('Sorry, there was an error subscribing you to this blog tag.');
        },
    },

    computed: {
        tooltip() {
            if (this.isSubscribed) {
                return 'Unsubscribe from daily updates on this tag.';
            }

            return `Subscribe to daily updates for new blogs tagged with ${this.tag}.`
        },
    }
}
</script>
