import Vue from 'vue';

const WhereToEatDailyUpdateSubscribe = () => import('~/WhereToEat/UI/WhereToEatDailyUpdateSubscribe' /* webpackChunkName: "chunk-wte-subscribe" */);
const WhereToEatIndexCountry = () => import('~/WhereToEat/UI/WhereToEatIndexCountry' /* webpackChunkName: "chunk-wte-index-country" */);

Vue.component('WheretoeatUiDailyUpdateSubscribe', WhereToEatDailyUpdateSubscribe);
Vue.component('WheretoeatUiIndexCountry', WhereToEatIndexCountry);
