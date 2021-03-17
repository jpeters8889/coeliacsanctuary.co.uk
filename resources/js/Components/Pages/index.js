import Vue from "vue";

const HomepageHeros = () => import("~/Pages/HomepageHeros" /* webpackChunkName: "chunk-home-heros" */);
const Competition = () => import('~/Pages/Competition' /* webpackChunkName: "chunk-competition" */)

Vue.component('coeliac-home-heros', HomepageHeros);
Vue.component('competition', Competition);
