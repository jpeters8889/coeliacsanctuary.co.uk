import Vue from 'vue';

const WhereToEatDailyUpdateSubscribe = () => import('~/WhereToEat/UI/WhereToEatDailyUpdateSubscribe' /* webpackChunkName: "chunk-wte-subscribe" */)
const WhereToEatIndexCountry = () => import('~/WhereToEat/UI/WhereToEatIndexCountry' /* webpackChunkName: "chunk-wte-index-country" */)

Vue.component('wheretoeat-ui-daily-update-subscribe', WhereToEatDailyUpdateSubscribe);
Vue.component('wheretoeat-ui-index-country', WhereToEatIndexCountry);
