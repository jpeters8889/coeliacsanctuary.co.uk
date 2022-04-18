import Vue from 'vue';

const EateryDetails = () => import('~/WhereToEat/Pages/EateryDetails/EateryDetails' /* webpackChunkName: "chunk-wte-page-eatery-details" */);

Vue.component('WheretoeatPageEateryDetails', EateryDetails);
