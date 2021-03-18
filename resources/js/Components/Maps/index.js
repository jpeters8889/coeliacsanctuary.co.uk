import Vue from "vue";

const StaticMap = () => import("~/Maps/Static" /* webpackChunkName: "chunk-static-map" */);

Vue.component('map-static', StaticMap);
