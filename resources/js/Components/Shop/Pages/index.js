import Vue from 'vue';

const TravelCardSearch = () => import('~/Shop/Pages/TravelCardSearch' /* webpackChunkName: "chunk-travel-card-search" */);

Vue.component('ShopPagesTravelCardSearch', TravelCardSearch);
