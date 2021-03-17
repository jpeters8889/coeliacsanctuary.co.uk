import Vue from "vue";

const ProductImages = () => import("~/Shop/Products/ProductImages" /* webpackChunkName: "chunk-product-images" */);
const ProductAddToBasket = () => import("~/Shop/Products/ProductAddToBasket" /* webpackChunkName: "chunk-product-add-basket" */);

Vue.component('product-add-basket', ProductAddToBasket);
Vue.component('product-images', ProductImages);
