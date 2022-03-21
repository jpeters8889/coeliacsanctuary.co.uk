<template>
  <div class="text-sm">
    <ul class="flex flex-col space-y-px divide-y divide-grey-off">
      <li
        v-for="feature in features"
        :key="feature.key"
        class="flex justify-between w-full py-1"
      >
        <span>{{ feature.label }}</span>

        <div class="flex space-x-1 items-center justify-between">
          <form-checkbox
            :value="feature.selected"
            :name="`feature_${feature.key}`"
            input-size="text-xs"
            highlight-style="background"
            highlight-colour="blue-light"
            rounded
          />
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
const FormCheckbox = () => import('~/Forms/Checkbox' /* webpackChunkName: "chunk-form-checkbox" */);

export default {
  components: { FormCheckbox },

  props: {
    currentFeatures: {
      required: true,
      type: Array,
    },
  },

  data: () => ({
    features: [],
  }),

  mounted() {
    this.features = this.currentFeatures.map((feature) => ({
      key: feature.id,
      label: feature.label,
      selected: feature.selected,
    }));

    this.features.forEach((feature, index) => {
      this.$root.$on(`feature_${feature.key}-change`, (value) => {
        this.features[index].selected = value;

        this.emitChange();
      });
    });
  },

  methods: {
    emitChange() {
      this.$root.$emit('features-change', this.features);
    },
  },
};
</script>
