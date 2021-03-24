import Vue from 'vue';

const WhereToEatQuickSearch = () => import('~/WhereToEat/UI/WhereToEatQuickSearch' /* webpackChunkName: "chunk-wte-quick-search" */);
const WhereToEatDailyUpdateSubscribe = () => import('~/WhereToEat/UI/WhereToEatDailyUpdateSubscribe' /* webpackChunkName: "chunk-wte-subscribe" */)

Vue.component('wheretoeat-ui-quick-search', WhereToEatQuickSearch)
Vue.component('wheretoeat-ui-daily-update-subscribe', WhereToEatDailyUpdateSubscribe);
