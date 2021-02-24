<template>
    <div>
        <div class="mr-2 text-3xl text-grey cursor-pointer hover:text-yellow transition-color"
             v-tooltip.top="{content: tooltip, classes: ['bg-yellow', 'text-black', 'rounded-lg', 'text-sm']}"
             @click="toggleScrapbook()">
            <font-awesome-icon :icon="icon"></font-awesome-icon>
        </div>

        <portal to="modal" v-if="showUserCta">
            <modal small name="userCta" modal-classes="text-center text-lg">
                <p>You must be signed in to add this {{ area }} to your scrapbook.</p>
                <p>
                    <a href="/member/register" class="font-semibold hover:text-blue-dark cursor-pointer">Create an account</a>
                </p>
                <p>
                    Already got one? <a href="/member/login" class="font-semibold hover:text-blue-dark cursor-pointer">Log in now.</a>
                </p>
            </modal>
        </portal>
    </div>
</template>

<script>
import Vue from "vue";
import VTooltip from "v-tooltip";
import InteractsWithUser from "../Mixins/InteractsWithUser";

const Modal = () => import('./Modal' /* webpackChunkName: "chunk-modal" */)

Vue.use(VTooltip);

export default {
    mixins: [InteractsWithUser],

    components: {
        modal: Modal,
    },

    props: {
        area: {
            type: String,
            required: true,
        },
        id: {
            type: Number,
            required: true,
        }
    },

    data: () => ({
        showUserCta: false,

        isInScrapbook: false,

        scrapbooks: [],
    }),

    mounted() {
        this.getScrapbooks();
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

        toggleScrapbook() {
            if (!this.isLoggedIn()) {


                return;
            }
        }
    },

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
        }
    }
}
</script>
