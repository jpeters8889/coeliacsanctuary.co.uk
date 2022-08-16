import Vue from 'vue';

const Reviews = () => import('~/Shop/Products/Reviews/Reviews' /* webpackChunkName: "chunk-product-reviews" */);

Vue.component('ShopProductReviews', Reviews);
