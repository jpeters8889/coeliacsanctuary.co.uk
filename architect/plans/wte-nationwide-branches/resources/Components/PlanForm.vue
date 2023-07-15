<template>
  <div class="flex flex-col space-y-3">
    <div
      v-for="(row, index) in values"
      :key="index"
      class="w-full p-3 border border-blue-900 rounded-lg"
    >
      <div
        v-for="plan in plans"
        :key="plan.column"
        class="w-full py-3"
      >
        <plan-form-field
          :key="plan.column"
          :index="index"
          :plan="plan"
          :listener="listenerName"
          :emitter="emitterName"
        />
      </div>
    </div>

    <div class="w-full py-3 flex justify-end">
      <button
        class="button button-primary button-default"
        @click.prevent="values.push({})"
      >
        Add Branch
      </button>
    </div>
  </div>
</template>

<script>
import { IsAFormField } from 'architect-js-helpers';

export default {
  mixins: [IsAFormField],

  data: () => ({
    plans: [],
    branches: [{}],
  }),

  computed: {
    listenerName() {
      return 'prepare-branches';
    },

    emitterName() {
      return 'branches-change';
    },
  },

  mounted() {
    this.plans = this.metas.plans;
    this.wrap = this.metas.wrap;

    Architect.$on(this.emitterName, (field) => {
      this.$set(this.branches[field.index], field.name, field.value);
    });
  },

  methods: {
    getFormData() {
      Architect.$emit(this.listenerName);

      return {
        name: this.name,
        value: JSON.stringify(this.branches),
      };
    },
  },
};
</script>
