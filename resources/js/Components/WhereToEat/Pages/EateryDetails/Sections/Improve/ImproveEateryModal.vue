<template>
  <div
    v-if="loading"
    class="flex justify-center items-center py-12 relative"
  >
    <Loader show />
  </div>

  <div
    v-else
    class="p-4"
  >
    <ul class="flex flex-col divide-y divide-blue-light">
      <template v-for="field in fields">
        <li
          v-if="field.shouldDisplay"
          :key="field.id"
          class="flex flex-col py-1"
        >
          <div
            v-if="field.updated"
            class="bg-blue-light bg-opacity-25 rounded p-1 text-center"
          >
            Thanks for your suggestion!
          </div>

          <template v-else>
            <div class="flex justify-between items-center w-full">
              <span :class="isFieldBeingEdited(field) ? 'text-blue-dark font-semibold text-sm' : ''">{{
                field.label
              }}</span>
              <span
                v-if="isFieldNotBeingEdited(field)"
                class="font-semibold text-blue-dark transition text-xs cursor-pointer hover:text-black"
                @click="openField(field)"
              >
                Update
              </span>
            </div>

            <div
              v-if="isFieldNotBeingEdited(field)"
              class="text-xs text-grey"
              :class="{
                capitalize: field.capitalise,
                truncate: field.truncate !== undefined ? field.truncate : true
              }"
            >
              {{ field.getter() || 'Not set' }}
            </div>

            <div
              v-if="isFieldBeingEdited(field)"
              class="flex flex-col space-y-2"
            >
              <template v-if="field.isFormField">
                <component
                  :is="field.formField.component"
                  :name="field.id"
                  :value="field.formField.value()"
                  v-bind="field.formField.props || null"
                  small
                />
              </template>

              <template v-else>
                <component
                  :is="field.component.name"
                  v-bind="field.component.props"
                />
              </template>

              <div class="flex justify-between text-xs font-semibold xs:text-base">
                <a
                  class="bg-yellow py-1 px-2 rounded cursor-pointer"
                  @click.prevent="cancelEditingField()"
                >
                  Cancel
                </a>

                <a
                  class="bg-blue py-1 px-2 rounded cursor-pointer xs:text-base"
                  @click.prevent="updateField()"
                >
                  Submit
                </a>
              </div>
            </div>
          </template>
        </li>
      </template>
    </ul>
  </div>
</template>

<script>
import EateryOpeningTimes from '~/WhereToEat/Pages/EateryDetails/Sections/Improve/EateryOpeningTimes';
import EateryFeatures from '~/WhereToEat/Pages/EateryDetails/Sections/Improve/EateryFeatures';

const Loader = () => import('~/Global/UI/Loader' /* webpackChunkName: "chunk-loader" */);
const FormInput = () => import('~/Forms/Input' /* webpackChunkName: "chunk-form-input" */);
const FormSelect = () => import('~/Forms/Select' /* webpackChunkName: "chunk-form-select" */);
const FormTextarea = () => import('~/Forms/Textarea' /* webpackChunkName: "chunk-form-textarea" */);

