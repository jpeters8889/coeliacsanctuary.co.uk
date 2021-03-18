import Vue from 'vue';

const WhereToEatQuickSearch = () => import('~/WhereToEat/UI/WhereToEatQuickSearch' /* webpackChunkName: "chunk-wte-quick-search" */);

Vue.component('wheretoeat-ui-quick-search', WhereToEatQuickSearch)

