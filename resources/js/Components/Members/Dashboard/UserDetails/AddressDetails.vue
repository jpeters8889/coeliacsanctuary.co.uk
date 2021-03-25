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
                        <font-awesome-icon class="cursor-pointer" :icon="['far', 'trash-alt']"
                                           @click="openDeleteModal(address)"
                                           v-tooltip.left="{content: 'Delete', classes: ['bg-blue', 'border-blue', 'text-white']}"/>
                    </div>
                </div>
            </div>
        </div>

        <portal to="modal" v-if="showEditAddressModal">
            <modal name="edit-address" modal-classes="w-full" small>
                <form @submit.prevent="saveAddress()" class="flex flex-col">
                    <div class="py-4 border-b border-blue last:border-0" v-for="input in addressEditableFields()">
                        <label class="text-blue-dark font-semibold mb-1" :for="`editing_${input.prop}`"
                               v-html="input.label"/>
                        <component :is="input.type" :value="editingAddress[input.prop]" :id="`editing_${input.prop}`"
                                   :name="`editing_${input.prop}`" :required="input.required"
                                   :pattern="input.pattern ? input.pattern() : null"
                                   :options="input.options ? input.options() : null"/>
                    </div>

                    <div class="flex space-x-4 justify-center mt-2">
                        <button
                            class="rounded leading-none px-4 py-2 bg-blue hover:bg-blue-light hover:shadow cursor-pointer"
                            @click.prevent="closeEditModal">
                            Cancel
                        </button>

                        <button
                            class="rounded leading-none px-4 py-2 bg-yellow hover:bg-yellow-light hover:shadow cursor-pointer"
                            style="width: 170px; height: 50px" @click.prevent="saveAddress()">
                            <loader background-position=""
                                    v-if="submittingDetails"
                                    :show="true"
                                    height="25px"
                                    width="25px"
                                    border-width="3px"
                                    faded-border-color="border-black-50"
                                    primary-border-color="black">
                            </loader>
                            <span v-else>Save Address</span>
                        </button>
                    </div>
                </form>
            </modal>
        </portal>

        <portal to="modal" v-if="showDeleteAddressModal">
            <modal name="delete-address">
                <h3>Are you sure you want to delete this address?</h3>
                <div class="flex space-x-4 justify-center mt-2">
                    <a class="rounded leading-none px-4 py-2 bg-blue hover:bg-blue-light hover:shadow cursor-pointer"
                       @click="closeDeleteModal">
                        No
                    </a>

                    <a class="rounded leading-none px-4 py-2 bg-yellow hover:bg-yellow-light hover:shadow cursor-pointer"
                       @click="deleteAddress()">
                        Yes
                    </a>
                </div>
            </modal>
        </portal>
    </div>
</template>

<script>
const FormInput = () => import('~/Forms/Input' /* webpackChunkName: "chunk-form-input" */)
const FormSelect = () => import('~/Forms/Select' /* webpackChunkName: "chunk-form-select" */)
const Loader = () => import('~/Global/UI/Loader' /* webpackChunkName: "chunk-loader" */)
const Modal = () => import('~/Global/UI/Modal' /* webpackChunkName: "chunk-modal" */)

import Vue from "vue";
import VTooltip from "v-tooltip";

Vue.use(VTooltip);

