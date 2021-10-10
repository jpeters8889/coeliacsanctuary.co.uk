import Vue from 'vue';

const AddBasketTrigger = () => import('~/Shop/Basket/UI/AddBasketTrigger' /* webpackChunkName: "chunk-add-basket-trigger" */);
const BasketSideBar = () => import('~/Shop/Basket/UI/BasketSideBar' /* webpackChunkName: "chunk-basket-sidebar" */);
const BasketQuickLink = () => import('~/Shop/Basket/UI/BasketQuickLink' /* webpackChunkName: "chunk-basket-quick-link" */);
const BasketQuantitySwitcher = () => import('~/Shop/Basket/UI/BasketQuantitySwitcher' /* webpackChunkName: "chunk-basket-quantity-switcher" */);

Vue.component('ShopBasketUiAddProduct', AddBasketTrigger);
Vue.component('ShopBasketUiFloatingLink', BasketQuickLink);
Vue.component('ShopBasketUiQuantitySwitcher', BasketQuantitySwitcher);
Vue.component('ShopBasketUiSidebar', BasketSideBar);
