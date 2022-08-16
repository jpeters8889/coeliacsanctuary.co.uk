<template>
  <div>
    <div
      class="flex p-2 justify-between flex-col md:flex-row"
      :class="!isApproved ? 'bg-red-200' : ''"
    >
      <div class="flex flex-col md:w-4/5">
        <template v-if="data.body">
          <div class="mb-1">
            <h2 class="font-semibold text-highlight text-xl">
              {{ data.eatery.full_name }}
            </h2>
          </div>

          <div class="mb-2">
            <div v-html="data.body" />
            <span class="font-semibold">{{ data.name }}</span>
          </div>

          <div v-if="data.images && data.images.length">
            <h2 class="text-lg font-semibold">
              Review Images
            </h2>

            <div class="flex flex-wrap">
              <div
                v-for="image in data.images"
                :key="image.id"
                class="p-2 flex items-center justify-center"
              >
                <a
                  :href="image.path"
                  target="_blank"
                >
                  <img
                    :src="image.thumb"
                    style="max-width: 150px; max-height: 150px;"
                  >
                </a>
              </div>
            </div>
          </div>
        </template>

        <div v-else>
          <div class="mb-1">
            <h2 class="font-semibold text-highlight text-xl">
              {{ data.eatery.full_name }}
            </h2>
          </div>

          <em>No rating text...</em>
        </div>
      </div>

      <div class="font-semibold mt-1 flex flex-col md:w-1/5">
        <div class="mb-1 flex flex-col">
          <div
            v-for="info in information"
            :key="info.title"
            class="flex leading-none mb-1"
          >
            <strong class="text-blue-500 font-semibold flex-1">{{ info.title }}</strong>
            <span>{{ info.text }}</span>
          </div>
        </div>

        <button
          class="button button-negative py-1 text-sm px-2 rounded mb-1"
          @click.prevent="showDeleteModal = true"
        >
          Delete
        </button>
        <template v-if="!isApproved">
          <button
            class="button button-primary py-1 text-sm px-2 rounded mb-1"
            @click.prevent="showApproveModal = true"
          >
            Approve
          </button>
        </template>
      </div>
    </div>

    <portal
      v-if="showDeleteModal"
      to="modal"
    >
      <modal
        id="delete"
        title="Delete Rating"
      >
        <div class="w-full flex flex-col justify-center items-center leading-none">
          <p class="text-xl">
            Are you sure you want to delete this rating?
          </p>
          <div class="mt-4">
            <button
              class="button button-negative button-default mr-2"
              @click.prevent="deleteRating()"
            >
              Delete
            </button>

            <button
              class="button button-primary button-default"
              @click.prevent="showDeleteModal = !showDeleteModal"
            >
              Cancel
            </button>
          </div>
        </div>
      </modal>
    </portal>

    <portal
      v-if="showApproveModal"
      to="modal"
    >
      <modal
        id="approve"
        title="Approve Rating"
      >
        <div class="w-full flex flex-col justify-center items-center leading-none">
          <p class="text-xl">
            Are you sure you want to approve this rating?
          </p>
          <div class="mt-4">
            <button
              class="button button-positive button-default mr-2"
              @click.prevent="approveRating()"
            >
              Approve
            </button>

            <button
              class="button button-primary button-default"
              @click.prevent="showApproveModal = !showApproveModal"
            >
              Cancel
            </button>
          </div>
        </div>
      </modal>
    </portal>
  </div>
</template>

<script>
export default {
  props: {
    data: Object | Array,
    labels: Object | Array,
  },

  data: () => ({
    showDeleteModal: false,
    showApproveModal: false,
  }),

  computed: {
    isApproved() {
      return !!this.data.approved === true;
    },

    information() {
      return [
        {
          title: 'Rating',
          text: this.data.rating,
        },
        {
          title: 'Average Rating',
          text: `${this.data.average_rating} (${this.data.number_of_ratings})`,
        },
        {
          title: 'Method',
          text: this.data.method,
        },
        this.data.how_expensive ? {
          title: 'Expense Rating',
          text: this.data.how_expensive,
        } : null,
        this.data.food_rating ? {
          title: 'Food Rating',
          text: this.data.food_rating,
        } : null,
        this.data.service_rating ? {
          title: 'Service Rating',
          text: this.data.service_rating,
        } : null,
      ].filter((item) => item !== null);
    },
  },

  mounted() {
    console.log(this.information);

    Architect.$on('modal-close', (modal) => {
      switch (modal.id) {
        case 'delete':
          this.showDeleteModal = false;
          break;
        case 'approve':
          this.showApproveModal = false;
          break;
      }
    });
  },

  methods: {
    deleteRating() {
      window.Architect.request().delete(`/external/coeliac-wte-ratings/delete/${this.data.id}`).then(() => {
        window.Architect.success('Rating Deleted');
        window.location.reload();
      });
    },

    approveRating() {
      window.Architect.request().put(`/external/coeliac-wte-ratings/approve/${this.data.id}`).then(() => {
        window.Architect.success('Rating Approved');
        window.location.reload();
      });
    },
  },
};
</script>
