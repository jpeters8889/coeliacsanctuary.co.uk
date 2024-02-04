<template>
  <div>
    <div class="flex justify-center">
      <a
        class="inline-block bg-blue-500 font-semibold text-white py-2 px-8 leading-none mx-auto rounded-lg slider-bg"
        @click="viewEntries()"
      >
        {{ value }}
      </a>
    </div>

    <portal
      v-if="showModal"
      to="modal"
    >
      <modal
        title="Entrants"
        closable
      >
        <div class="flex flex-col bg-gray-200 p-2">
          <div class="flex flex-wrap space-x-2 space-y-2 justify-center items-center">
            <div class="bg-white rounded-lg p-2 flex flex-col justify-center items-center">
              <h2 class="text-lg text-blue-700 font-semibold">
                Total Entries
              </h2>
              <span>{{ totalEntries }}</span>
            </div>

            <template v-if="hasAdditionalEntries">
              <div class="bg-white rounded-lg p-2 flex flex-col justify-center items-center">
                <h2 class="text-lg text-blue-700 font-semibold">
                  Primary Entries
                </h2>
                <span>{{ primary }}</span>
              </div>

              <div
                v-if="facebookLike"
                class="bg-white rounded-lg p-2 flex flex-col justify-center items-center"
              >
                <h2 class="text-lg text-blue-700 font-semibold">
                  Facebook Like
                </h2>
                <span>{{ facebookLike }}</span>
              </div>

              <div
                v-if="facebookShare"
                class="bg-white rounded-lg p-2 flex flex-col justify-center items-center"
              >
                <h2 class="text-lg text-blue-700 font-semibold">
                  Facebook Share
                </h2>
                <span>{{ facebookShare }}</span>
              </div>

              <div
                v-if="twitterTweet"
                class="bg-white rounded-lg p-2 flex flex-col justify-center items-center"
              >
                <h2 class="text-lg text-blue-700 font-semibold">
                  Twitter Tweet
                </h2>
                <span>{{ twitterTweet }}</span>
              </div>

              <div
                v-if="twitterFollow"
                class="bg-white rounded-lg p-2 flex flex-col justify-center items-center"
              >
                <h2 class="text-lg text-blue-700 font-semibold">
                  Twitter Follow
                </h2>
                <span>{{ twitterFollow }}</span>
              </div>

              <div class="bg-white rounded-lg p-2 flex flex-col justify-center items-center">
                <h2 class="text-lg text-blue-700 font-semibold">
                  Facebook Pho Like
                </h2>
                <span>{{ facebookPhoLike }}</span>
              </div>

              <div
                v-if="shopPurchase"
                class="bg-white rounded-lg p-2 flex flex-col justify-center items-center"
              >
                <h2 class="text-lg text-blue-700 font-semibold">
                  Shop Purchase
                </h2>
                <span>{{ shopPurchase }}</span>
              </div>
            </template>
          </div>

          <div class="mt-2">
            <div class="my-2">
              <competition-paginator
                :current="currentPage"
                :last-page="numberOfPages"
                :can-go-back="currentPage > 1"
                :can-go-forward="currentPage < numberOfPages"
              />
            </div>

            <table class="w-full rounded-xl overflow-hidden">
              <tr class="font-semibold text-l w-full bg-gray-100 rounded-t-xl border-b border-gray-300 shadow">
                <th class="p-4 text-left whitespace-no-wrap text-gray-700 font-semibold leading-none">
                  Name
                </th>
                <th class="p-4 text-left whitespace-no-wrap text-gray-700 font-semibold leading-none">
                  Email
                </th>
                <th class="p-4 text-left whitespace-no-wrap text-gray-700 font-semibold leading-none">
                  Entry Method
                </th>
                <th class="p-4 text-left whitespace-no-wrap text-gray-700 font-semibold leading-none">
                  Entered At
                </th>
              </tr>

              <tr
                v-for="entry in entries"
                class="border-b bg-white border-gray-200"
                :data-id="entry.id"
              >
                <td class="p-4 align-top">
                  {{ entry.name }}
                </td>
                <td class="p-4 align-top">
                  {{ entry.email }}
                </td>
                <td class="p-4 align-top">
                  {{ entry.entry_type }}
                </td>
                <td class="p-4 align-top">
                  {{ entry.created_at }}
                </td>
              </tr>
            </table>

            <div class="my-2">
              <competition-paginator
                :current="currentPage"
                :last-page="numberOfPages"
                :can-go-back="currentPage > 1"
                :can-go-forward="currentPage < numberOfPages"
              />
            </div>
          </div>
        </div>
      </modal>
    </portal>
  </div>
</template>

<script>
export default {
  props: ['value', 'id'],

  data: () => ({
    showModal: false,
    hasAdditionalEntries: false,

    totalEntries: 0,
    primary: 0,
    facebookLike: null,
    facebookShare: null,
    twitterFollow: null,
    twitterTweet: null,
    facebookPhoLike: null,
    shopPurchase: null,

    currentPage: 1,
    numberOfPages: 1,
    entries: [],
  }),

  watch: {
    currentPage() {
      this.pageChange();
    },
  },

  mounted() {
    Architect.$on('modal-close', () => this.showModal = false);
    Architect.$on('competition-page-change', (page) => {
      this.currentPage = page;
    });
  },

  methods: {
    viewEntries() {
      this.getData();
      this.showModal = true;
    },

    getData() {
      Architect.request().get(`/external/competition-entries/get/${this.id}`)
        .then((response) => {
          this.totalEntries = response.data.total_entries;
          this.hasAdditionalEntries = response.data.has_more_entries;
          this.primary = response.data.primary;
          this.facebookLike = response.data.facebook_like;
          this.facebookShare = response.data.facebook_share;
          this.twitterFollow = response.data.twitter_follow;
          this.twitterTweet = response.data.twitter_tweet;
          this.facebookPhoLike = response.data.facebook_pho_like;
          this.shopPurchase = response.data.shop_purchase;
          this.numberOfPages = response.data.entrants.last_page;
          this.entries = response.data.entrants.data;
        });
    },

    pageChange() {
      Architect.request().get(`/external/competition-entries/get/${this.id}?page=${this.currentPage}`)
        .then((response) => {
          this.entries = response.data.entrants.data;
        });
    },
  },
};
</script>