export default {
    components: {
        'form-input': FormInput,
        'form-select': FormSelect,
        'loader': Loader,
        'modal': Modal,
    },

    data: () => ({
        addresses: [],
        countries: [],

        showEditAddressModal: false,
        showDeleteAddressModal: false,

        editingAddress: {},
        deletingAddress: {},

        submittingDetails: false,

        validity: {
            name: false,
            line_1: false,
            line_2: true,
            line_3: true,
            town: false,
            postcode: false,
            country: false,
        },
    }),

    mounted() {
        this.loadAddresses();
        this.loadCountries();

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
            this.addresses = [];

            coeliac().request().get('/api/member/addresses')
                .then((response) => {
                    this.addresses = response.data;
                })
                .catch(() => {
                    this.addresses = [];
                });
        },

        loadCountries() {
            coeliac().request().get('/api/shop/countries')
                .then((response) => {
                    this.countries = response.data;
                });
        },

        deleteAddress() {
            coeliac().request().delete(`/api/member/addresses/${this.deletingAddress.id}`)
                .then(() => {
                    coeliac().success('Address Deleted');
                })
                .catch(() => {
                    coeliac().error('There was an error deleting your address');
                })
                .then(() => {
                    this.closeDeleteModal();
                });
        },

        saveAddress() {
            if (!this.validateEditForm()) {
                return;
            }

            this.submittingDetails = true;

            coeliac().request().post(`/api/member/addresses/${this.editingAddress.id}`, this.editingAddress)
                .then(() => {
                    coeliac().success('Address Saved');
                    this.closeEditModal();
                })
                .catch(() => {
                    coeliac().error('There was an error saving your address');
                })
                .finally(() => {
                    this.submittingDetails = false;
                })
        },

        validateEditForm() {
            Object.keys(this.validity).forEach((field) => {
                this.$root.$emit(`editing_${field}-get-value`)
            });

            let isValid = true;

            Object.keys(this.validity).forEach((field) => {
                if (this.validity[field] === false) {
                    isValid = false;
                }
            });

            return isValid;
        },

        openEditModal(address) {
            this.editingAddress = address;
            this.showEditAddressModal = true;

            Object.keys(this.validity).forEach((field) => {
                coeliac().$emit(`editing_${field}-set-value`, (this.editingAddress[field]));

                this.$root.$on(`editing_${field}-error`, () => {
                    this.validity[field] = false;
                });

                this.$root.$on(`editing_${field}-valid`, () => {
                    this.validity[field] = true;
                });

                this.$root.$on(`editing_${field}-change`, (value) => {
                    this.editingAddress[field] = value;
                });
            });

            this.validateEditForm();
        },

        closeEditModal() {
            this.loadAddresses();
            this.showEditAddressModal = false;
            this.editingAddress = {};
            document.querySelector('body').classList.remove('overflow-hidden');
        },

        openDeleteModal(address) {
            this.deletingAddress = address;
            this.showDeleteAddressModal = true;
        },

        closeDeleteModal() {
            this.loadAddresses();
            this.showDeleteAddressModal = false;
            this.deletingAddress = {};
            document.querySelector('body').classList.remove('overflow-hidden');
        },

        addressEditableFields() {
            return [
                {
                    label: 'Your Name',
                    type: 'form-input',
                    prop: 'name',
                    required: true,
                },
                {
                    label: 'Address 1',
                    type: 'form-input',
                    prop: 'line_1',
                    required: true,
                },
                {
                    label: 'Address 2',
                    type: 'form-input',
                    prop: 'line_2',
                    required: false,
                },
                {
                    label: 'Address 3',
                    type: 'form-input',
                    prop: 'line_3',
                    required: false,
                },
                {
                    label: 'Town',
                    type: 'form-input',
                    prop: 'town',
                    required: true,
                },
                {
                    label: 'Postcode',
                    type: 'form-input',
                    prop: 'postcode',
                    required: true,
                    pattern: () => {
                        if (this.editingAddress.type === 'Shipping' && this.editingAddress.country === 'United Kingdom') {
                            return /^[A-Z]{1,2}\d[A-Z\d]? ?\d[A-Z]{2}$/i
                        }

                        return /.*/;
                    }
                },
                {
                    label: 'Country',
                    type: this.editingAddress.type === 'Shipping' ? 'form-select' : 'form-input',
                    prop: 'country',
                    required: true,
                    options: () => {
                        return this.countries.map(country => ({value: country.label, label: country.label}));
                    },
                }
            ];
        },
    }
}
</script>
