<template>
  <div>
    <div
      class="flex p-2 justify-between flex-col md:flex-row"
      :class="!isApproved ? 'bg-red-200' : ''"
    >
      <div class="flex flex-col md:w-4/5">
        <h3 class="text-lg text-blue-800 font-semibold">
          {{ data.place_name }}
        </h3>
        <span class="font-semibold text-sm">{{ data.place_location }}</span>
        <div
          class="mb-1"
          v-html="data.place_details"
        />
        <span class="italic">{{ data.name }}, {{ data.email }}</span>
      </div>
      <div class="font-semibold mt-1 flex flex-col md:w-1/5">
        <div class="mb-1 flex flex-col">
          <div
            v-for="info in information"
            class="flex flex-col leading-none mb-1"
          >
            <strong class="text-blue-700 font-semibold flex-1">{{ info.title }}</strong>
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
            class="button button-positive py-1 text-sm px-2 rounded mb-1"
            @click.prevent="showConvertModal = true"
          >
            Convert to Eatery
          </button>

          <button
            class="button button-primary py-1 text-sm px-2 rounded mb-1"
            @click.prevent="showApproveModal = true"
          >
            Complete
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
        title="Delete Place Request"
      >
        <div class="w-full flex flex-col justify-center items-center leading-none">
          <p class="text-xl">
            Are you sure you want to delete this recommendation?
          </p>
          <div class="mt-4">
            <button
              class="button button-negative button-default mr-2"
              @click.prevent="deleteRecommendation()"
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
      v-if="showConvertModal"
      to="modal"
    >
      <modal
        id="convert"
        title="Convert Place Request"
      >
        <div class="w-full flex flex-col justify-center items-center leading-none">
          <p class="text-xl">
            Are you sure you want to convert this request to an eatery? This will create a new eatery in the
            database marked as hidden with the basic data completed.
          </p>
          <div class="mt-4">
            <button
              class="button button-positive button-default mr-2"
              @click.prevent="convertRecommendation()"
            >
              Convert
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

    <portal
      v-if="showApproveModal"
      to="modal"
    >
      <modal
        id="complete"
        title="Complete Place Request"
      >
        <div class="w-full flex flex-col justify-center items-center leading-none">
          <p class="text-xl">
            Are you sure you want to mark this place recommendation as completed?
          </p>
          <div class="mt-4">
            <button
              class="button button-positive button-default mr-2"
              @click.prevent="completeRecommendation()"
            >
              Complete
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
    showConvertModal: false,
  }),

  computed: {
    isApproved() {
      return !!this.data.completed === true;
    },

    information() {
      return [
        {
          title: 'Created At',
          text: this.formatDate(this.data.created_at),
        },
      ];
    },
  },

  mounted() {
    Architect.$on('modal-close', (modal) => {
      switch (modal.id) {
        case 'delete':
          this.showDeleteModal = false;
          break;
        case 'convert':
          this.showConvertModal = false;
          break;
        case 'complete':
          this.showApproveModal = false;
          break;
      }
    });
  },

  methods: {
    deleteRecommendation() {
      window.Architect.request().delete(`/external/coeliac-place-recommendations/delete/${this.data.id}`).then(() => {
        window.Architect.success('Place Report Deleted');
        this.showDeleteModal = false;
      });
    },

    completeRecommendation() {
      window.Architect.request().put(`/external/coeliac-place-recommendations/complete/${this.data.id}`).then(() => {
        window.Architect.success('Place Report Completed');
        this.showApproveModal = false;
        this.data.completed = true;
      });
    },

    convertRecommendation() {
      window.Architect.request().post(`/external/coeliac-place-recommendations/convert/${this.data.id}`).then((response) => {
        if (response.data.error) {
          window.Architect.error('There was an error converting the location, please add manually.');
          this.showConvertModal = false;
          console.log(response.data.message);

          return;
        }

        window.location.href = `/cs-adm/blueprints/wheretoeat/${response.data.id}`;
      });
    },

    formatDate(date) {
      return moment(date).format('DD/MM/YY HH:mm:ss');
    },
  },
};
</script>
