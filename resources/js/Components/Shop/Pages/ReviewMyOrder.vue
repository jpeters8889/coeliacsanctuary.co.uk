<template>
  <div
    v-if="!completed"
    class="space-y-3"
  >
    <div class="page-box">
      <div class="flex flex-col space-y-2 items-center">
        <div class="w-full">
          <p class="font-semibold text-blue-dark">
            Your Name
          </p>
          <small class="leading-none text-grey-dark">
            You can leave this blank if you'd prefer your feedback to be anonymous
          </small>
        </div>

        <div class="w-full flex-1">
          <form-input
            name="name"
            small
            full-width
            :value="feedbackName"
          />
        </div>
      </div>
    </div>

    <div class="page-box">
      <div class="flex flex-col space-y-2">
        <p class="font-semibold text-blue-dark">
          How did you hear about us?
        </p>

        <div class="w-full flex-1">
          <form-multi-select
            name="where-heard"
            small
            allow-other
            :options="whereDidYouHearOptions"
            :value="hearFrom"
          />
        </div>
      </div>
    </div>

    <div
      v-for="(item, index) in items"
      :key="item.id"
      class="page-box"
    >
      <ItemLoader v-if="item.loading" />
      <Item
        v-else
        :item="item"
        :index="index"
      />
    </div>

    <div class="page-box">
      <button
        class="block bg-blue-light hover:bg-opacity-75 rounded-lg p-2 w-full text-center transition-all"
        @click.prevent="submitReviews()"
      >
        Submit My Review!
      </button>
    </div>
  </div>

  <div v-else>
    <div
      ref="top"
      class="page-box"
    >
      <p>
        Thank you for sending your feedback, it really does mean a lot and will continuously help me improve Coeliac Sanctuary!
      </p>

      <a
        class="block bg-blue-light hover:bg-opacity-75 rounded-lg p-2 w-full text-center transition-all mt-3"
        href="/"
      >
        Go back home!
      </a>
    </div>
  </div>
</template>

<script>
import Item from './ReviewMyOrder/Item';
import ItemLoader from './ReviewMyOrder/ItemLoader';

const FormInput = () => import('~/Forms/Input' /* webpackChunkName: "chunk-form-input" */);
const FormMultiSelect = () => import('~/Forms/MultiSelect' /* webpackChunkName: "chunk-form-multiselect" */);

export default {
  components: {
    ItemLoader,
    Item,
    'form-input': FormInput,
    'form-multi-select': FormMultiSelect,
  },

  props: {
    invitation: {
      required: true,
      type: String,
    },
    products: {
      required: true,
      type: Array,
    },
    name: {
      required: true,
      type: String,
    },
  },

  data: () => ({
    completed: false,
    items: [],
    reviews: [],
    feedbackName: '',
    hearFrom: [],
  }),

  computed: {
    whereDidYouHearOptions() {
      return [
        { value: 'facebook', label: 'Facebook' },
        { value: 'instagram', label: 'Instagram' },
        { value: 'word-of-mouth', label: 'Word of Mouth' },
        { value: 'website', label: 'Coeliac Sanctuary Website' },
        { value: 'newsletter', label: 'Coeliac Sanctuary Newsletter' },
        { value: 'google', label: 'Google' },
        { value: 'search', label: 'Another Search Engine' },
        { value: 'blogger', label: 'A Gluten Free Website / Blogger' },
        { value: 'show', label: 'Allergy Show / Food Fair' },
      ];
    },
  },

  created() {
    this.items = this.products.map((product) => ({
      id: product,
      loading: true,
    }));

    this.reviews = this.products.map(() => ({ review: '', rating: null }));
    this.feedbackName = this.name;
  },

  async mounted() {
    await this.loadProducts();

    this.$root.$on('review-change', (event) => {
      this.reviews[event.index] = event.value;
    });

    this.$root.$on('name-change', (value) => {
      this.feedbackName = value;
    });

    this.$root.$on('where-heard-change', (value) => {
      this.hearFrom = value;
    });
  },

  methods: {
    async loadProducts() {
      this.items = await Promise.all(this.items.map(async (item) => {
        const response = await coeliac()
          .request()
          .get(`/api/shop/product/${item.id}`);

        return {
          ...response.data.data,
          loading: false,
        };
      }));
    },

    isValid() {
      const ratings = this.reviews.map((review) => review.rating).filter((rating) => rating !== null);
      const reviews = this.reviews.map((review) => review.review).filter((review) => review !== '');

      return ratings.length > 0 && reviews.length > 0;
    },

    hasAnyIncompleteReviews() {
      return this.reviews.filter((review) => review.review !== '' && (review.rating === null || review.rating === 0)).length > 0;
    },

    submitReviews() {
      if (!this.isValid()) {
        coeliac().error('Please leave a rating for at least one item before submitting!');

        return;
      }

      if (this.hasAnyIncompleteReviews()) {
        coeliac().error('Please leave a rating for at least one item before submitting!');

        return;
      }

      coeliac()
        .request()
        .post(`/api/shop/review-my-order/${this.invitation}`, this.prepareData())
        .then(() => {
          this.completed = true;

          this.$nextTick(() => {
            this.$scrollTo(this.$refs.top, 300, {
              offset: -200,
            });
          });
        })
        .catch(() => coeliac().error('Sorry, an error has occurred'));
    },

    prepareData() {
      return {
        name: this.feedbackName,
        whereHeard: this.hearFrom,
        products: this.items.map((item, index) => ({ ...this.reviews[index], id: item.id }))
          .filter((feedback) => feedback.rating !== null),
      };
    },
  },
};
</script>
