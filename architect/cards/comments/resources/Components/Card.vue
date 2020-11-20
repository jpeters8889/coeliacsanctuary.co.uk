<template>
    <div>
        <div class="flex p-2 justify-between flex-col md:flex-row" :class="!isApproved ? 'bg-negative-50' : ''">
            <div class="flex flex-col md:w-4/5">
                <div class="mb-1">
                    <h2 class="font-semibold text-blue-700 text-xl">
                        <a :href="this.data.commentable.link" target="_blank">
                            {{ commentTitle }}
                        </a>
                    </h2>
                </div>
                <div class="mb-2" v-html="data.comment"></div>
                <div><strong>{{ data.name }}</strong> - {{ data.created_at }}</div>
                <template v-if="data.reply">
                    <div class="mt-2 bg-white ml-3 border-text-blue-700 border-l-4 p-2 flex flex-col">
                        <div v-html="data.reply.comment_reply" class="mb-1"></div>
                        <div>{{ formatDate(data.reply.created_at) }}</div>
                    </div>
                </template>
            </div>
            <div class="font-semibold mt-1 flex flex-col md:w-1/5">
                <button class="button button-negative py-1 text-sm px-2 rounded mb-1"
                        @click.prevent="showDeleteModal = true">
                    Delete
                </button>
                <template v-if="!isApproved">
                    <button class="button button-primary py-1 text-sm px-2 rounded mb-1"
                            @click.prevent="showReplyModal = true">
                        Reply and Approve
                    </button>
                    <button class="button button-primary py-1 text-sm px-2 rounded mb-1"
                            @click.prevent="showApproveModal = true">
                        Approve
                    </button>
                </template>
            </div>
        </div>

        <portal to="modal" v-if="showDeleteModal">
            <modal title="Delete Comment" id="delete">
                <div class="w-full flex flex-col justify-center items-center leading-none">
                    <p class="text-xl">Are you sure you want to delete this comment?</p>
                    <div class="mt-4">
                        <button class="button button-negative button-default mr-2"
                                @click.prevent="deleteComment()">
                            Delete
                        </button>

                        <button class="button button-primary button-default"
                                @click.prevent="showDeleteModal = !showDeleteModal">
                            Cancel
                        </button>
                    </div>
                </div>
            </modal>
        </portal>

        <portal to="modal" v-if="showApproveModal">
            <modal title="Approve Comment" id="approve">
                <div class="w-full flex flex-col justify-center items-center leading-none">
                    <p class="text-xl">Are you sure you want to approve this comment?</p>
                    <div class="mt-4">
                        <button class="button button-positive button-default mr-2"
                                @click.prevent="approveComment()">
                            Approve
                        </button>

                        <button class="button button-primary button-default"
                                @click.prevent="showApproveModal = !showApproveModal">
                            Cancel
                        </button>
                    </div>
                </div>
            </modal>
        </portal>

        <portal to="modal" v-if="showReplyModal">
            <modal title="Reply to Comment" id="reply">
                <div class="w-full flex flex-col justify-center items-center leading-none">
                    <div class="bg-blue-100 p-2">
                        <strong class="text-lg text-blue-700 mb-2">Replying to {{ data.name }}</strong>
                        <p v-html="data.comment"></p>
                    </div>

                    <textarea class="my-2 form-control form-control-input w-full" rows="5"
                              v-model="replyText"></textarea>
                    <button class="button button-positive button-default" @click.prevent="replyComment()">Reply</button>
                </div>
            </modal>
        </portal>
    </div>
</template>

<script>
import moment from "moment";

export default {
    props: {
        data: Object | Array,
        labels: Object | Array,
    },

    data: () => ({
        showDeleteModal: false,
        showReplyModal: false,
        showApproveModal: false,
        replyText: '',
    }),

    computed: {
        commentTitle() {
            const area = this.data.commentable_type.split('\\').reverse()[0];

            return area + ' / ' + this.data.commentable.title;
        },

        isApproved() {
            return parseInt(this.data.approved) === 1;
        }
    },

    mounted() {
        Architect.$on('modal-close', (modal) => {
            switch (modal.id) {
                case 'delete':
                    this.showDeleteModal = false;
                    break;
                case 'reply':
                    this.showReplyModal = false;
                    break;
                case 'approve':
                    this.showApproveModal = false;
                    break;
            }
        });
    },

    methods: {
        deleteComment() {
            window.Architect.request().delete('/external/coeliac-comments/delete/' + this.data.id).then(() => {
                window.Architect.success('Comment Deleted');
                window.Architect.$emit('reload-page');
                this.showDeleteModal = false;
            });
        },

        approveComment() {
            window.Architect.request().put('/external/coeliac-comments/approve/' + this.data.id).then(() => {
                window.Architect.success('Comment Approved');
                window.Architect.$emit('reload-page');
                this.showApproveModal = false;
            });
        },

        replyComment() {
            window.Architect.request().post('/external/coeliac-comments/reply/' + this.data.id, {reply: this.replyText}).then(() => {
                window.Architect.success('Reply sent and Comment approved');
                window.Architect.$emit('reload-page');
                this.showReplyModal = false;
            });
        },

        formatDate(date) {
            return moment(date).format('DD/MM/YY HH:mm:ss');
        },
    }
}
</script>
