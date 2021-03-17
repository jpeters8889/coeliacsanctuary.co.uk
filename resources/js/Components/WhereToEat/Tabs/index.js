import Vue from "vue";

const WhereToEatMap = () => import("~/WhereToEat/Tabs/WhereToEatMap" /* webpackChunkName: "chunk-wte-map" */);
const WhereToEatList = () => import("~/WhereToEat/Tabs/WhereToEatList" /* webpackChunkName: "chunk-wte-list" */);

Vue.component('wheretoeat-list', WhereToEatList);
Vue.component('wheretoeat-map', WhereToEatMap);
