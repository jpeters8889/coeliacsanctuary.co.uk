import Vue from "vue";

const StaticMap = () => import("~/Maps/StaticMap" /* webpackChunkName: "chunk-static-map" */);

Vue.component('static-map', StaticMap);
