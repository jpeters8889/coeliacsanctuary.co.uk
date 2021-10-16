import Vue from 'vue';

const HomepageHeros = () => import('~/Pages/HomepageHeros' /* webpackChunkName: "chunk-home-heros" */);
const Competition = () => import('~/Pages/Competition' /* webpackChunkName: "chunk-competition" */);

Vue.component('PageHomeHeros', HomepageHeros);
Vue.component('PageCompetition', Competition);
