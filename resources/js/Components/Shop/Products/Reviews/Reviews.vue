<template>
  <div>
    <div
      v-if="!loaded"
      class="relative h-32"
    >
      <loader :show="true" />
    </div>

    <div v-else>
      <div
        v-if="data.length === 0"
        class="mb-3"
      >
        <strong class="font-semibold">This product doesn't have any reviews yet.</strong>
      </div>

      <div v-else>
        <div
          v-for="review in data"
          :key="review.id"
          class="bg-blue-light bg-opacity-20 border-l-8 border-yellow p-2 mb-4"
        >
          <div class="flex justify-between mb-2">
            <span class="font-semibold">{{ review.name }}</span>

            <global-ui-stars
              :stars="review.rating"
              size="text-base md:text-lg"
              half-star="star-half-alt"
              show-all
            />
          </div>

          <div v-html="reviewBody(review)" />

          <div class="flex justify-end text-blue">
            {{ formatDate(review.date) }}
          </div>
        </div>

        <div
          v-if="hasMore"
          class="my-2 bg-gradient-to-br from-blue/20 to-blue-light/20 p-1 shadow border border-blue text-center text-lg hover:bg-blue-gradient-10 cursor-pointer"
          @click="nextPage()"
        >
          Load More Reviews
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import FormatsDates from '@/Mixins/FormatsDates';

const Loader = () => import('~/Global/UI/Loader' /* webpackChunkName: "chunk-loader" */);

export default {

  components: {
    loader: Loader,
  },

  mixins: [
    FormatsDates,
  ],

  props: {
    id: {
      type: Number,
      required: true,
    },
  },

  data: () => ({
    initial: false,
    loaded: false,
    data: [],
    currentPage: 1,
    hasMore: false,
  }),

  mounted() {
    this.data = [];
    this.currentPage = 1;
    this.hasMore = false;

    new IntersectionObserver((entries) => {
      if (this.initial) {
        return;
      }

      if (entries[0].intersectionRatio > 0) {
        this.initial = true;
        this.getData();
      }
    }).observe(document.querySelector('#reviews-wrapper'));
  },

  methods: {
    reviewBody(review) {
      if (!review.review) {
        return '<em>Customer didn\'t leave a review with their rating</em>';
      }

      return review.review;
    },

    getData() {
      coeliac().request().get(`/api/shop/product/${this.id}/reviews?page=${this.currentPage}`)
        .then((response) => {
          this.hasMore = this.currentPage !== response.data.last_page;
          this.data.push(...response.data.data);
        })
        .catch(() => {
          //
        })
        .finally(() => {
          this.loaded = true;
        });
    },

    nextPage() {
      this.currentPage += 1;

      this.getData();
    },
  },
};
</script>
