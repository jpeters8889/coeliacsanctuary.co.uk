import Vue from 'vue';

const BasketHeaderWidget = () => import('~/Shop/Basket/Page/BasketHeaderWidget' /* webpackChunkName: "chunk-basket-header-widget" */);
const BasketPage = () => import('~/Shop/Basket/Page/BasketPage' /* webpackChunkName: "chunk-basket-page" */);

Vue.component('ShopBasketPageHeaderWidget', BasketHeaderWidget);
Vue.component('ShopBasketPage', BasketPage);
