<template>
  <div class="relative">
    <div class="w-full flex">
      <div
        class="w-full flex flex-col"
        :class="currentTown !== 'Nationwide' && currentTown !== ''? 'sm:w-3/5 lg:w-2/3' : ''"
      >
        <div class="flex justify-between">
          <div class="flex-1 mb-4">
            <h2 class="text-2xl font-semibold">
              <a
                :href="eateryLink(place)"
                class=" hover:text-blue-dark hover:underline"
              >
                {{ placeName }}
              </a>
            </h2>
            <h3
              v-if="currentTown !== 'Nationwide' && currentTown !== ''"
              class="text-sm font-semibold text-grey-darker"
            >
              <a
                v-if="isNationwide"
                href="/wheretoeat/nationwide"
                class="hover:text-black"
              >Nationwide Chain<br></a>
              <span>{{ place.venue_type.venue_type }}</span>
              <span v-if="place.cuisine && place.cuisine.cuisine !== 'English'">
                - {{ place.cuisine.cuisine }}
              </span>
            </h3>

            <a
              v-if="place.website"
              class="text-xs font-semibold text-grey hover:text-black transition-all ease-in-out"
              :href="place.website"
              target="_blank"
            >
              <font-awesome-icon
                :icon="['fas', 'external-link-alt']"
                class="mr-px"
              />
              Visit Website
            </a>
          </div>

          <div
            v-if="currentTown !== 'Nationwide' && currentTown !== ''"
            class="w-6 pt-2 xs:w-7"
          >
            <img
              :src="place.icon"
              alt=""
              width="100%"
              height="100%"
            >
          </div>
        </div>

        <div class="w-full flex">
          <div class="w-full flex flex-col space-y-2 md:space-y-4">
            <template v-if="place.restaurants.length">
              <div
                v-for="restaurant in place.restaurants"
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

            <p v-if="place.restaurants.length === 0">
              {{ place.info }}
            </p>

            <div
              v-if="currentTown !== 'Nationwide' && currentTown !== ''"
              class="flex flex-col mt-2 font-semibold text-grey-darkest"
            >
              <span v-if="place.distance">Around {{ place.distance }} miles away...<br>&nbsp;</span>

              <span
                class="block"
                v-html="placeAddress.replaceAll('<br />', ', ')"
              />
              <span>{{ place.phone }}</span>
            </div>
          </div>
        </div>
      </div>

      <div
        v-if="currentTown !== 'Nationwide' && currentTown !== ''"
        class="hidden sm:block pl-4 sm:w-2/5 lg:w-1/3"
      >
        <map-static v-bind="latLng" />
      </div>
    </div>

    <div class="w-full flex flex-col mt-2 space-y-3">
      <div
        v-if="place.user_reviews.length > 0"
        class="flex justify-between items-center sm:flex-row-reverse"
      >
        <span class="flex-1 sm:mr-2">
          Rated <strong>{{ place.average_rating }} stars</strong> from
          <strong>{{ place.user_reviews.length }} review{{ place.user_reviews.length > 1 ? 's' : '' }}</strong>
        </span>

        <global-ui-stars
          :stars="place.average_rating"
          half-star="star-half-alt"
          show-all
        />
      </div>

      <div
        class="bg-gradient-to-br from-blue/30 to-blue-light/30 rounded text-center transition duration-500 hover:from-blue/50 hover:to-blue-light/50"
      >
        <a
          :href="eateryLink(place)"
          class="p-2 block"
        >
          Read more about <strong>{{ place.name }}</strong>,
          {{ place.user_reviews.length > 0 ? ' read experiences from other people' : '' }}
          and leave your review.
        </a>
      </div>
    </div>
  </div>
</template>

<script>
import FormatsDates from '@/Mixins/FormatsDates';

export default {
  mixins: [FormatsDates],

  props: {
    place: {
      type: Object,
      required: true,
    },
    currentTown: {
      type: String,
      required: false,
      default: '',
    },
  },

  data: () => ({
    showReportLinks: false,
    showModal: false,
  }),

  computed: {
    isNationwide() {
      return this.place.is_nationwide;
    },

    placeName() {
      if (this.isNationwide && this.place.branch && this.place.branch.name) {
        return `${this.place.branch.name} - (${this.place.name})`;
      }

      return this.place.name;
    },

    placeAddress() {
      if (this.isNationwide && this.currentTown !== 'Nationwide' && this.currentTown !== '') {
        return this.place.branch.address;
      }

      return this.place.address;
    },

    latLng() {
      if (this.isNationwide && this.currentTown !== 'Nationwide' && this.currentTown !== '') {
        return {
          lat: this.place.branch.lat,
          lng: this.place.branch.lng,
        };
      }

      return {
        lat: this.place.lat,
        lng: this.place.lng,
      };
    },
  },

  methods: {
    eateryLink(place) {
      if (this.isNationwide && this.currentTown !== 'Nationwide' && this.currentTown !== '') {
        return `/wheretoeat/nationwide/${place.slug}/${place.branch.slug}`;
      }

      if (place.county.slug === 'nationwide') {
        return `/wheretoeat/nationwide/${place.slug}`;
      }

      return `/wheretoeat/${place.county.slug}/${place.town.slug}/${place.slug}`;
    },
  },
};
</script>
