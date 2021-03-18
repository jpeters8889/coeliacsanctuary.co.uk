import Vue from "vue";

const WhereToEatMap = () => import("~/WhereToEat/Tabs/WhereToEatMap" /* webpackChunkName: "chunk-wte-map" */);

Vue.component('wheretoeat-tabs-map', WhereToEatMap);
