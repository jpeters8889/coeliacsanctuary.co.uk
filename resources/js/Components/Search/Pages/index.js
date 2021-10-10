import Vue from 'vue';

const SiteSearch = () => import('~/Search/Pages/SiteSearch' /* webpackChunkName: "chunk-site-search" */);

Vue.component('SearchPage', SiteSearch);
