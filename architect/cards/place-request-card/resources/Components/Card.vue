<template>
    <div>
        <div class="flex p-2 justify-between flex-col md:flex-row" :class="!isApproved ? 'bg-red-200' : ''">
            <div class="flex flex-col md:w-4/5">
                <div v-html="data.details" class="mb-1"></div>
                <span class="italic">{{ data.name }}</span>
            </div>
            <div class="font-semibold mt-1 flex flex-col md:w-1/5">
                <div class="mb-1 flex flex-col">
                    <div v-for="info in information" class="flex flex-col leading-none mb-1">
                        <strong class="text-blue-700 font-semibold flex-1">{{ info.title}}</strong>
                        <span>{{ info.text }}</span>
                    </div>
                </div>
                <button class="button button-negative py-1 text-sm px-2 rounded mb-1"
                        @click.prevent="showDeleteModal = true">
                    Delete
                </button>
                <template v-if="!isApproved">
                    <button class="button button-primary py-1 text-sm px-2 rounded mb-1" @click.prevent="showApproveModal = true">
                        Complete
                    </button>
                </template>
            </div>
        </div>

        <portal to="modal" v-if="showDeleteModal">
            <modal title="Delete Place Request" id="delete">
                <div class="w-full flex flex-col justify-center items-center leading-none">
                    <p class="text-xl">Are you sure you want to delete this request?</p>
                    <div class="mt-4">
                        <button class="button button-negative button-default mr-2"
                                @click.prevent="deleteRequest()">
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
            <modal title="Complete Place Request" id="complete">
                <div class="w-full flex flex-col justify-center items-center leading-none">
                    <p class="text-xl">Are you sure you want to complete this request?</p>
                    <div class="mt-4">
                        <button class="button button-positive button-default mr-2"
                                @click.prevent="completeRequest()">
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
    </div>
</template>

<script>
    export default {
        props: {
            data: Object | Array,
            labels: Object | Array,
        },

        data: () => ({
            showDeleteModal: false,
            showApproveModal: false,
        }),

        computed: {
            isApproved() {
                return !! this.data.completed === true;
            },

            information() {
                return [
                    {
                        title: 'Add/Remove',
                        text: this.data.addOrRemove,
                    },
                    {
                        title: 'Created At',
                        text: this.formatDate(this.data.created_at),
                    },
                ]
            }
        },

        mounted() {
            Architect.$on('modal-close', (modal) => {
                switch (modal.id) {
                    case 'delete':
                        this.showDeleteModal = false;
                        break;
                    case 'complete':
                        this.showApproveModal = false;
                        break;
                }
            });
        },

        methods: {
            deleteRequest() {
                window.Architect.request().delete('/external/coeliac-place-request/delete/' + this.data.id).then(() => {
                    window.Architect.success('Request Deleted');
                    this.showDeleteModal = false;
                });
            },

            completeRequest() {
                window.Architect.request().put('/external/coeliac-place-request/complete/' + this.data.id).then(() => {
                    window.Architect.success('Request Completed');
                    this.showApproveModal = false;
                    this.data.completed = true;
                });
            },

            formatDate(date) {
                return moment(date).format('DD/MM/YY HH:mm:ss');
            },
        }
    }
</script>
