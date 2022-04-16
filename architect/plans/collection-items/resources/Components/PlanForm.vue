<template>
  <div>
    <div class="bg-blue-100 rounded-lg p-4">
      <div class="text-right mb-4">
        <a
          class="bg-blue-700 py-2 px-4 text-lg leading-none font-semibold cursor-pointer slider-bg inline-block rounded text-white"
          @click="showModal = true"
        >
          Add Item
        </a>
      </div>
      <table class="w-full leading-none">
        <tr class="bg-blue-900 text-white text-semibold text-left">
          <th class="p-2 border-r border-blue-200" />
          <th class="p-2 border-r border-blue-200">
            Type
          </th>
          <th class="p-2 border-r border-blue-200">
            Title
          </th>
          <th class="p-2" />
        </tr>
        <tr
          v-for="(item, index) in items"
          class="border-b border-blue-300 bg-white"
        >
          <td
            class="p-2 border-r border-blue-200 text-blue-900"
            style="width: 50px"
          >
            <template v-if="items.length > 1">
              <font-awesome-icon
                v-if="index > 0"
                class="cursor-pointer"
                :icon="['fas', 'caret-up']"
                @click="moveItemUp(index)"
              />
              <span v-if="index > 0 && index < (items.length - 1)">/</span>
              <font-awesome-icon
                v-if="index < (items.length - 1)"
                class="cursor-pointer"
                :icon="['fas', 'caret-down']"
                @click="moveItemDown(index)"
              />
            </template>
          </td>
          <td class="p-2 border-r border-blue-200">
            {{ item.type }}
          </td>
          <td class="p-2 border-r border-blue-200">
            {{ item.title }}
          </td>
          <td
            class="text-center py-1"
            style="width: 65px;"
          >
            <a
              class="bg-red-500 p-2 inline-block rounded text-sm leading-none font-semibold cursor-pointer slider-bg"
              @click="deleteItem(index)"
            >
              Delete
            </a>
          </td>
        </tr>
      </table>
      <div class="text-right mt-4">
        <a
          class="bg-blue-700 py-2 px-4 text-lg leading-none font-semibold cursor-pointer slider-bg inline-block rounded text-white"
          @click="showModal = true"
        >
          Add Item
        </a>
      </div>
    </div>

    <portal
      v-if="showModal"
      to="modal"
    >
      <modal title="Add Item to Collection">
        <div class="w-full flex flex-col justify-center items-center leading-none">
          <div class="w-full py-3 flex-col">
            <div v-if="!addModal.selectedItem">
              <div class="flex w-full items-center mb-2">
                <p class="w-1/6">
                  Item Area
                </p>
                <select
                  v-model="addModal.searchType"
                  class="form-control form-control-input w-full flex-1"
                >
                  <option value="blogs">
                    Blogs
                  </option>
                  <option value="recipes">
                    Recipes
                  </option>
                  <option value="wte">
                    Where to Eat
                  </option>
                  <option value="shop">
                    Shop Products
                  </option>
                </select>
              </div>

              <div class="flex w-full items-center">
                <p class="w-1/6">
                  Search For...
                </p>
                <div class="relative flex-1">
                  <input
                    v-model="addModal.searchString"
                    type="text"
                    class="form-control form-control-input w-full"
                    :class="addModal.searchResults.length ? 'rounded-b-none' : ''"
                    @keyup="modalSearch()"
                  >

                  <div
                    v-if="addModal.searchResults.length"
                    class="rounded-b-lg bg-white border border-black overflow-hidden z-50 w-full overflow-y-scroll"
                  >
                    <ul style="max-height: 170px;">
                      <li
                        v-for="result in addModal.searchResults"
                        class="p-2 border-b border-black bg-blue-100 hover:bg-white transition-all w-full cursor-pointer"
                        @click="selectItem(result)"
                      >
                        {{ result.title }}
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div v-else>
              <div>
                <p class="font-semibold">
                  {{ addModal.selectedItem.title }}
                </p>
              </div>

              <div class="flex w-full items-center mt-2">
                <textarea
                  v-model="addModal.searchDescription"
                  :disabled="!addModal.selectedItem"
                  class="form-control form-control-input w-full flex-1"
                  rows="5"
                  :class="!addModal.selectedItem ? 'bg-gray-100 cursor-not-allowed' : ''"
                />
              </div>

              <div class="w-full pt-3 flex justify-center">
                <button
                  class="button-primary button px-4 py-3 rounded text-xl"
                  @click.prevent="addItem()"
                >
                  Add Item
                </button>
              </div>
            </div>
          </div>
        </div>
      </modal>
    </portal>
  </div>
</template>

<script>
import { IsAFormField } from 'architect-js-helpers';

export default {
  mixins: [IsAFormField],

  data: () => ({
    items: [],

    showModal: false,

    addModal: {
      searchType: 'blogs',
      searchString: '',
      searchDescription: '',
      searchResults: [],

      selectedItem: null,
    },
  }),

  mounted() {
    Architect.$on('modal-close', () => {
      this.showModal = false;
    });

    if (this.value) {
      this.items = this.value;
    }
  },

  methods: {
    getFormData() {
      return {
        name: this.name,
        value: JSON.stringify(this.items.map((item, index) => ({
          id: item.id,
          description: item.description,
          type: item.type,
          position: index + 1,
        }))),
      };
    },

    moveItemUp(index) {
      this.items.splice(index - 1, 0, this.items.splice(index, 1)[0]);
    },

    moveItemDown(index) {
      this.items.splice(index + 1, 0, this.items.splice(index, 1)[0]);
    },

    deleteItem(index) {
      this.items.splice(index, 1);
    },

    modalSearch() {
      Architect.request().post('/external/collection-items/search', {
        type: this.addModal.searchType,
        term: this.addModal.searchString,
      }).then((response) => {
        this.addModal.searchResults = response.data.results;
      }).catch(() => {
        Architect.error('No results found');
      });
    },

    selectItem(item) {
      this.addModal.selectedItem = item;
      this.addModal.searchDescription = item.description;
      this.addModal.searchResults = [];
    },

    addItem() {
      this.addModal.selectedItem.description = this.addModal.searchDescription;

      this.items.push(this.addModal.selectedItem);

      this.showModal = false;

      this.addModal.searchType = 'blogs';
      this.addModal.searchString = '';
      this.addModal.searchDescription = '';
      this.addModal.searchResults = [];

      this.addModal.selectedItem = null;
    },
  },
};
</script>
