<template>
    <div>
        <div v-if="isLoading" class="relative w-full h-32">
            <loader :show="true"></loader>
        </div>

        <div v-else class="mt-2 flex flex-col space-y-2 sm:flex-wrap sm:flex-row justify-between sm:-mx-1">
            <div class="bg-blue-gradient-30 rounded p-2 flex flex-col w-full sm:mx-1">
                <strong class="block font-semibold text-lg flex items-center cursor-pointer hover:underline"
                        @click="triggerAddScrapbook()">
                    Create new Scrapbook
                </strong>

                <div class="flex" v-if="isAdding">
                    <form-input class="flex-1" small name="add-name" :value="addingName" placeholder="Scrapbook Name"/>
                    <a class="ml-2 flex items-center leading-none bg-yellow text-sm rounded py-1 px-3 cursor-pointer hover:bg-yellow-light transition-bg"
                       @click="addScrapbook()">
                        Add
                    </a>
                </div>
            </div>

            <div v-for="scrapbook in scrapbooks" @mouseenter="isHoveringOn = scrapbook.id"
                 @mouseleave="isHoveringOn = null" class="sm:w-1/2 sm:px-1">
                <div class="bg-blue-gradient-30 rounded p-2 flex" @click.stop.exact="viewScrapbook = scrapbook">
                    <div class="flex-1 flex flex-col">
                        <strong class="font-semibold text-lg flex items-center">
                            <div v-if="scrapbook.id === isEditing" class="flex">
                                <form-input small name="editing-name" :value="editingName"/>
                                <a class="ml-2 flex items-center leading-none bg-yellow text-sm rounded py-1 px-3 cursor-pointer hover:bg-yellow-light transition-bg"
                                   @click.stop.exact="updateTitle()">
                                    Update
                                </a>
                            </div>

                            <template v-else>
                                {{ scrapbook.name }}
                                <span class="text-grey-off hover:text-grey-dark cursor-pointer text-base pl-2"
                                      v-show="isHoveringOn === scrapbook.id">
                            <font-awesome-icon :icon="['fas', 'pen']"
                                               @click.stop.exact="editTitle(scrapbook)"></font-awesome-icon>
                        </span>
                            </template>
                        </strong>
                        <span>{{ scrapbook.items_count }} items.</span>
                    </div>
                    <div class="text-2xl text-right text-grey-off hover:text-grey-dark cursor-pointer transition-colour"
                         v-if="scrapbooks.length > 1" v-show="isHoveringOn === scrapbook.id">
                        <font-awesome-icon :icon="['far', 'trash-alt']" @click.stop.exact="confirmDelete = scrapbook.id"/>
                    </div>
                </div>
            </div>
        </div>

        <portal to="modal" v-if="viewScrapbook">
            <modal modal-classes="w-full" name="view-scrapbook">
                <h2 class="text-xl font-semibold text-center mb-2">
                    {{ viewScrapbook.name }}
                </h2>

                <div class="w-full min-h-map">
                    <loader v-if="scrapbookItems.length === 0" :show="true"></loader>

                    <div v-else class="flex flex-col space-y-4">
                        <div v-for="item in scrapbookItems" class="flex flex-col bg-blue-gradient-50 rounded-lg md:flex-row" :key="item.id">
                            <a :href="item.item.link" target="_blank" class="md:w-1/3 md:p-1">
                                <img :src="item.item.image" :alt="item.item.title" class="rounded-t-lg md:rounded-lg"/>
                            </a>

                            <div class="p-2 flex-1 md:p-1">
                                <a :href="item.item.link" target="_blank">
                                    <h2 class="text-lg font-semibold hover:text-blue-dark transition-colour md:leading-none">
                                        {{ item.item.area }} - {{ item.item.title }}
                                    </h2>
                                </a>

                                <p v-html="item.item.description"></p>

                                <div class="mt-2 flex justify-between text-sm">
                                    <p>
                                        Added {{ formatDate(item.added) }}
                                    </p>

                                    <a class="font-semibold hover:text-blue-dark transition-bg cursor-pointer" @click="removeItem(item.id)">
                                        Remove
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </modal>
        </portal>

        <portal to="modal" v-if="confirmDelete">
            <modal small name="delete-scrapbook">
                <p>Are you sure you want to delete this scrapbook? Any items saved will be lost.</p>
                <div class="flex space-x-4 justify-center mt-2">
                    <a class="rounded leading-none px-4 py-2 bg-blue hover:bg-blue-light hover:shadow cursor-pointer"
                       @click="confirmDelete = null">
                        No
                    </a>

                    <a class="rounded leading-none px-4 py-2 bg-yellow hover:bg-yellow-light hover:shadow cursor-pointer"
                       @click="deleteScrapbook()">
                        Yes
                    </a>
                </div>
            </modal>
        </portal>
    </div>
