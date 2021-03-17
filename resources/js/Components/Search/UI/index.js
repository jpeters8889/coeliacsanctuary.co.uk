import Vue from 'vue';

const HeaderSearch = () => import("~/Search/UI/HeaderSearch" /* webpackChunkName: "preload-header-search" */);
const QuickSearch = () => import("~/Search/UI/QuickSearch" /* webpackChunkName: "preload-quick-search" */);

Vue.component('header-search', HeaderSearch);
Vue.component('quick-search', QuickSearch);
