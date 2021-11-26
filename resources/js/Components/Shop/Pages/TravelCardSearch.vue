<template>
  <div>
    <div class="text-center space-y-4">
      <h2 class="text-xl font-semibold">
        Where are you headed?
      </h2>

      <p>Enter the country or language below and we'll try and find the best travel card for you!</p>

      <div class="flex flex-col">
        <form-input
          name="term"
          :value="term"
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
              class="py-3"
            >
              Sorry, nothing found :(
            </div>

            <ul v-else>
              <li
                v-for="result in results"
                :key="result.id"
                class="flex space-x-2 text-left border-b border-grey-off transition cursor-pointer hover:bg-grey-lightest last:border-b-0"
              >
                <span
                  class="flex-1 p-2"
                  v-html="result.term"
                />
                <span class="font-semibold bg-grey-off-light text-grey-dark text-xs flex justify-end items-center w-[77px] pr-2">
                  {{ result.type.charAt(0).toUpperCase() + result.type.slice(1) }}
                </span>
              </li>
            </ul>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import ClickOutside from 'vue-click-outside';

const FormInput = () => import('~/Forms/Input' /* webpackChunkName: "chunk-form-input" */);

export default {
  components: {
    'form-input': FormInput,
  },

  directives: {
    ClickOutside,
  },

  data: () => ({
    timeout: null,
    term: '',
    showResultsBox: false,
    isLoading: false,
    results: [],
  }),

  watch: {
    term() {
      clearTimeout(this.timeout);

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

      coeliac().request().post('api/shop/travel-card-search', { term: this.term })
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
  },
};
</script>
