import Vue from "vue";

const ModuleListIndex = () => import("~/Modules/UI/ModuleListIndex" /* webpackChunkName: "chunk-module-list-index" */);

Vue.component('module-list-index', ModuleListIndex);
