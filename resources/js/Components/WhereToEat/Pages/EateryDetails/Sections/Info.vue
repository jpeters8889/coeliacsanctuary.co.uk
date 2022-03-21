<template>
  <div class="page-box">
    <template v-if="eatery.restaurants.length">
      <div
        v-for="restaurant in eatery.restaurants"
        :key="restaurant.id"
      >
        <h4
          v-if="restaurant.restaurant_name"
          class="font-semibold"
        >
          {{ restaurant.restaurant_name }}
        </h4>

        <p class="text-sm">
          {{ restaurant.info }}
        </p>
      </div>
    </template>

    <template v-else>
      <p>{{ eatery.info }}</p>
    </template>

    <a
      class="cursor-pointer text-xs italic text-grey-dark cursor-pointer mt-2 font-semibold transition hover:text-grey-darkest"
      @click.prevent="showReportPlaceModal = true"
    >
      Is there a problem with this location? Let us know.
    </a>

    <portal
      v-if="showReportPlaceModal"
      to="modal"
    >
      <modal :title="'Report ' + eatery.name">
        <report-place-modal :place="eatery" />
      </modal>
    </portal>
  </div>
</template>

<script>
import WhereToEatReportPlace from '~/WhereToEat/Modals/WhereToEatReportPlace';

const Modal = () => import('~/Global/UI/Modal' /* webpackChunkName: "chunk-modal" */);

export default {
  components: {
    modal: Modal,
    'report-place-modal': WhereToEatReportPlace,
  },

  props: {
    eatery: {
      type: Object,
      required: true,
    },
  },

  data: () => ({
    showReportPlaceModal: false,
  }),

  mounted() {
    this.$root.$on('modal-closed', () => {
      this.showReportPlaceModal = false;
    });
  },
};
</script>
