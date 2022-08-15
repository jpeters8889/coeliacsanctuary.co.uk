import Vue from 'vue';

const TravelCardSearch = () => import('~/Shop/Pages/TravelCardSearch' /* webpackChunkName: "chunk-travel-card-search" */);
const ReviewMyOrder = () => import('~/Shop/Pages/ReviewMyOrder' /* webpackChunkName: "chunk-review-my-order" */);

Vue.component('ShopPagesTravelCardSearch', TravelCardSearch);
Vue.component('ShopReviewMyOrder', ReviewMyOrder);
