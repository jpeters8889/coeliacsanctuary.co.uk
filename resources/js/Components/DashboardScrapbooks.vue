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
                <div class="bg-blue-gradient-30 rounded p-2 flex">
                    <div class="flex-1 flex flex-col">
                        <strong class="font-semibold text-lg flex items-center">
                            <div v-if="scrapbook.id === isEditing" class="flex">
                                <form-input small name="editing-name" :value="editingName"/>
                                <a class="ml-2 flex items-center leading-none bg-yellow text-sm rounded py-1 px-3 cursor-pointer hover:bg-yellow-light transition-bg"
                                   @click="updateTitle()">
                                    Update
                                </a>
                            </div>

                            <template v-else>
                                {{ scrapbook.name }}
                                <span class="text-grey-off hover:text-grey-dark cursor-pointer text-base pl-2"
                                      v-show="isHoveringOn === scrapbook.id">
                            <font-awesome-icon :icon="['fas', 'pen']"
                                               @click.stop="editTitle(scrapbook)"></font-awesome-icon>
                        </span>
                            </template>
                        </strong>
                        <span>{{ scrapbook.items_count }} items.</span>
                    </div>
                    <div class="text-2xl text-right text-grey-off hover:text-grey-dark cursor-pointer transition-colour"
                         v-if="scrapbooks.length > 1" v-show="isHoveringOn === scrapbook.id">
                        <font-awesome-icon :icon="['far', 'trash-alt']" @click="confirmDelete = scrapbook.id"/>
                    </div>
                </div>
            </div>
        </div>

        <portal to="modal" v-if="confirmDelete">
            <modal small>
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
const Loader = () => import('./Loader' /* webpackChunkName: "chunk-loader" */)
const FormInput = () => import('./Forms/FormInput' /* webpackChunkName: "chunk-form-input" */)
const Modal = () => import('./Modal' /* webpackChunkName: "chunk-modal" */)

export default {
    components: {
        loader: Loader,
        'form-input': FormInput,
        modal: Modal,
    },

    data: () => ({
        isLoading: true,

        scrapbooks: [],

        isHoveringOn: null,
        isEditing: null,
        isAdding: false,

        editingName: '',
        addingName: '',

        confirmDelete: null,
    }),

    mounted() {
        this.loadScrapbooks();

        this.$root.$on('modal-closed', () => {
            this.confirmDelete = null;
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
        }
    }
}
</script>
