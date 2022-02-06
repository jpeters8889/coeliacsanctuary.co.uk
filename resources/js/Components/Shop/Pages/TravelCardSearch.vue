<template>
  <div class="flex justify-center">
    <div class="flex flex-col justify-center items-center space-y-4 w-full">
      <h2 class="text-xl font-semibold">
        Where are you heading?
      </h2>

      <div class="flex flex-col justify-center items-center space-y-4 sm:w-3/4">
        <p class="text-center">
          Enter the country or language below and we'll try and find the best travel card for you!
        </p>

        <div class="flex flex-col w-full">
          <form-input
            name="term"
            :value="term"
            placeholder="Search for a country or a language..."
            border-class="border-grey-off rounded-none rounded-t"
            :on-escape="() => showResultsBox = false"
          />

          <div
            v-if="showResultsBox"
            v-click-outside="blur"
            class="border-grey-off border-t-0 border rounded-b"
          >
            <div
              v-if="isLoading"
              class="py-2 text-xs text-grey"
            >
              >
              Loading...
            </div>

            <template v-else>
              <div
                v-if="term === ''"
                class="py-2 text-xs text-grey"
              >
                Start typing to search...
              </div>

              <div
                v-else-if="results.length === 0"
                class="p-3 text-center flex flex-col space-y-2"
              >
                <div>Sorry, nothing found</div>

                <div>
                  Make sure you're searching for a country or a language, and not a city or place name,
                  so search <strong>France</strong>, not <strong>Paris</strong> for example!
                </div>
              </div>

              <ul v-else>
                <li
                  v-for="result in results"
                  :key="result.id"
                  class="flex space-x-2 text-left border-b border-grey-off transition cursor-pointer hover:bg-grey-lightest last:border-b-0"
                  @click="selectResult(result)"
                >
                  <span
                    class="flex-1 p-2"
                    v-html="result.term"
                  />
                  <span
                    class="font-semibold bg-grey-off-light text-grey-dark text-xs flex justify-center items-center w-[77px] sm:w-[100px]"
                  >
                    {{ result.type.charAt(0).toUpperCase() + result.type.slice(1) }}
                  </span>
                </li>
              </ul>
            </template>
          </div>
        </div>
      </div>

      <div
        v-if="selectedResult"
        class="w-full"
      >
        <div
          v-if="loadingResult"
          class="w-full min-h-map justify-center items-center relative"
        >
          <loader :show="true" />
        </div>

        <div
          v-else
          class="flex flex-col justify-between"
        >
          <p
            v-if="matchingCards.type==='country'"
            class="text-lg font-semibold text-center"
          >
            Here are our travel cards that can be used in
            <span class="text-blue-dark">{{ matchingCards.term }}</span>
          </p>

          <p
            v-else
            class="text-lg font-semibold text-center"
          >
            Here are our travel cards that can be used in
            <span class="text-blue-dark">{{ matchingCards.term }}</span> speaking areas
          </p>

          <div class="flex flex-col justify-around sm:flex-row">
            <div
              v-for="product in matchingCards.products"
              :key="product.id"
              class="sm:max-w-half md:max-w-[400px] xl:max-w-[600px]"
            >
              <div class="w-full p-4 flex flex-col text-center rounded space-y-2">
                <a :href="product.link">
                  <img
                    :src="product.image"
                    loading="lazy"
                    class="lazy"
                    :alt="product.title"
                  >
                </a>

                <h2 class="text-lg text-blue-dark font-semibold hover:text-grey transition-all">
                  <a :href="product.link">
                    {{ product.title }}
                  </a>
                </h2>

                <h3 class="text-sm">
                  {{ product.category }}
                </h3>

                <p
                  class="text-2xl font-semibold leading-none mb-2"
                  v-html="formatPrice(product.price)"
                />

                <p
                  class="mb-2"
                  v-html="product.description"
                />

                <div class="flex flex-col leading-none xs:flex-row xs:justify-around">
                  <a
                    :href="product.link"
                    class="font-semibold border border-blue rounded p-2 bg-blue-light bg-opacity-50 text-black hover:bg-opacity-20 transition-all mb-2"
                  >
                    Find out more
                  </a>

                  <shop-basket-ui-add-product
                    v-if="product.inStock"
                    :product-id="product.id"
                    :variant-id="product.variant_id"
                  >
                    <button
                      class="xs:ml-1 w-full font-semibold border border-blue rounded p-2 bg-blue-light bg-opacity50 text-black hover:bg-opacity-20 transition-all mb-2"
                    >
                      Add to Basket
                    </button>
                  </shop-basket-ui-add-product>

                  <button
                    v-else
                    disabled
                    class="xs:ml-1 font-semibold border border-blue-light rounded p-2 bg-opacity-20 text-grey cursor-not-allowed mb-2"
                  >
                    Out of stock
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ClickOutside from 'vue-click-outside';
import FormatsPrices from '@/Mixins/FormatsPrices';

const FormInput = () => import('~/Forms/Input' /* webpackChunkName: "chunk-form-input" */);
const Loader = () => import('~/Global/UI/Loader' /* webpackChunkName: "chunk-loader" */);

export default {
  components: {
    'form-input': FormInput,
    loader: Loader,
  },

  directives: {
    ClickOutside,
  },

  mixins: [FormatsPrices],

  data: () => ({
    timeout: null,
    term: '',
    showResultsBox: false,
    isLoading: false,
    results: [],
    selectedResult: false,
    matchingCards: {},
    loadingResult: true,
  }),

  watch: {
    term() {
      clearTimeout(this.timeout);

      if (this.term === '') {
        return;
      }

      this.timeout = setTimeout(() => {
        this.performSearch();
      }, 300);
    },
  },

  mounted() {
    this.$root.$on('term-value', (value) => {
      this.term = value;
    });

    this.$root.$on('term-change', (value) => {
      this.term = value;
    });

    this.$root.$on('term-focus', () => {
      this.showResultsBox = true;
    });

    this.$root.$on('term-blur', () => {
      this.blur();
    });
  },

  methods: {
    blur() {
      if (this.term === '') {
        this.showResultsBox = false;
      }
    },

    performSearch() {
      this.showResultsBox = true;
      this.isLoading = true;

      coeliac().request().post('/api/shop/travel-card-search', { term: this.term })
        .then((response) => {
          if (response.status === 200) {
            this.results = response.data.results;

            return;
          }

          coeliac().error('There was an error performing your search...');
        })
        .catch(() => {
          coeliac().error('There was an error performing your search...');
        })
        .finally(() => {
          this.isLoading = false;
        });
    },

    selectResult(result) {
      this.showResultsBox = false;
      this.loadingResult = true;
      this.selectedResult = true;
      this.term = '';
      this.$root.$emit('term-set-value', '');

      coeliac().request().get(`/api/shop/travel-card-search/${result.id}`)
        .then((response) => {
          if (response.status === 200) {
            this.matchingCards = response.data;

            return;
          }

          coeliac().error('There was an error performing your search...');
        })
        .catch(() => {
          coeliac().error('There was an error performing your search...');
        })
        .finally(() => {
          this.loadingResult = false;
        });
    },
  },
};
</script>
