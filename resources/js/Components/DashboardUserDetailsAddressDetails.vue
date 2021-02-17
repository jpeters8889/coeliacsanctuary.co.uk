<template>
    <div class="bg-blue-gradient-30 p-2 mt-2 rounded-lg">
        <h2 class="text-lg text-blue-dark font-semibold">Your Addresses</h2>

        <p class="text-sm">
            Here you can manage your saved addresses from our online shop.
        </p>

        <div class="flex flex-col space-y-2">
            <div v-for="address in addresses" class="flex flex-col p-2 bg-white-50 rounded">
                <strong>{{ address.name }}</strong>
                <span>{{ formatAddress(address) }}</span>

                <div class="flex justify-between mt-2">
                    <div class="flex">
                        <strong class="mr-1">Address Type:</strong>
                        <span>{{ address.type }}</span>
                    </div>
                    <div class="flex space-x-2">
                        <font-awesome-icon class="cursor-pointer" :icon="['fas', 'pen']" @click="openEditModal(address)"
                                           v-tooltip.left="{content: 'Edit', classes: ['bg-blue', 'border-blue', 'text-white']}"/>
                        <font-awesome-icon class="cursor-pointer" :icon="['far', 'trash-alt']" @click="openDeleteModal(address)"
                                           v-tooltip.left="{content: 'Delete', classes: ['bg-blue', 'border-blue', 'text-white']}"/>
                    </div>
                </div>
            </div>
        </div>

        <portal to="modal" v-if="showEditAddressModal">
            <modal name="edit-address">

            </modal>
        </portal>

        <portal to="modal" v-if="showDeleteAddressModal">
            <modal name="delete-address">
                <h3>Are you sure you want to delete this address?</h3>
                <div class="flex space-x-4 justify-center mt-2">
                    <a class="rounded leading-none px-4 py-2 bg-blue hover:bg-blue-light hover:shadow cursor-pointer" @click="closeDeleteModal">
                        No
                    </a>

                    <a class="rounded leading-none px-4 py-2 bg-yellow hover:bg-yellow-light hover:shadow cursor-pointer">
                        Yes
                    </a>
                </div>
            </modal>
        </portal>
    </div>
</template>

<script>
const FormInput = () => import('./Forms/FormInput' /* webpackChunkName: "chunk-form-input" */)
const Loader = () => import('./Loader' /* webpackChunkName: "chunk-loader" */)
const Modal = () => import('./Modal' /* webpackChunkName: "chunk-modal" */)

export default {
    components: {
        'form-input': FormInput,
        'loader': Loader,
        'modal': Modal,
    },

    data: () => ({
        addresses: [],

        showEditAddressModal: false,
        showDeleteAddressModal: false,

        editingAddress: {},
        deletingAddress: {},
    }),

    mounted() {
        this.loadAddresses();

        this.$root.$on('modal-closed', (name) => {
            if (name === 'edit-address') {
                this.closeEditModal();
            }

            if (name === 'delete-address') {
                this.closeDeleteModal();
            }
        });
    },

    methods: {
        formatAddress(address) {
            return Array.from(['line_1', 'line_2', 'line_3', 'town', 'postcode', 'country'].map(key => address[key]))
                .filter(value => value !== null && value !== '')
                .join(', ');
        },

        loadAddresses() {
            coeliac().request().get('/api/member/addresses')
                .then((response) => {
                    this.addresses = response.data;
                })
                .catch(() => {
                    this.addresses = [];
                });
        },

        openEditModal(address) {
            this.editingAddress = address;
            this.showEditAddressModal = true;
        },

        closeEditModal() {
            this.showEditAddressModal = false;
            this.editingAddress = {};
        },

        openDeleteModal(address) {
            this.deletingAddress = address;
            this.showDeleteAddressModal = true;
        },

        closeDeleteModal() {
            this.showDeleteAddressModal = false;
            this.deletingAddress = {};
        }
    }
}
</script>
