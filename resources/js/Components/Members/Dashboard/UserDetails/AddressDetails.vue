<template>
  <div class="bg-gradient-to-br from-blue/30 to-blue-light/30 p-2 mt-2 rounded-lg">
    <h2 class="text-lg text-blue-dark font-semibold">
      Your Addresses
    </h2>

    <p class="text-sm">
      Here you can manage your saved addresses from our online shop.
    </p>

    <div class="flex flex-col space-y-2">
      <div
        v-for="address in addresses"
        :key="address.id"
        class="flex flex-col p-2 bg-white bg-opacity-50 rounded"
      >
        <strong>{{ address.name }}</strong>
        <span>{{ formatAddress(address) }}</span>

        <div class="flex justify-between mt-2">
          <div class="flex">
            <strong class="mr-1">Address Type:</strong>
            <span>{{ address.type }}</span>
          </div>
          <div class="flex space-x-2">
            <font-awesome-icon
              v-tooltip.left="{content: 'Edit', classes: ['bg-blue', 'border-blue', 'text-white']}"
              class="cursor-pointer"
              :icon="['fas', 'pen']"
              @click="openEditModal(address)"
            />
            <font-awesome-icon
              v-tooltip.left="{content: 'Delete', classes: ['bg-blue', 'border-blue', 'text-white']}"
              class="cursor-pointer"
              :icon="['far', 'trash-alt']"
              @click="openDeleteModal(address)"
            />
          </div>
        </div>
      </div>
    </div>

    <portal
      v-if="showEditAddressModal"
      to="modal"
    >
      <modal
        name="edit-address"
        modal-classes="w-full"
        small
        title="Edit Address"
      >
        <form
          class="flex flex-col space-y-3 p-3"
          @submit.prevent="saveAddress()"
        >
          <component
            :is="input.type"
            v-for="input in addressEditableFields()"
            :id="`editing_${input.prop}`"
            :key="`editing_${input.prop}`"
            :value="editingAddress[input.prop]"
            :label="input.label"
            :name="`editing_${input.prop}`"
            :required="input.required"
            :pattern="input.pattern ? input.pattern() : null"
            :options="input.options ? input.options() : null"
          />

          <div class="flex space-x-4 justify-center mt-2">
            <button
              class="rounded leading-none px-4 py-2 bg-blue hover:bg-blue-light hover:shadow cursor-pointer"
              @click.prevent="closeEditModal"
            >
              Cancel
            </button>

            <button
              class="rounded leading-none px-4 py-2 bg-yellow hover:bg-yellow-light hover:shadow cursor-pointer"
              style="width: 170px; height: 50px"
              @click.prevent="saveAddress()"
            >
              <loader
                v-if="submittingDetails"
                background-position=""
                :show="true"
                height="25px"
                width="25px"
                border-width="3px"
                faded-border-color="border-black border-opacity-50"
                primary-border-color="black"
              />
              <span v-else>Save</span>
            </button>
          </div>
        </form>
      </modal>
    </portal>

    <portal
      v-if="showDeleteAddressModal"
      to="modal"
    >
      <modal
        name="delete-address"
        title="Are you sure you want to delete this address?"
      >
        <div class="flex space-x-4 justify-center p-3">
          <a
            class="rounded leading-none px-4 py-2 bg-blue hover:bg-blue-light hover:shadow cursor-pointer"
            @click="closeDeleteModal"
          >
            No, don't delete
          </a>

          <a
            class="rounded leading-none px-4 py-2 bg-yellow hover:bg-yellow-light hover:shadow cursor-pointer"
            @click="deleteAddress()"
          >
            Yes, delete it
          </a>
        </div>
      </modal>
    </portal>
  </div>
</template>

<script>
import Vue from 'vue';
import { VTooltip } from 'v-tooltip';

const FormInput = () => import('~/Forms/Input' /* webpackChunkName: "chunk-form-input" */);
const FormSelect = () => import('~/Forms/Select' /* webpackChunkName: "chunk-form-select" */);
const Loader = () => import('~/Global/UI/Loader' /* webpackChunkName: "chunk-loader" */);
const Modal = () => import('~/Global/UI/Modal' /* webpackChunkName: "chunk-modal" */);

Vue.directive('tooltip', VTooltip);

export default {
  components: {
    'form-input': FormInput,
    'form-select': FormSelect,
    loader: Loader,
    modal: Modal,
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
      return Array.from(['line_1', 'line_2', 'line_3', 'town', 'postcode', 'country'].map((key) => address[key]))
        .filter((value) => value !== null && value !== '')
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
        });
    },

    validateEditForm() {
      Object.keys(this.validity).forEach((field) => {
        this.$root.$emit(`editing_${field}-get-value`);
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
              return /^[A-Z]{1,2}\d[A-Z\d]? ?\d[A-Z]{2}$/i;
            }

            return /.*/;
          },
        },
        {
          label: 'Country',
          type: this.editingAddress.type === 'Shipping' ? 'form-select' : 'form-input',
          prop: 'country',
          required: true,
          options: () => this.countries.map((country) => ({ value: country.label, label: country.label })),
        },
      ];
    },
  },
};
</script>
