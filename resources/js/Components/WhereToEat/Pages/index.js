import Vue from "vue";

const WhereToEatPlaceRequestForm = () => import("~/WhereToEat/Pages/WhereToEatPlaceRequestForm" /* webpackChunkName: "chunk-wte-place-request" */);
const WhereToEatList = () => import("~/WhereToEat/Pages/WhereToEatList" /* webpackChunkName: "chunk-wte-list" */);

Vue.component('wheretoeat-pages-place-request', WhereToEatPlaceRequestForm);
Vue.component('wheretoeat-page-list', WhereToEatList);
