import Vue from "vue";

const WhereToEatPlaceRequestForm = () => import("~/WhereToEat/Pages/WhereToEatPlaceRequestForm" /* webpackChunkName: "chunk-wte-place-request" */);
const WhereToEatList = () => import("~/WhereToEat/Pages/WhereToEatList" /* webpackChunkName: "chunk-wte-list" */);
const WhereToEatBrowse = () => import("~/WhereToEat/Pages/WhereToEatBrowse" /* webpackChunkName: "chunk-wte-browse" */);

Vue.component('wheretoeat-pages-place-request', WhereToEatPlaceRequestForm);
Vue.component('wheretoeat-page-list', WhereToEatList);
Vue.component('wheretoeat-page-browse', WhereToEatBrowse);
