<template>
    <div>
        <div class="flex p-2 justify-between flex-col md:flex-row" :class="!isApproved ? 'bg-red-200' : ''">
            <div class="flex flex-col md:w-4/5">
                <div class="mb-1">
                    <h2 class="font-semibold text-highlight text-xl">{{ this.data.eatery.full_name }}</h2>
                </div>
                <div class="mb-2" v-if="data.body">
                    <div v-html="data.body"></div>
                    <span class="font-semibold">{{ data.name }}</span>
                </div>
                <div v-else>
                    <em>No rating text...</em>
                </div>
            </div>
            <div class="font-semibold mt-1 flex flex-col md:w-1/5">
                <div class="mb-1 flex flex-col">
                    <div v-for="info in information" class="flex leading-none mb-1">
                        <strong class="text-blue-500 font-semibold flex-1">{{ info.title}}</strong>
                        <span>{{ info.text }}</span>
                    </div>
                </div>
                <button class="button button-negative py-1 text-sm px-2 rounded mb-1"
                        @click.prevent="showDeleteModal = true">
                    Delete
                </button>
                <template v-if="!isApproved">
                    <button class="button button-primary py-1 text-sm px-2 rounded mb-1" @click.prevent="showApproveModal = true">
                        Approve
                    </button>
                </template>
            </div>
        </div>

        <portal to="modal" v-if="showDeleteModal">
            <modal title="Delete Rating" id="delete">
                <div class="w-full flex flex-col justify-center items-center leading-none">
                    <p class="text-xl">Are you sure you want to delete this rating?</p>
                    <div class="mt-4">
                        <button class="button button-negative button-default mr-2"
                                @click.prevent="deleteRating()">
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
            <modal title="Approve Rating" id="approve">
                <div class="w-full flex flex-col justify-center items-center leading-none">
                    <p class="text-xl">Are you sure you want to approve this rating?</p>
                    <div class="mt-4">
                        <button class="button button-positive button-default mr-2"
                                @click.prevent="approveRating()">
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

        mounted() {
            Architect.$on('modal-close', (modal) => {
                switch (modal.id) {
                    case 'delete':
                        this.showDeleteModal = false;
                        break;
                    case 'approve':
                        this.showApproveModal = false;
                        break;
                }
            });
        },

        computed: {
            isApproved() {
                return !! this.data.approved === true;
            },

            information() {
                return [
                    {
                        title: 'Rating',
                        text: this.data.rating,
                    },
                    {
                        title: 'Average Rating',
                        text: this.data.average_rating + ' ('+this.data.number_of_ratings+')',
                    },
                    {
                        title: 'Method',
                        text: this.data.method,
                    }
                ]
            }
        },

        methods: {
            deleteRating() {
                window.Architect.request().delete('/external/coeliac-wte-ratings/delete/' + this.data.id).then(() => {
                    window.Architect.success('Rating Deleted');
                    window.Architect.$emit('reload-page');
                });
            },

            approveRating() {
                window.Architect.request().put('/external/coeliac-wte-ratings/approve/' + this.data.id).then(() => {
                    window.Architect.success('Rating Approved');
                    window.Architect.$emit('reload-page');
                });
            },
        }
    }
</script>
