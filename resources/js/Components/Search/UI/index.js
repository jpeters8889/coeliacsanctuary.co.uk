import Vue from 'vue';

const HeaderSearch = () => import("~/Search/UI/HeaderSearch" /* webpackChunkName: "preload-header-search" */);
const QuickSearch = () => import("~/Search/UI/QuickSearch" /* webpackChunkName: "preload-quick-search" */);
const BlogSearch = () => import("~/Search/UI/BlogSearch" /* webpackChunkName: "chunk-blog-search" */);
const RecipeSearch = () => import("~/Search/UI/RecipeSearch" /* webpackChunkName: "chunk-recipe-search" */);
const ReviewSearch = () => import("~/Search/UI/ReviewSearch" /* webpackChunkName: "chunk-review-search" */);
const WhereToEatSearch = () => import("~/Search/UI/WhereToEatSearch" /* webpackChunkName: "chunk-wte-search" */);

Vue.component('search-ui-header', HeaderSearch);
Vue.component('search-ui-quick', QuickSearch);
Vue.component('search-ui-blog-widget', BlogSearch);
Vue.component('search-ui-recipe-widget', RecipeSearch);
Vue.component('search-ui-review-widget', ReviewSearch);
Vue.component('search-ui-wheretoeat-widget', WhereToEatSearch);
