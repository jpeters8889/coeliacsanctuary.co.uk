<template>
  <div class="flex flex-col space-y-3 md:flex-row md:space-y-0 md:space-x-3">
    <div class="flex space-x-3 md:w-1/4 md:max-w-[250px] ">
      <div class="w-1/4 max-w-[250px] flex-shrink-0 md:w-full">
        <img :src="item.first_image">
      </div>

      <div class="flex-1 md:hidden">
        <h2 class="text-blue-dark font-semibold text-lg leading-tight">
          {{ item.title }}
        </h2>
      </div>
    </div>

    <div class="flex-1">
      <div class="hidden md:block mb-2">
        <h2 class="text-blue-dark font-semibold text-lg leading-tight">
          {{ item.title }}
        </h2>
      </div>

      <div class="flex flex-col mb-3">
        <p class="text-xs text-grey-dark mb-1 leading-snug xs:text-sm">
          On a scale of 1-5 (1 being poor, 5 being excellent) How would you rate our {{ item.title }}?
        </p>

        <form-step
          :name="`rating-${index}`"
          :value="rating"
          :options="ratings"
          wrapper-classes="text-xl sm:text-2xl"
          icon-classes="px-[2px]"
        />
      </div>

      <div class="flex flex-col">
        <p class="text-xs text-grey-dark mb-1 leading-snug xs:text-sm">
          Please let us know below what you thought about this product, and how useful it was
        </p>

        <form-textarea
          :name="`review-${index}`"
          small
          :value="review"
          :rows="3"
          placeholder="Your review..."
        />
      </div>
    </div>
  </div>
</template>

<script>
const FormTextarea = () => import('~/Forms/Textarea' /* webpackChunkName: "chunk-form-textarea" */);
const FormStep = () => import('~/Forms/Step' /* webpackChunkName: "chunk-form-step" */);

export default {
  components: {
    'form-textarea': FormTextarea,
    'form-step': FormStep,
  },

  props: {
    item: {
      required: true,
      type: Object,
    },
    index: {
      required: true,
      type: Number,
    },
  },

  data: () => ({
    review: '',
    rating: 0,
  }),

  computed: {
    ratings() {
      return [
        { value: 1, label: '1' },
        { value: 2, label: '2' },
        { value: 3, label: '3' },
        { value: 4, label: '4' },
        { value: 5, label: '5' },
      ];
    },
  },

  watch: {
    review() {
      this.emitChange();
    },

    rating() {
      this.emitChange();
    },
  },

  mounted() {
    this.$root.$on(`review-${this.index}-change`, (value) => {
      this.review = value;
    });

    this.$root.$on(`rating-${this.index}-change`, (value) => {
      this.rating = value;
    });
  },

  methods: {
    emitChange() {
      this.$root.$emit('review-change', {
        index: this.index,
        value: {
          review: this.review,
          rating: this.rating,
        },
      });
    },
  },
};
</script>
