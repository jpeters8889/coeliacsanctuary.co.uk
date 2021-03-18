import Vue from "vue";

const ProductImages = () => import("~/Shop/Products/ProductImages" /* webpackChunkName: "chunk-product-images" */);
const ProductAddToBasket = () => import("~/Shop/Products/ProductAddToBasket" /* webpackChunkName: "chunk-product-add-basket" */);

Vue.component('shop-product-add-basket', ProductAddToBasket);
Vue.component('shop-product-images', ProductImages);
