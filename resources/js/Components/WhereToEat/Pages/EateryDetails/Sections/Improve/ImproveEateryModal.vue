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
      <li
        v-for="field in fields"
        :key="field.id"
        class="flex flex-col py-1"
      >
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

          <div class="flex justify-between text-xs font-semibold">
            <a
              class="bg-yellow py-1 px-2 rounded cursor-pointer"
              @click.prevent="cancelEditingField(field)"
            >
              Cancel
            </a>

            <a
              class="bg-blue py-1 px-2 rounded cursor-pointer"
              @click.prevent="updateField(field)"
            >
              Submit
            </a>
          </div>
        </div>
      </li>
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
    fields() {
      return [
        {
          id: 'address',
          label: 'Address',
          getter: () => this.eatery.address.split('<br />').join(', '),
          isFormField: true,
          formField: {
            component: 'form-textarea',
            value: () => this.eatery.address.split('<br />').join('\n'),
            props: {
              rows: 5,
            },
          },
        },
        {
          id: 'website',
          label: 'Website',
          getter: () => this.eatery.website,
          isFormField: true,
          formField: {
            component: 'form-input',
            value: () => this.eatery.website,
          },
        },
        {
          id: 'gf_menu',
          label: 'Gluten Free Menu Link',
          getter: () => this.eatery.gf_menu_link,
          isFormField: true,
          formField: {
            component: 'form-input',
            value: () => this.eatery.gf_menu_link,
          },
        },
        {
          id: 'phone',
          label: 'Phone Number',
          getter: () => this.eatery.phone,
          isFormField: true,
          formField: {
            component: 'form-input',
            value: () => this.eatery.phone,
          },
        },
        {
          id: 'venue_type',
          label: 'Venue Type',
          getter: () => this.eatery.venue_type.label,
          isFormField: true,
          formField: {
            component: 'form-select',
            value: () => this.eatery.venue_type.id,
            props: {
              options: this.eatery.venue_type.values,
            },
          },
        },
        {
          id: 'cuisine',
          label: 'Cuisine',
          getter: () => this.eatery.cuisine.label,
          isFormField: true,
          formField: {
            component: 'form-select',
            value: () => this.eatery.cuisine.id,
            props: {
              options: this.eatery.cuisine.values,
            },
          },
        },
        {
          id: 'opening_times',
          label: 'Opening Times',
          getter: () => (this.eatery.opening_times.today ? this.eatery.opening_times.today.join(' - ') : ''),
          capitalise: true,
          isFormField: false,
          component: {
            name: 'eatery-opening-times',
            props: {
              currentOpeningTimes: this.eatery.opening_times,
            },
          },
        },
        {
          id: 'features',
          label: 'Features',
          getter: () => this.eatery.features.selected.map((feature) => feature.label).join(', '),
          isFormField: false,
          component: {
            name: 'eatery-features',
            props: {
              currentFeatures: this.eatery.features.values,
            },
          },
        },
        {
          id: 'info',
          label: 'Additional Information',
          getter: () => 'Is there anything else we should know about this location?',
          truncate: false,
          isFormField: true,
          formField: {
            component: 'form-textarea',
            value: () => '',
          },
        },
      ];
    },
  },

  mounted() {
    this.loadEatery();
  },

  methods: {
    cancelEditingField(field) {
      if (!this.editing) {
        return;
      }

      this.$root.$off(`${field.id}-change`, this.handleFieldUpdate);
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

    updateField(field) {
      //
    },
  },
};
</script>