</template>

<script>
import FormatsDates from "../Mixins/FormatsDates";

const Loader = () => import('./Loader' /* webpackChunkName: "chunk-loader" */)
const FormInput = () => import('./Forms/FormInput' /* webpackChunkName: "chunk-form-input" */)
const Modal = () => import('./Modal' /* webpackChunkName: "chunk-modal" */)

export default {
    mixins: [FormatsDates],

    components: {
        loader: Loader,
        'form-input': FormInput,
        modal: Modal,
    },

    data: () => ({
        isLoading: true,

        scrapbooks: [],
        scrapbookItems: [],

        viewScrapbook: null,
        isHoveringOn: null,
        isEditing: null,
        isAdding: false,

        editingName: '',
        addingName: '',

        confirmDelete: null,
    }),

    mounted() {
        this.loadScrapbooks();

        this.$root.$on('modal-closed', (name) => {
            if (name === 'delete-scrapbook') {
                this.confirmDelete = null;
            }

            if (name === 'view-scrapbook') {
                this.viewScrapbook = null;
                this.loadScrapbooks();
            }
        });
    },

    methods: {
        loadScrapbooks() {
            coeliac().request().get('/api/member/dashboard/scrapbooks')
                .then((response) => {
                    this.scrapbooks = response.data;
                })
                .catch(() => {
                    //
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },

        triggerAddScrapbook() {
            this.isAdding = true;

            this.$root.$on(`add-name-change`, (value) => {
                this.addingName = value;
            });
        },

        addScrapbook() {
            if (this.addingName === '') {
                coeliac().error('Please enter a name for your new scrapbook');
                return;
            }

            coeliac().request()
                .post('/api/member/dashboard/scrapbooks', {
                    name: this.addingName
                })
                .then(() => {
                    this.loadScrapbooks();
                    coeliac().success('Scrapbook Updated');
                })
                .catch(() => {
                    coeliac().error('There was an error adding your scrapbook');
                })
                .finally(() => {
                    this.isAdding = false;
                    this.addingName = '';
                })
        },

        editTitle(scrapbook) {
            this.editingName = scrapbook.name;
            this.isEditing = scrapbook.id;

            coeliac().$emit(`editing-name-set-value`, (this.editingName));

            this.$root.$on(`editing-name-change`, (value) => {
                this.editingName = value;
            });
        },

        updateTitle() {
            if (!this.isEditing) {
                return;
            }

            if (this.editingName === '') {
                this.isEditing = null;
                this.editingName = null;

                return;
            }

            this.isLoading = true;

            coeliac()
                .request()
                .patch(`/api/member/dashboard/scrapbooks/${this.isEditing}`, {
                    name: this.editingName
                })
                .then(() => {
                    this.loadScrapbooks();
                    coeliac().success('Scrapbook Updated');
                })
                .catch(() => {
                    coeliac().error('There was an error updating your scrapbook');
                })
                .finally(() => {
                    this.isEditing = null;
                    this.editingName = null;
                });
        },

        deleteScrapbook() {
            coeliac()
                .request()
                .delete(`/api/member/dashboard/scrapbooks/${this.confirmDelete}`)
                .then(() => {
                    this.loadScrapbooks();
                    coeliac().success('Scrapbook Deleted');
                })
                .catch(() => {
                    coeliac().error('There was an error removing your scrapbook');
                })
                .finally(() => {
                    this.confirmDelete = null;
                });
        },

        getScrapbookItems() {
            coeliac().request().get(`/api/member/dashboard/scrapbooks/${this.viewScrapbook.id}`)
                .then((response) => {
                    this.scrapbookItems = response.data;
                })
                .catch(() => {
                    coeliac().error('There was an error opening this scrapbook');
                    this.viewScrapbook = null;
                })
        },

        removeItem(id) {
            coeliac().request().delete(`/api/member/dashboard/scrapbooks/${this.viewScrapbook.id}/${id}`)
                .then(() => {
                    this.getScrapbookItems();
                })
                .catch(() => {
                    coeliac().error(`There was an error removing this item from your scrapbook`);
                });
        }
    },

    watch: {
        viewScrapbook: function () {
            if (!this.viewScrapbook) {
                this.scrapbookItems = []
                return;
            }

            this.getScrapbookItems();
        }
    }
}
</script>
