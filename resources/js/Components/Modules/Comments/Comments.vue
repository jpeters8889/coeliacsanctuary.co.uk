<template>
    <div id="comments-wrapper">
        <div v-if="!loaded" class="relative h-32">
            <loader :show="true"></loader>
        </div>

        <div v-else>
            <div v-if="data.length === 0" class="mb-3">
                <strong class="font-semibold">There's no comments on this {{ area }}, why not leave one?</strong>
            </div>

            <div v-else>
                <div v-for="comment in data">
                    <div class="flex flex-col bg-blue-gradient-30 p-3 border-l-8 border-yellow shadow mb-3">
                        <div class="mb-2" v-html="comment.comment"></div>
                        <div class="flex text-xs font-medium text-grey">
                            <div class="mr-2">{{ comment.name }}</div>
                            <div>{{ formatDate(comment.created_at) }}</div>
                        </div>

                        <div class="flex mt-2 flex-col mt-3 bg-white-80 p-3" v-if="comment.reply">
                            <strong>Alison @ Coeliac Sanctuary replied to this comment
                                on {{ formatDate(comment.reply.created_at) }}</strong>
                            <p v-html="comment.reply.comment_reply"></p>
                        </div>
                    </div>
                </div>

                <div v-if="hasMore" @click="nextPage()"
                     class="my-2 bg-blue-gradient-20 p-1 shadow border border-blue text-center text-lg hover:bg-blue-gradient-10 cursor-pointer">
                    Load More Comments
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import FormatsDates from "@/Mixins/FormatsDates";

const Loader = () => import('~/Global/UI/Loader' /* webpackChunkName: "chunk-loader" */)

export default {
    mixins: [
        FormatsDates
    ],

    components: {
        loader: Loader,
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
        initial: false,
        loaded: false,
        data: [],
        currentPage: 1,
        hasMore: false,
    }),

    mounted() {
        this.data = [];
        this.currentPage = 1;
        this.hasMore = false;

        new IntersectionObserver(entries => {
            if (this.initial) {
                return;
            }

            if (entries[0].intersectionRatio > 0) {
                this.initial = true;
                this.getData();
            }
        }).observe(document.querySelector('#comments-wrapper'));
    },

    methods: {
        getData() {
            coeliac().request().get(`/api/comments/${this.area}/${this.id}?page=${this.currentPage}`)
                .then((response) => {
                    this.hasMore = this.currentPage !== response.data.last_page;
                    this.data.push(...response.data.data);
                })
                .catch((err) => {
                    //
                })
                .finally(() => this.loaded = true);
        },

        nextPage() {
            this.currentPage++;

            this.getData();
        }
    }
}
</script>