export default {
  components: {
    Loader, FormInput, FormSelect, FormTextarea, EateryOpeningTimes, EateryFeatures,
  },

  props: {
    id: {
      type: Number,
      required: true,
    },
  },

  data: () => ({
    loading: true,
    editing: null,
    newValue: null,
    eatery: {},
  }),

  computed: {
    currentFieldIndex() {
      if (!this.editing) {
        return null;
      }

      return this.fields.indexOf(this.editing);
    },

    fields() {
      return [
        {
          id: 'address',
          label: 'Address',
          shouldDisplay: this.eatery.is_nationwide === false,
          getter: () => this.eatery.address.split('<br />').join(', '),
          isFormField: true,
          formField: {
            component: 'form-textarea',
            value: () => this.eatery.address.split('<br />').join('\n'),
            props: {
              rows: 5,
            },
          },
          updated: false,
        },
        {
          id: 'website',
          label: 'Website',
          shouldDisplay: true,
          getter: () => this.eatery.website,
          isFormField: true,
          formField: {
            component: 'form-input',
            value: () => this.eatery.website,
          },
          updated: false,
        },
        {
          id: 'gf_menu_link',
          label: 'Gluten Free Menu Link',
          shouldDisplay: true,
          getter: () => this.eatery.gf_menu_link,
          isFormField: true,
          formField: {
            component: 'form-input',
            value: () => this.eatery.gf_menu_link,
          },
          updated: false,
        },
        {
          id: 'phone',
          label: 'Phone Number',
          shouldDisplay: this.eatery.is_nationwide === false,
          getter: () => this.eatery.phone,
          isFormField: true,
          formField: {
            component: 'form-input',
            value: () => this.eatery.phone,
          },
          updated: false,
        },
        {
          id: 'venue_type',
          label: 'Venue Type',
          shouldDisplay: true,
          getter: () => this.eatery.venue_type.label,
          isFormField: true,
          formField: {
            component: 'form-select',
            value: () => this.eatery.venue_type.id,
            props: {
              options: this.eatery.venue_type.values,
            },
          },
          updated: false,
        },
        {
          id: 'cuisine',
          label: 'Cuisine',
          shouldDisplay: this.eatery.type_id === 1,
          getter: () => this.eatery.cuisine.label,
          isFormField: true,
          formField: {
            component: 'form-select',
            value: () => this.eatery.cuisine.id,
            props: {
              options: this.eatery.cuisine.values,
            },
          },
          updated: false,
        },
        {
          id: 'opening_times',
          label: 'Opening Times',
          shouldDisplay: this.eatery.type_id !== 3 && this.eatery.is_nationwide === false,
          getter: () => {
            if (!this.eatery.opening_times) {
              return null;
            }

            if (!this.eatery.opening_times.today) {
              return 'Currently closed';
            }

            return this.eatery.opening_times.today.join(' - ');
          },
          capitalise: true,
          isFormField: false,
          component: {
            name: 'eatery-opening-times',
            props: {
              currentOpeningTimes: this.eatery.opening_times,
            },
          },
          updated: false,
        },
        {
          id: 'features',
          label: 'Features',
          shouldDisplay: true,
          getter: () => this.eatery.features.selected.map((feature) => feature.label).join(', '),
          isFormField: false,
          component: {
            name: 'eatery-features',
            props: {
              currentFeatures: this.eatery.features.values,
            },
          },
          updated: false,
        },
        {
          id: 'info',
          label: 'Additional Information',
          shouldDisplay: true,
          getter: () => 'Is there anything else we should know about this location?',
          truncate: false,
          isFormField: true,
          formField: {
            component: 'form-textarea',
            value: () => '',
          },
          updated: false,
        },
      ];
    },
  },

  mounted() {
    this.loadEatery();
  },

  methods: {
    cancelEditingField() {
      if (!this.editing) {
        return;
      }

      this.$root.$off(`${this.editing.id}-change`, this.handleFieldUpdate);
      this.editing = null;
      this.newValue = null;
    },

    loadEatery() {
      coeliac().request().get(`/api/wheretoeat/${this.id}/suggest-edit`)
        .then((response) => {
          this.eatery = response.data.data;
          this.loading = false;
        });
    },

    openField(field) {
      this.cancelEditingField(this.editing);

      this.newValue = field.isFormField ? field.formField.value() : '';
      this.$root.$on(`${field.id}-change`, this.handleFieldUpdate);

      this.editing = field;
    },

    handleFieldUpdate(value) {
      this.newValue = value;
    },

    isFieldBeingEdited(field) {
      return field.label === this.editing?.label;
    },

    isFieldNotBeingEdited(field) {
      return !this.isFieldBeingEdited(field);
    },

    updateField() {
      if (!this.newValue) {
        coeliac().error('Please complete the form before submitting!');

        return;
      }

      coeliac().request()
        .post(`/api/wheretoeat/${this.id}/suggest-edit`, {
          field: this.editing.id,
          value: this.newValue,
        })
        .then(() => {
          this.fields[this.currentFieldIndex].updated = true;
          this.cancelEditingField();

          coeliac().success('Thanks for suggesting an improvement to this location!');
        })
        .catch(() => {
          coeliac().error('Sorry, we were unable to save your suggested edit, please try again...');
        });
    },
  },
};
</script>
