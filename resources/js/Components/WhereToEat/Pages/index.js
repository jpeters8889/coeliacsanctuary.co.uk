import Vue from 'vue';
import '~/WhereToEat/Pages/EateryDetails';

const WhereToEatPlaceRequestForm = () => import('~/WhereToEat/Pages/WhereToEatPlaceRequestForm' /* webpackChunkName: "chunk-wte-place-request" */);
const WhereToEatList = () => import('~/WhereToEat/Pages/WhereToEatList' /* webpackChunkName: "chunk-wte-list" */);
const WhereToEatBrowse = () => import('~/WhereToEat/Pages/WhereToEatBrowse' /* webpackChunkName: "chunk-wte-browse" */);

Vue.component('WheretoeatPagesPlaceRequest', WhereToEatPlaceRequestForm);
Vue.component('WheretoeatPageList', WhereToEatList);
Vue.component('WheretoeatPageBrowse', WhereToEatBrowse);
