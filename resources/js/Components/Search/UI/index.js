import Vue from 'vue';

const HeaderSearch = () => import('~/Search/UI/HeaderSearch' /* webpackChunkName: "preload-header-search" */);
const QuickSearch = () => import('~/Search/UI/QuickSearch' /* webpackChunkName: "preload-quick-search" */);
const BlogSearch = () => import('~/Search/UI/BlogSearch' /* webpackChunkName: "chunk-blog-search" */);
const RecipeSearch = () => import('~/Search/UI/RecipeSearch' /* webpackChunkName: "chunk-recipe-search" */);
const ReviewSearch = () => import('~/Search/UI/ReviewSearch' /* webpackChunkName: "chunk-review-search" */);
const WhereToEatSearch = () => import('~/Search/UI/WhereToEatSearch' /* webpackChunkName: "chunk-wte-search" */);

Vue.component('SearchUiHeader', HeaderSearch);
Vue.component('SearchUiQuick', QuickSearch);
Vue.component('SearchUiBlogWidget', BlogSearch);
Vue.component('SearchUiRecipeWidget', RecipeSearch);
Vue.component('SearchUiReviewWidget', ReviewSearch);
Vue.component('SearchUiWheretoeatWidget', WhereToEatSearch);
