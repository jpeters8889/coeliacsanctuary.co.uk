<template>
    <div>
        <div class="pl-2 text-yellow cursor-pointer hover:text-grey-dark text-lg transition-color"
             v-tooltip.right="{content: tooltip, classes: ['bg-yellow', 'text-black', 'rounded-lg', 'text-sm']}"
             @click="">
            <font-awesome-icon :icon="icon"></font-awesome-icon>
        </div>
    </div>
</template>

<script>
import InteractsWithUser from "../Mixins/InteractsWithUser";
import Vue from "vue";
import VTooltip from "v-tooltip";

Vue.use(VTooltip);

export default {
    mixins: [InteractsWithUser],

    props: {
        tag: {
            required: true,
            type: String,
        },
    },

    data: () => ({
        isSubscribed: false,
    }),

    computed: {
        icon() {
            return [this.isSubscribed ? 'fas' : 'far', 'bell'];
        },

        tooltip() {
          if(this.isSubscribed) {
              return 'Unsubscribe from email notifications on this tag.';
          }

          return 'Subscribe to email notifications on this tag.'
        },
    }
}
</script>
